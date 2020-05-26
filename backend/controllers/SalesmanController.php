<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 08:40
 */

namespace backend\controllers;

use cnd\admin\controllers\UserController;
use cnd\admin\models\activerecords\Log;
use cnd\admin\models\activerecords\Role;
use cnd\grid\Attribute;
use cnd\grid\DataViewLocator;
use common\models\Group;
use common\models\Salesman;
use common\models\SalesmanQuery;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class SalesmanController extends UserController
{
    public $orderBy = 'id DESC';

    public function beforeAction($action)
    {
        $this->type = User::TYPE_SALESMAN;
        return parent::beforeAction($action);
    }

    public function customQuery(&$query)
    {
        if (!Yii::$app->request->get('_orderBy')) {
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

    public function formOptions()
    {
        $that = $this;
        return [
            'sections' => [
                'profile' => function ($sectionName, $form, $models) use ($that) {
                    echo Html::errorSummary($models);
                    return $that->renderPartial('form', ['model' => $models['salesman'], 'form' => $form]);
                },
                'contact' => function ($sectionName, $form, $models) use ($that) {
                    echo Html::errorSummary($models);
                    return $that->renderPartial('contact', ['model' => $models['salesman'], 'form' => $form]);
                }
            ],
            'template' => '<div class="row"><div class="col-md-4">{login}</div><div class="col-md-4">{profile}</div><div class="col-md-4">{contact}</div></div>',
            'roleLevel' => Role::LEVEL_APPLICATION,
        ];
    }

    public function defineModels($models)
    {
        $models['salesman'] = Salesman::findOne($models['user']->id);
        if (!$models['salesman']) {
            $models['salesman'] = new Salesman();
        }
        return $models;
    }

    public function beforeDeleteUser($models)
    {
        if (isset($models['salesman'])) {
            $models['salesman']->delete();
        }
        return true;
    }

    public function afterModelsValidate($models)
    {
        $models['salesman']->id = $models['user']->id;
        $models['salesman']->save();
        $models['user']->name = $models['salesman']->userName;
        $models['user']->save();
        return $models;
    }

    public function getViewAttributes($dataLocator)
    {
        $groups = ArrayHelper::map(Group::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
        if (Yii::$app->permission->can('/salesman/change-group')) {
            $url = Url::toRoute('/salesman/change-group');
            $script = <<< JS
        $(document).on('change','.group-ddl',function(){
            var element = $(this);
            var data = {
                id : element.attr('data-id'),
                groupId : element.val()
            };
            $.ajax({
                type : 'post',
                url : '{$url}',
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    element.prop('disabled',true);
                },
                success : function(response){
                    element.prop('disabled',false);
                },
                error : function(){
                    element.prop('disabled',false);
                }
            });
        });
JS;
            Yii::$app->view->registerJs($script);
        }
        return [
            'salesman.first_name' => [
                'label' => 'First Name',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? ($data->profile->first_name ? $data->profile->first_name : $data->profile->name) : '';
                },
            ],
            'salesman.last_name' => [
                'label' => 'Last Name',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->last_name : '';
                },
            ],
            'salesman.phone' => [
                'label' => 'Phone',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->phone : '';
                },
            ],
            'salesman.gender' => [
                'label' => 'Gender',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->gender : '';
                },
            ],
            'salesman.city' => [
                'label' => 'City',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->city : '';
                },
            ],
            'salesman.dob' => [
                'label' => 'DoB',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->dob : '';
                },
            ],
            'salesman.mac_address' => [
                'label' => 'Mac Address',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->mac_address : '';
                },
            ],
            'salesman.app_version' => [
                'label' => 'App version',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->app_version : '';
                },
            ],
            'salesman.last_access_date' => [
                'label' => 'Last access date',
                'value' => function ($attribute, $data) {
                    return $data->profile !== null ? $data->profile->last_access_date : '';
                },
            ],
            'salesman.image' => [
                'label' => 'Image',
                'value' => function ($attribute, $data, $view) use ($dataLocator) {
                    if ($dataLocator->export) {
                        if ($data->profile !== null && $data->profile->imageFactory !== null) {
                            $url = $data->profile->imageFactory->url;
                            if ($url) {
                                return \yii\bootstrap\Html::a('Show Image', $url, ['target' => '_blank']);
                            }
                        }
                        return '';
                    } else {
                        if (get_class($view) == \cnd\grid\Card::className()) {
                            if ($data->profile !== null && $data->profile->imageFactory !== null) {
                                return '<div style="position:relative;">' . $data->profile->imageFactory->displayImage(['100%', 'auto'], 'User Image', '', 'user-image') . '</div>';
                            }
                        } else {
                            if ($data->profile !== null && $data->profile->imageFactory !== null) {
                                return '<div style="position:relative;">' . $data->profile->imageFactory->displayImage('icon', 'User Image', '', 'user-image') . '</div>';
                            }
                        }
                        return '';
                    }
                },
                'filterBy' => Attribute::FILTER_NONE,
            ],
            'user.group_id' => [
                'label' => 'Group',
                'value' => function ($attribute, $data, $view) use ($groups) {
                    assert($attribute instanceof Attribute);
                    assert($data instanceof User);
                    assert($view instanceof DataViewLocator);
                    if (Yii::$app->permission->can('/salesman/change-group')) {
                        return Html::dropDownList('groupId', $data->group_id, $groups, ['class' => 'form-control group-ddl', 'id' => 'group-' . $data->id, 'data-id' => $data->id, 'prompt' => '']);
                    }
                    return $data->group ? $data->group->name : '';
                },
                'filterBy' => Attribute::FILTER_LIST,
                'filterList' => $groups,
            ],
        ];
    }

    public function gridTable()
    {
        return [
            'salesman.image' => [
                'sortable' => false,
            ],
            'salesman.first_name' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.last_name' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.phone' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.gender' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.city' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.dob' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.mac_address' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.app_version' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'salesman.last_access_date' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'text-align:center;white-space: nowrap;width:1%;'
                ],
            ],
            'user.group_id' => [
                'sortable' => true,
                'contentOptions' => [
                    'style' => 'min-width:150px;'
                ],
            ],
        ];
    }

    public function manageRowButtons()
    {
        return [
            function($row) {
                return Html::a('Send Refresh', Url::to(['salesman/notify','id'=>$row->id]),['class'=>'btn btn-primary']);
            },
        ];
    }

    public function actionChangeGroup()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
            $id = Yii::$app->request->post('id');
            $groupId = Yii::$app->request->post('groupId');
            $model = User::findOne($id);
            if ($model !== null) {
                $model->group_id = $groupId;
                $model->save();
                $response['changed'] = true;
                Log::trace("Change user #" . $model->id . " group, become " . ($model->group ? $model->group->name : '``'));
            }
            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionNotify($id)
    {
        if($id==0)
            $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->all(), 'id', 'id'));
        else
            $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN, 'id' => $id])->all(), 'id', 'id'));

        Yii::$app->notification->send('refresh', ['message' => 'Refresh'], $users);
        Yii::$app->session->setFlash('refresh', 'Notifications to refresh data  in salesman app was send!');
        return $this->redirect(['salesman/index']);
    }
}
