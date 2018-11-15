<?php

namespace common\models;

use cnd\cms\models\activerecords\Content;
use cnd\core\components\ActiveRecord;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%form}}".
 *
 * @property int $id
 * @property int $content_id
 * @property string $name
 * @property string $title
 * @property int $version
 * @property int $status
 * @property string $structure
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $status_label
 * @property array $status_list
 * @property array $status_values
 *
 * @property Content $content
 */
class Form extends ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_PENDING = 5;
    const STATUS_INACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%form}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['structure'], 'string'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'name' => 'Name',
            'title' => 'Title',
            'version' => 'Version',
            'status' => 'Status',
            'structure' => 'Structure',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * {@inheritdoc}
     * @return FormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        if(!Yii::$app->helper->isJson($this->structure)){
            $this->structure = [
                'name' => $this->name,
                'fields' => []
            ];
        }else{
            $this->structure = Json::decode($this->structure);
        }
    }
}
