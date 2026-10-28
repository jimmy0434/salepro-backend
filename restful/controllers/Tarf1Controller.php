<?php


namespace restful\controllers;

use common\models\Tarf1;
use common\models\Salesman;

use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use Yii;
use yii\helpers\Inflector;


class Tarf1Controller extends SController
{

   
    public function actionList()
    {
        
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = Tarf1::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);

        $query->orderBy('id DESC');
        
  
        
        $list = $query->all();
       // Log::trace("Download Tarf1List");
        return ['profiles' => $list];
    }

  

    public function actionManage()
{
    $Tarf1 = null;
    if (Yii::$app->request->isPut) {
        $uid = Yii::$app->request->get('uid');
        $Tarf1 = Tarf1::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
    } else if (Yii::$app->request->isPost) {
        $Tarf1 = new Tarf1();
        $Tarf1->salesman_id = Yii::$app->user->identity->id;
    }

    if (!$Tarf1) {
        $this->error("Tarf1 Profile not found");
        return null;
    }

    $isNew = $Tarf1->isNewRecord;

    $data = Yii::$app->request->post('data');
    if (!empty($data) && is_array($data)) {
        $relations = [];
        foreach ($data as $name => $value) {
            if ($Tarf1->hasAttribute($name)) {
                $Tarf1->setAttribute($name, $value);
            } else if ($Tarf1->hasProperty($name)) {
                $relations[] = function ($Tarf1) use ($name, $value) {
                    $this->saveTarf1Node($Tarf1, $name, $value);
                };
            }
        }

        // Save Tarf1 initially to generate an ID if it's a new record
        if ($Tarf1->save()) {
            // If the record is new, generate the reff field and save again
            if ($isNew) {
                $this->generateReffField($Tarf1);
                $Tarf1->save(false); // Save again to persist the reff field
            }

            // Process any relational fields
            if (!empty($relations) && is_array($relations)) {
                foreach ($relations as $relation) {
                    $relation($Tarf1);
                }
            }

            if (!$Tarf1->isNewRecord) {
                // Uncomment if needed: $SteepAnalysis->sendNotification();
            }
        }
    }

    $Tarf1->refresh();
    $this->composeNotificationEmail($Tarf1, $isNew, true);
    $this->composeNotificationEmail($Tarf1, $isNew, false);
    Log::trace("Save Tarf1 Profile ");
    return ['Tarf1' => $Tarf1];
}

// Helper method to generate the reff field
private function generateReffField($Tarf1)
{
    $currentMonthYear = date('my'); // MMYY format
    $idFormatted = str_pad($Tarf1->id, 3, '0', STR_PAD_LEFT); // 001 format

    // Mapping of field values to codes
    $fieldValue = $Tarf1->bu; // Replace with the actual field used to determine the code
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
    $Tarf1->reff = "TARF#{$currentMonthYear}-{$idFormatted} {$code}";
}

    private function composeNotificationEmail($Tarf1, $isNew, $sendToAdmin)
    {
        try {
            $email = Yii::$app->mailer->compose();
            $email->setFrom(Yii::$app->mailer->transport->getUsername());
               $email->setHtmlBody(Yii::$app->mailer->render('Tarf1', ['Tarf1' => $Tarf1], Yii::$app->mailer->htmlLayout));

            $modelSalesman = Salesman::findOne(Yii::$app->user->identity->id);
            if($sendToAdmin){
                $email->setTo([
                    Yii::$app->params['TarfEmail'],
                    'rouaida.abounaccoul@indevcogroup.com',
                    'tony.elchayeb@indevcogroup.com',
                    'alain.akiki@indevcogroup.com'
                ])
                ->setCc(Yii::$app->params['TarfCCEmail']);;
               // Log::trace("Send notification e-mail", Yii::$app->params['TarfEmail'] );
            }
            else {
                $email->setTo($modelSalesman->user->email);
              //  Log::trace("Send notification e-mail", $modelSalesman->user->email);
            }
            if($isNew)  // insert
                $email->setSubject('SalePRO: New Tarf '. $Tarf1->reff .' was added by '.$modelSalesman->name);
            else        // update
                $email->setSubject( 'SalePRO: Tarf '. $Tarf1->reff .' was updated by '.$modelSalesman->name);

            $email->send();
        }
        catch (\Swift_TransportException $STe) {
            Log::trace("Send notification e-mail error: ".$STe->getMessage());
        }
        catch (Exception $e) {
            Log::trace("composeNotificationEmail general error");
        }
    }

    private function saveTarf1Node($parentModel, $name, $list, $parentName = null)
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
                                $this->saveTarf1Node($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if ($parentName) {
                        if ($parentModel->hasProperty('Tarf1')) {
                            $m->Tarf1_id = $parentModel->Tarf1->id;
                        }
                        $pAttr = Inflector::camel2id($parentName, '_') . '_id';
                        if ($m->hasAttribute($pAttr)) {
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    } else {
                        $m->Tarf1_id = $parentModel->id;
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
