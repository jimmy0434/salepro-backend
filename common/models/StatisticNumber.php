<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%statistic_number}}".
 *
 * @property int $id
 * @property string $image
 * @property string $label
 * @property int $created_at
 * @property int $updated_at
 */
class StatisticNumber extends \cnd\core\components\ActiveRecord
{

    public $imageFactory;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%statistic_number}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['label'], 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'label' => 'Label',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return StatisticNumberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatisticNumberQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (is_array($this->image)) {
            $this->image = Json::encode($this->image);
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        if (is_string($this->image) && Yii::$app->helper->isJson($this->image)) {
            $this->imageFactory = \Yii::createObject([
                'class' => 'cnd\filemanager\components\FileOutput',
                'data' => $this->image,
            ]);
        } else {
            $this->imageFactory = \Yii::createObject([
                'class' => 'cnd\filemanager\components\FileOutput',
                'data' => Yii::$app->image->defaultUser,
            ]);
        }
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);
        $data['image'] = $this->imageFactory->url;
        return $data;
    }
}
