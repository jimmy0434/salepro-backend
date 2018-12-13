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
use cnd\core\components\ActiveRecord;
use common\models\User;
use Yii;
use yii\base\BootstrapInterface;
use cnd\core\admin\MenuManager;
use cnd\core\api\ApiDocFactory;
use yii\base\Event;

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
        $cmsSection->item('Form Approval', ['/form-approval/index'], 101);

        $developer = MenuManager::block('Developer');
        $developerSection = $developer->section('Documentation');
        $developerSection->item('Swagger UI',['/swagger/docs'], 100);

        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type == User::TYPE_ROOT){
            $this->apiDefinitions();
        }

        $this->dashboard();
        $this->synchronizeWithBiDb();
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
{
	"data": {
		"doctor": [
            {
				"first_name": "Foued",
				"last_name": "Meslh",
				"nationality": "Lebanon",
				"doctor_clinic": [
					{
						"name": "Auto Clinic",
						"doctor_clinic_address": [
							{
								"country": "Lebanon",
								"city": "Tripoli",
								"description": "Monla Street"
							},
							{
								"country": "Lebanon",
								"city": "Saida",
								"description": "Afro Street"
							}
						]
					},
					{
						"name": "Ashata Leda",
						"doctor_clinic_address": [
							{
								"country": "Lebanon",
								"city": "Tripoli",
								"description": "Abou Ali Street"
							}
						]
					}
				],
				"doctor_speciality": [
					{
						"name": "Children",
						"since": "2011"
					},
					{
						"name": "Ecomizer",
						"since": "1996"
					}
				]
			}
		]
	}
}
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
        ApiDocFactory::register([
            'name' => 'Get Form Crud Data',
            'method' => 'GET',
            'url' => '/forms/[id]/crud',
            'description' => 'Get Form',
            'extraParams' => ['_accessToken'=>'ACCESS_TOKEN','page'=>1,'pageSize'=>25,'search'=>'OPTIONAL','order'=>'OPTIONAL'],
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

    public function synchronizeWithBiDb(){
        $ar = new ActiveRecord();
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function($event){
            $this->biDbSync('add',$event);
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, function($event){
            $this->biDbSync('edit',$event);
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE, function($event){
            $this->biDbSync('delete',$event);
        });
    }

    public function biDbSync($action, $event){
        $sender = $event->sender;
        $className = $sender::className();
        $tableName = $className::getTableSchema()->fullName;
        Yii::$app->biMapSync->check($tableName, $event->sender, $action);
    }
}