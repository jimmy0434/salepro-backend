<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/9/2019
 * Time: 2:59 PM
 */

namespace backend\controllers;


use Yii;
use backend\models\NotificationForm;
use cnd\core\components\SController;

class CustomNotificationController extends SController
{
    public function actionIndex()
    {
        $model = new NotificationForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->notification->send('default', [
                'message' => $model->message,
            ], array_filter($model->users));
            $count = count(array_filter($model->users));
            Yii::$app->session->setFlash('success', 'Notification was sent successfully for ' . $count . ' ' . ($count > 1 ? 'users' : 'user'));
            return $this->redirect(['index']);
        }
        return $this->render('index', ['model' => $model]);
    }
}
