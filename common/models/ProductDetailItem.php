<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_detail_item}}".
 *
 * @property int $id
 * @property int $product_detail_id
 * @property int $file_id
 * @property int $content_id
 * @property int $type
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 *
 * @property File $file
 * @property Content $content
 * @property ProductDetail $productDetail
 */
class ProductDetailItem extends \common\components\ActiveRecord
{

    const TYPE_FILE = 1;
    const TYPE_CONTENT = 2;
    const TYPE_CALCULATOR_STANDARD_FILM = 3;
    const TYPE_CALCULATOR_PE_BAGS = 4;

    public $image;
    public $text;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_detail_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['image', 'text'], 'safe'],
            [['product_detail_id', 'file_id', 'content_id', 'type'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['product_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductDetail::className(), 'targetAttribute' => ['product_detail_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_detail_id' => 'Product Detail ID',
            'file_id' => 'File ID',
            'content_id' => 'Content ID',
            'type' => 'Type',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDetail()
    {
        return $this->hasOne(ProductDetail::className(), ['id' => 'product_detail_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductDetailItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductDetailItemQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        $contentId = Content::add($this->title, $this->text, $this->image);
        if ($contentId) {
            $this->content_id = $contentId;
        } else {
            return false;
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->type == static::TYPE_CONTENT && $this->content) {
            $this->text = $this->content->text;
            $this->image = $this->content->image;
        }
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        unset($list['file_id'], $list['content_id']);
        if ($this->type == static::TYPE_CONTENT) {
            $list['content'] = $this->content;
        } else if ($this->type == static::TYPE_FILE) {
            $list['file'] = $this->file;
        } else if (in_array($this->type, [static::TYPE_CALCULATOR_STANDARD_FILM, static::TYPE_CALCULATOR_PE_BAGS])) {
            $list['calculator'] = $this->type_label;
        }
        return $list;
    }
}
