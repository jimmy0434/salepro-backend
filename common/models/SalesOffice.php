<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mpk_sales_office".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property string $region
 * @property int $position
 * @property int $file_id
 *
 * @property PortfolioSalesOffice[] $portfolioSalesOffices
 * @property File $file
 */
class SalesOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_sales_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at', 'position', 'file_id'], 'integer'],
            [['name', 'region'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'region' => 'Region',
            'position' => 'Position',
            'file_id' => 'File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioSalesOffices()
    {
        return $this->hasMany(PortfolioSalesOffice::className(), ['sales_office_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * {@inheritdoc}
     * @return SalesOfficeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalesOfficeQuery(get_called_class());
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        unset($list['file_id']);
        $list['file'] = $this->file;
    
        return $list;
    }
}
