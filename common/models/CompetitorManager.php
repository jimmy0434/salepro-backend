<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_manager}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property string $first_name
 * @property string $last_name
 * @property string $position
 * @property string $linkedin
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 */
class CompetitorManager extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_manager}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id'], 'integer'],
            //[['linkedin'], 'string'],
            //[['first_name', 'last_name', 'position'], 'string', 'max' => 255],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competitor_id' => 'Competitor ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'position' => 'Position',
            'linkedin' => 'Linkedin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorManagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorManagerQuery(get_called_class());
    }
}
