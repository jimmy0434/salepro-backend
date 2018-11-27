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

        $navigator = MenuManager::block('Navigator', 10000);
        $cmsSection = $navigator->section('CMS','fa fa-font',10);
        $cmsSection->item('File', ['/file/index'], 101);
        $cmsSection->item('Form', ['/form/index'], 102);

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
        ApiDocFactory::register([
            'name' => 'Secure Cms Contents',
            'method' => 'GET',
            'url' => '/contents',
            'description' => 'Get Contents List',
            'extraParams' => ['page'=>1,'pageSize'=>25,'category'=>'OPTIONAL','keyword'=>'OPTIONAL','_accessToken'=>'ACCESS_TOKEN'],
            'params' => [
                ['page','integer',false,'The page number. default is 1'],
                ['pageSize','integer',false,'The page Size. default is 25'],
                ['category','integer or string',false,'Category of contents, for static input use ex. cms.category.sectors'],
                ['keyword','string',false,'Search contents'],
            ],
        ]);
        ApiDocFactory::register([
            'name' => 'Download File Partition',
            'method' => 'GET',
            'url' => '/files/[id]/download/[version]/[order]',
            'description' => 'Download File Partition',
            'extraParams' => ['_accessToken'=>'ACCESS_TOKEN'],
        ]);
        ApiDocFactory::register([
            'name' => 'Get Form',
            'method' => 'GET',
            'url' => '/forms/[id]',
            'description' => 'Get Form',
            'extraParams' => ['_accessToken'=>'ACCESS_TOKEN'],
        ]);
        ob_start();
        ?>
        <pre>
        "data[form1][0][first_name]": "Ahmad",
        "data[form1][0][last_name]": "Azo",
        "data[form1][0][nationality]": "Syria",
        "data[form1_speciality][0][name]": "Ecomizer",
        "data[form1_speciality][0][since]": "2001",
        "data[form1_speciality][0][parentIndex]": "0",
        "data[form1_speciality][1][name]": "Infro Plast",
        "data[form1_speciality][1][since]": "2011",
        "data[form1_speciality][1][parentIndex]": "0",
        "data[form1_clinic][0][name]": "Alfredo",
        "data[form1_clinic][1][name]": "ash2ash",
        "data[form1_clinic][1][parentIndex]": "0",
        "data[form1_clinic_address][0][country]": "Lebanon",
        "data[form1_clinic_address][0][city]": "Tripoli",
        "data[form1_clinic_address][0][description]": "Kora",
        "data[form1_clinic_address][0][parentIndex]": "0",
        "data[form1_clinic_address][1][country]": "Lebanon",
        "data[form1_clinic_address][1][city]": "Beirut",
        "data[form1_clinic_address][1][description]": "Sen-l-Fil",
        "data[form1_clinic_address][1][parentIndex]": "0",
        "data[form1_clinic_address][2][country]": "Lebanon",
        "data[form1_clinic_address][2][city]": "Tripoli",
        "data[form1_clinic_address][2][description]": "Maarad Street",
        "data[form1_clinic_address][2][parentIndex]": "1"
        </pre>
        <?php
        $dataExample = ob_get_clean();
        ApiDocFactory::register([
            'name' => 'Save Form',
            'method' => 'POST',
            'url' => '/forms/[id]',
            'description' => 'Save Form',
            'extraParams' => ['_accessToken'=>'ACCESS_TOKEN'],
            'params' => [
                ['data','string',true,'The Form Data Such As : '.$dataExample],
            ],
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