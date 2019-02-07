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

use Yii;
use cnd\core\api\SController;
use common\models\Competitor;
use yii\helpers\Inflector;

class CompetitorController extends SController
{
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
                            $relations[] = function($m) use($attribute, $value, $name){
                                $this->saveCompetitorNode($m, $attribute, $value, $name);
                            };
                        }
                    }
                    if($parentName){
                        if($parentModel->hasProperty('competitor')) {
                            $m->competitor_id = $parentModel->competitor->id;
                        }
                        $pAttr = Inflector::camel2id($parentName,'_').'_id';
                        if($m->hasAttribute($pAttr)){
                            $m->setAttribute($pAttr, $parentModel->id);
                        }
                    }else{
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

    public function actionManage()
    {
        $uid = Yii::$app->request->get('uid');
        $competitor = Competitor::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        if (!$competitor) {
            $competitor = new Competitor();
            $competitor->salesman_id = Yii::$app->user->identity->id;
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
                    $relations[] = function($competitor) use($name, $value){
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
            }
        }
        return ['competitor' => $competitor];
    }
}
