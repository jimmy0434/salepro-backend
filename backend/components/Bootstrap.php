<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 08:57
 */

namespace backend\components;

use cnd\admin\widgets\InfoBox;
use cnd\core\admin\MenuManagerSection;
use common\models\User;
use Yii;
use yii\base\BootstrapInterface;
use cnd\core\admin\MenuManager;
use cnd\core\api\ApiDocFactory;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        /**
         * add salesman link to drawer menu
         * @var $userSection MenuManagerSection
         */
        $data = MenuManager::block('Data');
        $userSection = $data->section('Users');
        $userSection->item('Salesman', ['/salesman/index'], 2);

        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type == User::TYPE_ROOT){
            $this->apiDefinitions();
        }

        $this->dashboard();
    }

    public function apiDefinitions(){
        ApiDocFactory::appendToParams('Login',[
            ['macAddress','string',true,'MacAddress'],
        ]);
        ApiDocFactory::appendToParams('Edit Profile',[
            ['salesman[name]','string',false,'Name of the salesman'],
        ]);
    }

    public function dashboard(){
        Yii::$app->dashboard->info = function(){
            $count = User::find()->where(['type'=>User::TYPE_SALESMAN])->count();
            return InfoBox::widget([
                'label' => 'Salesman',
                'value' => $count,
                'faIcon' => 'user-circle',
                'color' => 'green',
            ]);
        };
    }
}