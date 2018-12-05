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
use yii\helpers\Console;
use yii\helpers\Json;

class CronController extends Controller
{
    public function actionLogTransfer()
    {
        $out = "";
        $query = Log::find();
        $query->limit(100);
        $query->orderBy('id ASC');
        $list = $query->all();
        if (!empty($list) && is_array($list)) {
            $dbTransaction = Yii::$app->db->beginTransaction();
            $biTransaction = Yii::$app->bi->beginTransaction();
            try {
                $count = count($list);
                Console::startProgress(0, $count);
                foreach ($list as $i => $log) {
                    $out .= $this->ansiFormat('/'.str_repeat("=", 100), Console::FG_PURPLE) . PHP_EOL;
                    $out .= $this->ansiFormat("|", Console::FG_PURPLE)." - ";
                    $out .= $this->ansiFormat("Transfer new log #", Console::FG_GREEN). $this->ansiFormat($log->id, Console::FG_YELLOW, Console::BOLD) . "." . PHP_EOL;
                    $out .= $this->ansiFormat("|", Console::FG_PURPLE)." - ";
                    $out .= "(".$this->ansiFormat($log->level, Console::FG_RED).") : ";
                    $out .= $this->ansiFormat($log->user->name, Console::FG_GREEN)." [";
                    $out .= $this->ansiFormat($log->message, Console::FG_CYAN)."] ";
                    $out .= "in ".$this->ansiFormat($log->app,Console::FG_YELLOW)." ";
                    $out .= "on ".$this->ansiFormat(date('l, d F, Y H:i',strtotime($log->date)), Console::FG_PURPLE);
                    $out .= "".PHP_EOL;
                    $attrs = $log->attributes;
                    $data = $attrs['data'];
                    unset($attrs['data']);
                    Yii::$app->bi->createCommand()->insert('log', $attrs)->execute();
                    $id = Yii::$app->bi->getLastInsertID();
                    if(Yii::$app->helper->isJson($data)){
                        $data = Json::decode($data);
                    }

                    if(!empty($data) && is_array($data)){
                        foreach($data as $attribute => $item){
                            $changes = [
                                'log_id' => $id,
                                'name' => $attribute,
                                'from' => $item['oldValue'],
                                'to' => $item['newValue'],
                                'created_at' => time(),
                                'updated_at' => time(),
                            ];
                            Yii::$app->bi->createCommand()->insert('log_change', $changes)->execute();
                            $out .= $this->ansiFormat("|", Console::FG_PURPLE)." - ";
                            $out .= $this->ansiFormat("Attribute ", Console::FG_CYAN);
                            $out .= $this->ansiFormat("" . $attribute . " ", Console::FG_YELLOW, Console::BOLD);
                            $out .= $this->ansiFormat("changed From ", Console::FG_CYAN);
                            $out .= $this->ansiFormat("".$item['oldValue']." ", Console::FG_GREY, Console::BOLD);
                            $out .= $this->ansiFormat("To ", Console::FG_CYAN);
                            $out .= $this->ansiFormat("".$item['newValue']." ", Console::FG_GREEN, Console::BOLD);
                            $out .= "".PHP_EOL;
                        }
                    }

                    if ($log->delete()) {
                        $out .= $this->ansiFormat("|", Console::FG_PURPLE)." - ";
                        $out .= $this->ansiFormat("Delete original log #", Console::FG_RED) . $this->ansiFormat($log->id, Console::FG_YELLOW, Console::BOLD) . "." . PHP_EOL;
                    }
                    $out .= $this->ansiFormat('\\'.str_repeat("=", 100), Console::FG_PURPLE) . PHP_EOL;
                    $out .= "" . PHP_EOL;
                    Console::updateProgress($i+1, $count);
                }
                Console::endProgress();
                $dbTransaction->commit();
                $biTransaction->commit();
            } catch (\Throwable $t) {
                $out .= $t->getMessage() . PHP_EOL;
                $dbTransaction->rollBack();
                $biTransaction->rollBack();
            } catch (\Exception $e) {
                $out .= $e->getMessage() . PHP_EOL;
                $dbTransaction->rollBack();
                $biTransaction->rollBack();
            }
        } else {
            $out .= $this->ansiFormat("No logs to transfer", Console::FG_RED) . PHP_EOL;
        }
        echo $out;
    }
}