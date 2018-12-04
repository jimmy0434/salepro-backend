<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/4/2018
 * Time: 1:21 PM
 */

namespace console\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use yii\console\Controller;
use yii\console\widgets\Table;

class CronController extends Controller
{
    public function actionLogTransfer()
    {
        $query = Log::find();
        $query->limit(100);
        $query->orderBy('id ASC');
        $list = $query->all();
        if (!empty($list) && is_array($list)) {
            $dbTransaction = Yii::$app->db->beginTransaction();
            $biTransaction = Yii::$app->bi->beginTransaction();
            try {
                foreach ($list as $log) {
                    echo str_repeat("-", 100) . PHP_EOL;
                    $attrs = $log->attributes;
                    Yii::$app->bi->createCommand()->insert('log', $attrs)->execute();
                    echo "Transfer new log #" . $log->id . "." . PHP_EOL;
                    echo Table::widget([
                        'headers' => array_keys($attrs),
                        'rows' => [array_values($attrs)],
                    ]);
                    if ($log->delete()) {
                        echo "Original log #" . $log->id . " was deleted." . PHP_EOL;
                    }
                    echo str_repeat("-", 100) . PHP_EOL;
                    echo "" . PHP_EOL;
                }
                $dbTransaction->commit();
                $biTransaction->commit();
            } catch (\Throwable $t) {
                echo $t->getMessage() . PHP_EOL;
                $dbTransaction->rollBack();
                $biTransaction->rollBack();
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                $dbTransaction->rollBack();
                $biTransaction->rollBack();
            }
        } else {
            echo "No logs to transfer" . PHP_EOL;
        }
    }
}