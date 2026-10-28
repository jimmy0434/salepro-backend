<?php


namespace restful\controllers;

use common\models\Rdr;
use common\models\Salesman; 
use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use yii\helpers\Inflector;
use Yii;



class RdrController extends SController
{

   
    public function actionList()
    {
        
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = Rdr::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);

        $query->orderBy('id DESC');
        
  
        
        $list = $query->all();
       // Log::trace("Download Rdr List");
        return ['profiles' => $list];
    }

  
    public function actionManage()
    {
        $Rdr = null;
        if (Yii::$app->request->isPut) {
            $uid = Yii::$app->request->get('uid');
            $Rdr = Rdr::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        } else if (Yii::$app->request->isPost) {
            $Rdr = new Rdr();
            $Rdr->salesman_id = Yii::$app->user->identity->id;
        }
    
        if (!$Rdr) {
            $this->error("Rdr Profile not found");
            return null;
        }
    
        $isNew = $Rdr->isNewRecord;
    
        $data = Yii::$app->request->post('data');
        if (!empty($data) && is_array($data)) {
            $relations = [];
            foreach ($data as $name => $value) {
                if ($Rdr->hasAttribute($name)) {
                    $Rdr->setAttribute($name, $value);
                } else if ($Rdr->hasProperty($name)) {
                    $relations[] = function ($Rdr) use ($name, $value) {
                        $this->saveRdrNode($Rdr, $name, $value);
                    };
                }
            }
    
            // First save the Rdr to generate an ID if it's new
            if ($Rdr->save()) {
                // If the record is new, generate the reff field and save again
                if ($isNew) {
                    $this->generateReffField($Rdr);
                    
                    $Rdr->save(false); // Save again to persist the reff field
                }
    
                // Handle relations after the initial save
                if (!empty($relations) && is_array($relations)) {
                    foreach ($relations as $relation) {
                        $relation($Rdr);
                    }
                }
            }
        }
    
        $Rdr->refresh();
        $this->composeNotificationEmail($Rdr, $isNew, true);
        $this->composeNotificationEmail($Rdr, $isNew, false);
        return ['Rdr' => $Rdr];
    }
    
    // Helper method to generate the reff field
    private function generateReffField($Rdr)
    {
        $currentMonthYear = date('my'); // MMYY format
        $idFormatted = str_pad($Rdr->id, 3, '0', STR_PAD_LEFT); // 001 format
    
        // Mapping of field values to codes
        $fieldValue = $Rdr->bu; // Replace with the actual field used to determine the code
        $codeMapping = [
            'Compact' => 'K',
            'Easternpak' => 'K',
            'INDEVCO Paper Containers-IPC' => 'L',
            'INDEVCO Plastics' => 'L',
            'Interstate Inks' => 'L',
            'Masterpak' => 'L',
            'Masterpak-Nile' => 'E',
            'Micro-Epsilon' => 'L',
            'Modern Sack' => 'K',
            'Modern Tech' => 'K',
            'Multipak' => 'K',
            'NPPC' => 'K'
        ];
    
        $code = isset($codeMapping[$fieldValue]) ? $codeMapping[$fieldValue] : 'X'; // Default to 'X' if not found
        $Rdr->reff = "RDR#{$currentMonthYear}-{$idFormatted} {$code}";
    }
    

    private function composeNotificationEmail($Rdr, $isNew, $sendToAdmin)
    {
        try {
            $email = Yii::$app->mailer->compose();
            $email->setFrom(Yii::$app->mailer->transport->getUsername());
               $email->setHtmlBody(Yii::$app->mailer->render('Rdr', ['Rdr' => $Rdr], Yii::$app->mailer->htmlLayout));

            $modelSalesman = Salesman::findOne(Yii::$app->user->identity->id);
            if($sendToAdmin){
                $email->setTo([
                    Yii::$app->params['TarfEmail'],
                    'rouaida.abounaccoul@indevcogroup.com',
                    'tony.elchayeb@indevcogroup.com',
                    'alain.akiki@indevcogroup.com'
                ])
                ->setCc(Yii::$app->params['TarfCCEmail']);;
              //  Log::trace("Send notification e-mail", Yii::$app->params['TarfEmail'] );
            }
            else {
                $email->setTo($modelSalesman->user->email);
               // Log::trace("Send notification e-mail", $modelSalesman->user->email);
            }
            if ($isNew) { // Insert
                $email->setSubject('SalePRO: New Rdr  '. $Rdr->reff .' was added by ' . $modelSalesman->name);
            } else { // Update
                $email->setSubject('SalePRO: Rdr  '. $Rdr->reff . ' was updated by ' . $modelSalesman->name);
            }
            $email->send();
        }
        catch (\Swift_TransportException $STe) {
         Log::trace("Send notification e-mail error: ".$STe->getMessage());
        }
        catch (Exception $e) {
           Log::trace("composeNotificationEmail general error");
        }
    }

    private function saveRdrNode($parentModel, $name, $list, $parentName = null)
    {
        if ($parentModel->hasProperty($name)) {
            $oldList = $parentModel->$name;
            if (!empty($oldList) && is_array($oldList)) {
                foreach ($oldList as $oldModel) {
                    $oldModel->delete();
                }
            }
        }
        if (!empty($list) && is_array($list)) {
            $relations = [];
            foreach ($list as $data) {
                if (!empty($data) && is_array($data)) {
                    $c = '\\common\\models\\' . ucfirst($name);
                    $m = new $c();
                    foreach ($data as $attribute => $value) {
                        if ($m->hasAttribute($attribute)) {
                            // attribute field
                            $m->setAttribute($attribute, $value);
                        } else if ($m->hasProperty($attribute)) {
                            $relations[] = function ($m) use ($attribute, $value, $name) {
                                $this->saveRdrNode($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if ($parentName) {
                        if ($parentModel->hasProperty('Rdr')) {
                            $m->Rdr_id = $parentModel->Rdr->id;
                        }
                        $pAttr = Inflector::camel2id($parentName, '_') . '_id';
                        if ($m->hasAttribute($pAttr)) { 
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    } else {
                        $m->Rdr_id = $parentModel->id;
                    }
                    if ($m->save()) {
                        if (!empty($relations) && is_array($relations)) {
                            foreach ($relations as $relation) {
                                $relation($m);
                            }
                        }
                        $m = null;
                        $relations = [];
                    }
                }
            }
        }
    }
}
