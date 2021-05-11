<?php


namespace restful\controllers;

use common\models\FiveForces;

use common\models\Salesman;
use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use Yii;
use yii\helpers\Inflector;

class FiveforcesController extends SController
{

   
    public function actionList()
    {
        
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = FiveForces::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);

        $query->orderBy('id DESC');
        $query->where('salesman_id=:salesman', [':salesman' => Yii::$app->user->identity->id]);
        $list = $query->all();
        Log::trace("Download five forces List");
        return ['profiles' => $list];
    }

  

   
    public function actionManage()
    {
        $FiveForces = null;
        if (Yii::$app->request->isPut) {
            $uid = Yii::$app->request->get('uid');
            $FiveForces = FiveForces::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        }
        else
            if (Yii::$app->request->isPost) {
                $FiveForces = new FiveForces();
                $FiveForces->salesman_id = Yii::$app->user->identity->id;
            }

        if (!$FiveForces) {
            $this->error("FiveForces Profile not found");
            return null;
        }

        $isNew = $FiveForces->isNewRecord;

        $data = Yii::$app->request->post('data');
        if (!empty($data) && is_array($data)) {
            $relations = [];
            foreach ($data as $name => $value) {
                if ($FiveForces->hasAttribute($name)) {
                    // attribute field
                    $FiveForces->setAttribute($name, $value);
                } else if ($FiveForces->hasProperty($name)) {
                    // relational field
                    $relations[] = function ($FiveForces) use ($name, $value) {
                        $this->saveFiveForcesNode($FiveForces, $name, $value);
                    };
                }
            }
            if ($FiveForces->save()) {
                if (!empty($relations) && is_array($relations)) {
                    foreach ($relations as $relation) {
                        $relation($FiveForces);
                    }
                }
                if (!$FiveForces->isNewRecord) {
                  
                }
            }
        }

        $FiveForces->refresh();
        $this->composeNotificationEmail($FiveForces, $isNew, true);
        $this->composeNotificationEmail($FiveForces, $isNew, false);
        Log::trace("Save FiveForces Profile ".$FiveForces->name);
        return ['FiveForces' => $FiveForces];
    }

    private function composeNotificationEmail($FiveForces, $isNew, $sendToAdmin)
    {
        try {
            $email = Yii::$app->mailer->compose();
            $email->setFrom(Yii::$app->mailer->transport->getUsername());
               $email->setHtmlBody(Yii::$app->mailer->render('FiveForces', ['FiveForces' => $FiveForces], Yii::$app->mailer->htmlLayout));

            $modelSalesman = Salesman::findOne(Yii::$app->user->identity->id);
            if($sendToAdmin){
                $email->setTo(Yii::$app->params['FiveForcesadminEmail']);
                Log::trace("Send notification e-mail", Yii::$app->params['FiveForcesadminEmail'] );
            }
            else {
                $email->setTo($modelSalesman->user->email);
                Log::trace("Send notification e-mail", $modelSalesman->user->email);
            }
            if($isNew)  // insert
                $email->setSubject('SalePRO: New Five Forces '.$FiveForces->name.' was added by '.$modelSalesman->name);
            else        // update
                $email->setSubject( 'SalePRO:  Five Forces data '.$FiveForces->name.' was updated by '.$modelSalesman->name);

            $email->send();
        }
        catch (\Swift_TransportException $STe) {
            Log::trace("Send notification e-mail error: ".$STe->getMessage());
        }
        catch (Exception $e) {
            Log::trace("composeNotificationEmail general error");
        }
    }

    private function saveFiveForcesNode($parentModel, $name, $list, $parentName = null)
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
                                $this->saveFiveForcesNode($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if ($parentName) {
                        if ($parentModel->hasProperty('FiveForces')) {
                            $m->FiveForces_id = $parentModel->FiveForces->id;
                        }
                        $pAttr = Inflector::camel2id($parentName, '_') . '_id';
                        if ($m->hasAttribute($pAttr)) {
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    } else {
                        $m->FiveForces_id = $parentModel->id;
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
