<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 08:40
 */

namespace backend\controllers;

use cnd\admin\models\activerecords\Role;
use cnd\grid\Attribute;
use cnd\grid\DataLocator;
use common\models\Salesman;
use common\models\SalesmanQuery;
use Yii;
use cnd\admin\controllers\UserController;
use common\models\User;
use yii\db\ActiveQuery;
use yii\helpers\Html;

class SalesmanController extends UserController
{
    public $orderBy = 'id DESC';

    public function beforeAction($action) {
        $this->type = User::TYPE_SALESMAN;
        return parent::beforeAction($action);
    }

    public function customQuery(&$query){
        if(!Yii::$app->request->get('_orderBy')) {
            /**
             * @var $query ActiveQuery
             */
            $query->joinWith(['salesman' => function ($query) {
                /**
                 * @var $query SalesmanQuery
                 */
                $query->from(['salesman' => Salesman::tableName()]);
                $query->orderBy('salesman.name ASC');
            }]);
        }
    }

    public function formOptions() {
        $that = $this;
        return [
            'sections' => [
                'profile' => function($sectionName, $form, $models) use($that) {
                    echo Html::errorSummary($models);
                    return $that->renderPartial('form', ['model' => $models['salesman'], 'form' => $form]);
                }
            ],
            'template' => '<div class="row"><div class="col-md-6">{login}</div><div class="col-md-6">{profile}</div></div>',
            'roleLevel'=>Role::LEVEL_APPLICATION,
        ];
    }

    public function defineModels($models) {
        $models['salesman'] = Salesman::findOne($models['user']->id);
        if (!$models['salesman']) {
            $models['salesman'] = new Salesman();
        }
        return $models;
    }

    public function beforeDeleteUser($models){
        if(isset($models['salesman'])){
            $models['salesman']->delete();
        }
        return true;
    }

    public function afterModelsValidate($models) {
        $models['salesman']->id = $models['user']->id;
        $models['salesman']->save();
        $models['user']->name = $models['salesman']->userName;
        $models['user']->save();
        return $models;
    }

    public function getViewAttributes($dataLocator) {
        return [
            'salesman.name' => [
                'label' => 'Name',
                'value' => function($attribute, $data) {
                    return $data->profile !== null ? $data->profile->name : '';
                },
            ],
            'salesman.mac_address' => [
                'label' => 'Mac Address',
                'value' => function($attribute, $data) {
                    return $data->profile !== null ? $data->profile->mac_address : '';
                },
            ],
            'salesman.image' => [
                'label' => 'Image',
                'value' => function($attribute, $data, $view) use($dataLocator) {
                    if ($dataLocator->export) {
                        if ($data->profile !== null && $data->profile->imageFactory !== null) {
                            $url = $data->profile->imageFactory->url;
                            if ($url) {
                                return \yii\bootstrap\Html::a('Show Image', $url, ['target' => '_blank']);
                            }
                        }
                        return '';
                    } else {
                        if(get_class($view) == \cnd\grid\Card::className()){
                            if($data->profile !== null && $data->profile->imageFactory !== null){
                                return '<div style="position:relative;">'.$data->profile->imageFactory->displayImage(['100%','auto'],'User Image', '', 'user-image').'</div>';
                            }
                        }else{
                            if($data->profile !== null && $data->profile->imageFactory !== null){
                                return '<div style="position:relative;">'.$data->profile->imageFactory->displayImage('icon','User Image', '', 'user-image').'</div>';
                            }
                        }
                        return '';
                    }
                },
                'filterBy' => Attribute::FILTER_NONE,
            ],
        ];
    }

    public function gridTable(){
        return [
            'salesman.image' => [
                'sortable'=>false,
            ],
            'salesman.name' => [
                'sortable'=>true,
            ],
            'salesman.mac_address' => [
                'sortable'=>true,
            ],
        ];
    }

    public function manageRowButtons(){
        return [];
    }

    public function actionTest(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "7100",
            CURLOPT_URL => "http://jawdat.local:7100/masterpak/cnd-restful/refresh",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer gTiI6GytNwMi5C16II7I9-QzqcLsa4_G",
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: 474d09f1-10d2-45ca-9e55-7973c9ea499c",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}