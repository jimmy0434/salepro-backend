<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/7/2019
 * Time: 10:36 AM
 */

namespace restful\controllers;

use common\models\Competitor;
use common\models\Salesman;
use cnd\core\api\SController;
use cnd\admin\models\activerecords\Log;
use Yii;
use yii\helpers\Inflector;

class CompetitorController extends SController
{

    /**
     * @SWG\Get(
     *     path="/competitions",
     *     tags={"Competition"},
     *     summary="Retrieves all competitions",
     *     @SWG\Response(
     *         response = 200,
     *         description = "competitions response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=true, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=true, in="query", type="integer", description="Page Size default 25", default=25)
     * )
     */
    public function actionList()
    {
        //Competitor::$disableLogo = true;
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = Competitor::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        //$query->orderBy('name ASC'); // updated_at
        //$query->orderBy('updated_at DESC, created_at DESC, id DESC');
        $query->orderBy('id DESC');
        $query->where('status=:status or salesman_id=:salesman', [':status' => Competitor::STATUS_ENABLED, ':salesman' => Yii::$app->user->identity->id]);
        $list = $query->all();
        Log::trace("Download Competitors List");
        return ['profiles' => $list];
    }

    /**
     * @SWG\Get(
     *     path="/competitions/{uid}",
     *     tags={"Competition"},
     *     summary="Retrieves competition",
     *     @SWG\Response(
     *         response = 200,
     *         description = "competition response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The profile UID")
     * )
     */
    public function actionProfile()
    {
        $uid = Yii::$app->request->get('uid');
        //$competitor = Competitor::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        $competitor = Competitor::find()->where(['uid' => $uid])->one();
        Log::trace("Download Competitor Profile");
        return ['profile' => $competitor];
    }

    /**
     * @SWG\Get(
     *     path="/competitions/{uid}/logo",
     *     tags={"Competition"},
     *     summary="Retrieves competition logo",
     *     @SWG\Response(
     *         response = 200,
     *         description = "competition logo response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The profile UID")
     * )
     */
    public function actionLogo()
    {
        $uid = Yii::$app->request->get('uid');
        $competitor = Competitor::find()->select('logo')->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        Log::trace("Download Competitor Logo");
        return ['logo' => $competitor->logo];
    }

    /**
     * @SWG\Get(
     *     path="/competitions/{uid}/file",
     *     tags={"Competition"},
     *     summary="Retrieves competition file",
     *     @SWG\Response(
     *         response = 200,
     *         description = "competition file response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The profile UID")
     * )
     */
    public function actionFile()
    {
        $uid = Yii::$app->request->get('uid');
        $competitor = Competitor::find()->select('file')->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        Log::trace("Download Competitor Meta File");
        return ['file' => $competitor->file];
    }

    /**
     * @SWG\Post(
     *     path="/competitions",
     *     tags={"Competition"},
     *     summary="Add new competition",
     *     @SWG\Response(
     *          response = 200,
     *          description = "competition response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="data", required=true, in="body", @SWG\Schema(type="object"), description="The profile data")
     * )
     */

    /**
     * @SWG\Put(
     *     path="/competitions/{uid}",
     *     tags={"Competition"},
     *     summary="Edit competition",
     *     @SWG\Response(
     *         response = 200,
     *         description = "competition response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The profile UID"),
     *     @SWG\Parameter(name="data", required=true, in="body", @SWG\Schema(type="object"), description="The profile data")
     * )
     */
    public function actionManage()
    {
        $competitor = null;
        if (Yii::$app->request->isPut) {
            $uid = Yii::$app->request->get('uid');
            $competitor = Competitor::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        } else
            if (Yii::$app->request->isPost) {
                $competitor = new Competitor();
                $competitor->salesman_id = Yii::$app->user->identity->id;
            }
        if (!$competitor) {
            $this->error("Competitor Profile not found");
            return null;
        }
        $data = Yii::$app->request->post('data');
        if (!empty($data) && is_array($data)) {
            $relations = [];
            foreach ($data as $name => $value) {
                if ($competitor->hasAttribute($name)) {
                    // attribute field
                    $competitor->setAttribute($name, $value);
                } else if ($competitor->hasProperty($name)) {
                    // relational field
                    $relations[] = function ($competitor) use ($name, $value) {
                        $this->saveCompetitorNode($competitor, $name, $value);
                    };
                }
            }
            if ($competitor->save()) {
                if (!empty($relations) && is_array($relations)) {
                    foreach ($relations as $relation) {
                        $relation($competitor);
                    }
                }
                if (!$competitor->isNewRecord) {
                    $competitor->sendNotification();
                }
            }
        }
        Log::trace("Save Competitor Profile ".$competitor->name);
        $this->sendNotificationEmail($competitor);
        return ['competitor' => $competitor];
    }

    private function composeNotificationEmail($competitor, $sendToAdmin)
    {
        Log::trace("Download Competitors List", strtolower($competitor->logo_ext));
        $email = Yii::$app->mailer->compose();
        if ($competitor->logo &&  ('jpg' == strtolower($competitor->logo_ext)))
            $email->setHtmlBody(Yii::$app->mailer->render('competitor', [
                'competitor' => $competitor,
                'img' => $email->embed('data:/' . 'image/jpeg' . ';base64,' . $competitor->logo),
                ], Yii::$app->mailer->htmlLayout));
        else  // no logo
            $email->setHtmlBody(Yii::$app->mailer->render('competitor', ['competitor' => $competitor], Yii::$app->mailer->htmlLayout));

        //$email = Yii::$app->mailer->compose('competitor',['competitor' => $competitor]);
        $modelSalesman = Salesman::findOne(Yii::$app->user->identity->id);
        if($sendToAdmin)
            $email->setTo(Yii::$app->params['adminEmail']);
        else
            $email->setTo($modelSalesman->user->email);

        if ($competitor->isNewRecord)  // insert
            $email->setSubject('SalePRO: New competitor '.$competitor->name.' was added by '.$modelSalesman->name);
        else  // update
            $email->setSubject( 'SalePRO: Competitor data '.$competitor->name.' was updated by '.$modelSalesman->name);

        $email->setFrom(Yii::$app->params['adminEmail'])->send();
    }

    private function sendNotificationEmail($competitor)
    {
        Log::trace("Send Notification e-mails to admin and user");
        $this->composeNotificationEmail($competitor, true);
        $this->composeNotificationEmail($competitor, false);
    }

    private function saveCompetitorNode($parentModel, $name, $list, $parentName = null)
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
                                $this->saveCompetitorNode($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if ($parentName) {
                        if ($parentModel->hasProperty('competitor')) {
                            $m->competitor_id = $parentModel->competitor->id;
                        }
                        $pAttr = Inflector::camel2id($parentName, '_') . '_id';
                        if ($m->hasAttribute($pAttr)) {
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    } else {
                        $m->competitor_id = $parentModel->id;
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
