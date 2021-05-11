<?php


namespace restful\controllers;

use common\models\SteepAnalysis;
use common\models\Salesman;
use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use yii\helpers\Inflector;
use Yii;



class SteepanalysisController extends SController
{

   
    public function actionList()
    {
        
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = SteepAnalysis::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);

        $query->orderBy('id DESC');
        
        //$query->where('status=:status or salesman_id=:salesman', [':status' => SteepAnalysis::STATUS_ENABLED, ':salesman' => Yii::$app->user->identity->id]);
        $query->ANDWhere('salesman_id=:salesman', [':salesman' => Yii::$app->user->identity->id]);
        
        $list = $query->all();
        Log::trace("Download SteepAnalysis List");
        return ['profiles' => $list];
    }

  

   
    public function actionManage()
    {
        $SteepAnalysis = null;
        if (Yii::$app->request->isPut) {
            $uid = Yii::$app->request->get('uid');
            $SteepAnalysis = SteepAnalysis::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        }
        else
            if (Yii::$app->request->isPost) {
                $SteepAnalysis = new SteepAnalysis();
                $SteepAnalysis->salesman_id = Yii::$app->user->identity->id;
            }

        if (!$SteepAnalysis) {
            $this->error("SteepAnalysis Profile not found");
            return null;
        }

        $isNew = $SteepAnalysis->isNewRecord;

        $data = Yii::$app->request->post('data');
        if (!empty($data) && is_array($data)) {
            $relations = [];
            foreach ($data as $name => $value) {
                if ($SteepAnalysis->hasAttribute($name)) {
                    // attribute field
                    $SteepAnalysis->setAttribute($name, $value);
                } else if ($SteepAnalysis->hasProperty($name)) {
                    // relational field
                    $relations[] = function ($SteepAnalysis) use ($name, $value) {
                        $this->saveSteepAnalysisNode($SteepAnalysis, $name, $value);
                    };
                }
            }
            if ($SteepAnalysis->save()) {
                if (!empty($relations) && is_array($relations)) {
                    foreach ($relations as $relation) {
                        $relation($SteepAnalysis);
                    }
                }
                if (!$SteepAnalysis->isNewRecord) {
                   // $SteepAnalysis->sendNotification();
                }
            }
        }

        $SteepAnalysis->refresh();
        $this->composeNotificationEmail($SteepAnalysis, $isNew, true);
        $this->composeNotificationEmail($SteepAnalysis, $isNew, false);
        Log::trace("Save SteepAnalysis Profile ".$SteepAnalysis->name);
        return ['SteepAnalysis' => $SteepAnalysis];
    }

    private function composeNotificationEmail($SteepAnalysis, $isNew, $sendToAdmin)
    {
        try {
            $email = Yii::$app->mailer->compose();
            $email->setFrom(Yii::$app->mailer->transport->getUsername());
               $email->setHtmlBody(Yii::$app->mailer->render('SteepAnalysis', ['SteepAnalysis' => $SteepAnalysis], Yii::$app->mailer->htmlLayout));

            $modelSalesman = Salesman::findOne(Yii::$app->user->identity->id);
            if($sendToAdmin){
                $email->setTo(Yii::$app->params['steepadminEmail']);
                Log::trace("Send notification e-mail", Yii::$app->params['steepadminEmail'] );
            }
            else {
                $email->setTo($modelSalesman->user->email);
                Log::trace("Send notification e-mail", $modelSalesman->user->email);
            }
            if($isNew)  // insert
                $email->setSubject('SalePRO: New SteepAnalysis '.$SteepAnalysis->name.' was added by '.$modelSalesman->name);
            else        // update
                $email->setSubject( 'SalePRO: Steep Analysis data '.$SteepAnalysis->name.' was updated by '.$modelSalesman->name);

            $email->send();
        }
        catch (\Swift_TransportException $STe) {
            Log::trace("Send notification e-mail error: ".$STe->getMessage());
        }
        catch (Exception $e) {
            Log::trace("composeNotificationEmail general error");
        }
    }

    private function saveSteepAnalysisNode($parentModel, $name, $list, $parentName = null)
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
                                $this->saveSteepAnalysisNode($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if ($parentName) {
                        if ($parentModel->hasProperty('SteepAnalysis')) {
                            $m->SteepAnalysis_id = $parentModel->SteepAnalysis->id;
                        }
                        $pAttr = Inflector::camel2id($parentName, '_') . '_id';
                        if ($m->hasAttribute($pAttr)) {
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    } else {
                        $m->SteepAnalysis_id = $parentModel->id;
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
