<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/9/2019
 * Time: 3:04 PM
 */

namespace backend\models;


use common\models\Form;
use common\models\User;

class NotificationForm extends Form
{
    public $message;
    public $users = [];

    public function rules()
    {
        return [
            [['message'], 'safe'],
            [['users'], 'required'],
            [['users'], 'each', 'rule' => ['exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => 'id', 'skipOnEmpty' => true, 'isEmpty' => function($value){
                return !$value;
            }]],
        ];
    }
}
