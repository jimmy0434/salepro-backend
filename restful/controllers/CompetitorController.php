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

    public function actionList()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);
        $query = Competitor::find();
        $query->where(['salesman_id' => Yii::$app->user->identity->id]);
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $query->orderBy('name ASC');
        $list = $query->all();
        return ['profiles' => $list];
    }

    public function actionProfile(){
        $uid = Yii::$app->request->get('uid');
        $competitor = Competitor::find()->where(['uid' => $uid, 'salesman_id' => Yii::$app->user->identity->id])->one();
        return ['profile' => $competitor];
    }

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
            }
        }
        return ['competitor' => $competitor];
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
