<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/7/2019
 * Time: 10:00 AM
 */

namespace backend\controllers;

use Yii;
use cnd\core\components\SController;
use common\models\StatisticNumber;

class StatisticNumberController extends SController
{
    public function actionIndex()
    {
        $models = $this->getModels();
        return $this->render('index', ['models' => $models]);
    }

    public function actionSave()
    {
        $models = $this->getModels();
        if (StatisticNumber::loadMultiple($models, Yii::$app->request->post()) && StatisticNumber::validateMultiple($models)) {
            foreach ($models as $model) {
                $model->save(false);
            }
            \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
        } else {
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
        }
        return $this->redirect('index');
    }

    private function getModels()
    {
        $models = StatisticNumber::find()->all();
        $modelsCount = count($models);
        $count = 7;
        if ($modelsCount < $count) {
            for ($i = $modelsCount; $i < $count; $i++) {
                $models[] = new StatisticNumber();
            }
        }
        return $models;
    }
}
