<?php


namespace restful\controllers;

use common\models\SectorOutlook;

use common\models\Salesman;
use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use Yii;
use yii\helpers\Inflector;

class SectoroutlookController extends SController
{

   
    public function actionList()
    {
        
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = SectorOutlook::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);

        $query->orderBy('id DESC');
        $query->where('salesman_id=:salesman', [':salesman' => Yii::$app->user->identity->id]);
        $list = $query->all();
        Log::trace("Download Sector Outlook List");
        return ['profiles' => $list];
    }

  

   
    public function actionManage()
    {
        $SectorOutlook = null;
        if (Yii::$app->request->isPut) {
            $uid = Yii::$app->request->get('uid');
            $SectorOutlook = SectorOutlook::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        }
        else
            if (Yii::$app->request->isPost) {
                $SectorOutlook = new SectorOutlook();
                $SectorOutlook->salesman_id = Yii::$app->user->identity->id;
            }

        if (!$SectorOutlook) {
            $this->error("Sector Outlook Profile not found");
            return null;
        }

        $isNew = $SectorOutlook->isNewRecord;

        $data = Yii::$app->request->post('data');
        if (!empty($data) && is_array($data)) {
            $relations = [];
            foreach ($data as $name => $value) {
                if ($SectorOutlook->hasAttribute($name)) {
                    // attribute field
                    $SectorOutlook->setAttribute($name, $value);
                } else if ($SectorOutlook->hasProperty($name)) {
                    // relational field
                    $relations[] = function ($SectorOutlook) use ($name, $value) {
                        $this->saveSectorOutlookNode($SectorOutlook, $name, $value);
                    };
                }
            }
            if ($SectorOutlook->save()) {
                if (!empty($relations) && is_array($relations)) {
                    foreach ($relations as $relation) {
                        $relation($SectorOutlook);
                    }
                }
                if (!$SectorOutlook->isNewRecord) {
                   // $SectorOutlook->sendNotification();
                }
            }
        }

        $SectorOutlook->refresh();
        $this->composeNotificationEmail($SectorOutlook, $isNew, true);
        $this->composeNotificationEmail($SectorOutlook, $isNew, false);
        Log::trace("Save SectorOutlook Profile ".$SectorOutlook->name);
        return ['SectorOutlook' => $SectorOutlook];
    }

    private function composeNotificationEmail($SectorOutlook, $isNew, $sendToAdmin)
    {
        try {
            $email = Yii::$app->mailer->compose();
            $email->setFrom(Yii::$app->mailer->transport->getUsername());
               $email->setHtmlBody(Yii::$app->mailer->render('SectorOutlook', ['SectorOutlook' => $SectorOutlook], Yii::$app->mailer->htmlLayout));

            $modelSalesman = Salesman::findOne(Yii::$app->user->identity->id);
            if($sendToAdmin){
                $email->setTo(Yii::$app->params['sectoroutlookadminEmail']);
                Log::trace("Send notification e-mail", Yii::$app->params['sectoroutlookadminEmail'] );
            }
            else {
                $email->setTo($modelSalesman->user->email);
                Log::trace("Send notification e-mail", $modelSalesman->user->email);
            }
            if($isNew)  // insert
                $email->setSubject('SalePRO: New Sector Outlook '.$SectorOutlook->name.' was added by '.$modelSalesman->name);
            else        // update
                $email->setSubject( 'SalePRO: Sector Outlook data '.$SectorOutlook->name.' was updated by '.$modelSalesman->name);

            $email->send();
        }
        catch (\Swift_TransportException $STe) {
            Log::trace("Send notification e-mail error: ".$STe->getMessage());
        }
        catch (Exception $e) {
            Log::trace("composeNotificationEmail general error");
        }
    }
    public function actionFile()
    {
        $uid = Yii::$app->request->get('uid');
        $sectoroutlook = SectorOutlook::find()->select('file')->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        Log::trace("Download Sector Outlook Meta File");
        return ['file' => $sectoroutlook->file];
    }
    private function saveSectorOutlookNode($parentModel, $name, $list, $parentName = null)
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
                                $this->saveSectorOutlookNode($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if ($parentName) {
                        if ($parentModel->hasProperty('SectorOutlook')) {
                            $m->SectorOutlook_id = $parentModel->SectorOutlook->id;
                        }
                        $pAttr = Inflector::camel2id($parentName, '_') . '_id';
                        if ($m->hasAttribute($pAttr)) {
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    } else {
                        $m->SectorOutlook_id = $parentModel->id;
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
