<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%portfolio}}".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $description
 * @property string $image
 * @property int $brochure_id
 * @property int $presentation_id
 * @property int $video_id
 * @property int $info_graphic_id
 * @property int $search_id
 * @property int $target
 * @property string $linkedin
 * @property int $position
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $target_list
 * @property array $target_values
 * @property string $target_label
 *
 * @property Brand[] $brands
 * @property Corporate[] $corporates
 * @property PortfolioCompetitor[] $portfolioCompetitors
 * @property PortfolioLink[] $portfolioLinks
 * @property PortfolioNews[] $portfolioNews
 * @property Product[] $products
 * @property Sector[] $sectors
 * @property PortfolioSalesOffice[] $portfolioSalesOffices
 * @property SalesOffice[] $salesOffices
 * @property File $brochure
 * @property File $presentation
 * @property File $video
 * @property File $infoGraphic
 * @property Search $search
 * @property Corporate $corporate
 * @property Sector $sector
 * @property Brand $brand
 * @property Product $product
 * @property BusinessUnit $businessUnit
 */
class Portfolio extends \cnd\core\components\ActiveRecord
{

    const TARGET_MOTHER_CORPORATE = 1;
    const TARGET_CORPORATE = 2;
    const TARGET_BUSINESS_UNIT = 3;
    const TARGET_BRAND = 4;
    const TARGET_SECTOR = 5;
    const TARGET_PRODUCT = 6;
    const TARGET_BUNDLING_AND_PACKING = 7;

    public $tags = [];
    public $brandsIds = [];
    public $sectorsIds = [];
    public $productsIds = [];
    public $businessUnitIds = [];
    public $newsLinks = [];
    public $links = [];
    public $officesIds = [];
    public $certificationsIds = [];

    public $imageFactory;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portfolio}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'description'], 'string'],
            [['uid'], 'unique'],
            [['position'], 'number', 'min' => 0, 'integerOnly' => true],
            [['tags', 'brandsIds', 'sectorsIds', 'productsIds', 'businessUnitIds', 'newsLinks', 'links', 'officesIds', 'certificationsIds'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
            'description' => 'Description',
            'info_graphic_id' => 'InfoGraphics',
            'image' => 'Image',
            'brochure_id' => 'Brochure ID',
            'presentation_id' => 'Presentation ID',
            'video_id' => 'Video ID',
            'search_id' => 'Search ID',
            'target' => 'Target',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporate()
    {
        return $this->hasOne(Corporate::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessUnit()
    {
        return $this->hasOne(BusinessUnit::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioCompetitors()
    {
        return $this->hasMany(PortfolioCompetitor::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioLinks()
    {
        return $this->hasMany(PortfolioLink::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioNews()
    {
        return $this->hasMany(PortfolioNews::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['portfolio_id' => 'id']);
    }

    public function getBrochure()
    {
        return $this->hasOne(File::className(), ['id' => 'brochure_id']);
    }

    public function getPresentation()
    {
        return $this->hasOne(File::className(), ['id' => 'presentation_id']);
    }

    public function getVideo()
    {
        return $this->hasOne(File::className(), ['id' => 'video_id']);
    }

    public function getInfoGraphic()
    {
        return $this->hasOne(File::className(), ['id' => 'info_graphic_id']);
    }

    public function getSearch()
    {
        return $this->hasOne(Search::className(), ['id' => 'search_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioSalesOffices()
    {
        return $this->hasMany(PortfolioSalesOffice::className(), ['portfolio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesOffices()
    {
        return $this->hasMany(SalesOffice::className(), ['id' => 'sales_office_id'])->via('portfolioSalesOffices');
    }

    /**
     * {@inheritdoc}
     * @return PortfolioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('portfolio-', true);
        }
        if (is_array($this->image)) {
            $this->image = Json::encode($this->image);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        switch ($this->target) {
            case static::TARGET_CORPORATE:
            case static::TARGET_MOTHER_CORPORATE:
                Corporate::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->sectorsIds, '\common\models\CorporateSector', 'sector_id', 'corporate_id', $item->id);
                    $this->assignItems($this->businessUnitIds, '\common\models\CorporateBusinessUnit', 'business_unit_id', 'corporate_id', $item->id);
                }
                break;
            case static::TARGET_BRAND:
                Brand::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->sectorsIds, '\common\models\SectorBrand', 'sector_id', 'brand_id', $item->id);
                    $this->assignItems($this->productsIds, '\common\models\ProductBrand', 'product_id', 'brand_id', $item->id);
                    $this->assignItems($this->businessUnitIds, '\common\models\BrandBusinessUnit', 'business_unit_id', 'brand_id', $item->id);
                }
                break;
            case static::TARGET_SECTOR:
                Sector::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->brandsIds, '\common\models\SectorBrand', 'brand_id', 'sector_id', $item->id);
                    $this->assignItems($this->productsIds, '\common\models\ProductSector', 'product_id', 'sector_id', $item->id);
                    $this->assignItems($this->businessUnitIds, '\common\models\SectorBusinessUnit', 'business_unit_id', 'sector_id', $item->id);
                }
                break;
            case static::TARGET_PRODUCT:
            case static::TARGET_BUNDLING_AND_PACKING:
                Product::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->brandsIds, '\common\models\ProductBrand', 'brand_id', 'product_id', $item->id);
                    $this->assignItems($this->sectorsIds, '\common\models\ProductSector', 'sector_id', 'product_id', $item->id);
                    $this->assignItems($this->businessUnitIds, '\common\models\ProductBusinessUnit', 'business_unit_id', 'product_id', $item->id);
                    $this->assignItems($this->certificationsIds, '\common\models\ProductCertification', 'certification_id', 'product_id', $item->id);
                }
                break;
            case static::TARGET_BUSINESS_UNIT:
                BusinessUnit::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->certificationsIds, '\common\models\BusinessUnitCertification', 'certification_id', 'business_unit_id', $item->id);
                }
                break;
        }
        $this->assignItems($this->officesIds, '\common\models\PortfolioSalesOffice', 'sales_office_id', 'portfolio_id', $this->id);

        $search = Search::updateRecord($this->tags, $this->uid, $this->name, $this->description);
        if (!$this->search_id) {
            try {
                Yii::$app->db->createCommand()->update(static::tableName(), ['search_id' => $search->id], ['id' => $this->id])->execute();
            } catch (\Throwable $t) {
            } catch (\Exception $e) {
            }
        }
        if (!empty($this->newsLinks) && is_array($this->newsLinks)) {
            reset($this->newsLinks);
            $k = key($this->newsLinks);
            $links = $this->newsLinks[$k];
            if (!empty($links) && is_array($links)) {
                $links = array_filter($links);
                $this->assignItems($links, '\common\models\PortfolioNews', 'url', 'portfolio_id', $this->id);
            }
        }
        if (!empty($this->links) && is_array($this->links)) {
            $keys = array_keys($this->links);
            $names = $this->links[$keys[0]];
            $urls = $this->links[$keys[1]];
            if (!empty($names) && is_array($names)) {
                $this->assignItems($urls, '\common\models\PortfolioLink', 'url', 'portfolio_id', $this->id, ['name' => $names]);
            }
        }
        if($this->hasAttribute("privilege") && Yii::$app->helper->isJson($this->privilege)) {
            $privilege = Json::decode($this->privilege);
            if (isset($privilege['private']) && !empty($privilege['private']) && is_array($privilege['private'])) {
                foreach ($privilege['private'] as $userId => $perm) {
                    $granted = $perm === 'user.'.$userId.'.1.1.0' || $perm === 'user.'.$userId.'.1.0.0';
                    Yii::$app->notification->send("portfolio-update-grant", [
                        'message' => 'The ' . $this->target_label . ' portfolio `' . $this->name . '` was ' . ($granted ? 'enabled for' : 'disabled from') . ' watching.',
                        'id' => $this->id,
                        'uid' => $this->uid,
                        'target' => $this->target_label,
                        'granted' => $granted,
                    ], [$userId]);
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        parent::afterFind();
        if (!in_array($this->target, [static::TARGET_PRODUCT, static::TARGET_BUNDLING_AND_PACKING])) {
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
        // load news links
        $this->newsLinks = [
            'Url' => [],
        ];
        $news = $this->portfolioNews;
        if (!empty($news) && is_array($news)) {
            foreach ($news as $n) {
                $this->newsLinks['Url'][] = $n->url;
            }
        }
        // load links
        $this->links = [
            'Name' => [],
            'Url' => [],
        ];
        $links = $this->portfolioLinks;
        if (!empty($links) && is_array($links)) {
            foreach ($links as $n) {
                $this->links['Name'][] = $n->name;
                $this->links['Url'][] = $n->url;
            }
        }
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);
        if (!in_array($this->target, [static::TARGET_PRODUCT, static::TARGET_BUNDLING_AND_PACKING])) {
            $data['image'] = $this->imageFactory->url;
        } else {
            unset($data['image']);
            $imagesData = Json::decode($this->image);
            $data['images'] = [];
            if (!empty($imagesData) && is_array($imagesData)) {
                foreach ($imagesData as $imageData) {
                    if (is_string($imageData) && Yii::$app->helper->isJson($imageData)) {
                        $image = Json::decode($imageData);
                        $data['images'][] = $image['url'];
                    }
                }
            }
        }
        $data['brochure'] = $this->brochure;
        $data['presentation'] = $this->presentation;
        $data['video'] = $this->video;
        $data['infoGraphics'] = $this->infoGraphic;
        $data['news'] = isset($this->newsLinks['Url']) ? $this->newsLinks['Url'] : [];
        $data['links'] = array_values(ArrayHelper::map($this->portfolioLinks, 'id', function ($model) {
            return [
                'name' => $model->name,
                'url' => $model->url,
            ];
        }));
        $data['offices'] = $this->salesOffices;
        if ($this->target == static::TARGET_PRODUCT || $this->target == static::TARGET_BUNDLING_AND_PACKING) {
            $data['details'] = $this->product->details;
        }
        $data['primaryModel'] = $this->item;
        $data['granted'] = $this->canRead();
        unset($data['brochure_id'], $data['presentation_id'], $data['video_id'], $data['search_id'], $data['target'], $data['info_graphic_id'], $data['privilege']);
        switch ($this->target) {
            case static::TARGET_MOTHER_CORPORATE:
            case static::TARGET_CORPORATE:
                $data['businessUnits'] = $this->manyToManyPortfolio($this->corporate->businessUnits);
                $data['sectors'] = $this->manyToManyPortfolio($this->corporate->sectors);
                break;
            case static::TARGET_SECTOR:
                $data['businessUnits'] = $this->manyToManyPortfolio($this->sector->businessUnits);
                $data['brands'] = $this->manyToManyPortfolio($this->sector->brands);
                $data['products'] = $this->manyToManyPortfolio($this->sector->products);
                break;
            case static::TARGET_BRAND:
                $data['businessUnits'] = $this->manyToManyPortfolio($this->brand->businessUnits);
                $data['sectors'] = $this->manyToManyPortfolio($this->brand->sectors);
                $data['products'] = $this->manyToManyPortfolio($this->brand->products);
                break;
            case static::TARGET_PRODUCT:
            case static::TARGET_BUNDLING_AND_PACKING:
                $data['sectors'] = $this->manyToManyPortfolio($this->product->sectors);
                $data['brands'] = $this->manyToManyPortfolio($this->product->brands);
                $data['certifications'] = $this->product ? $this->product->certifications : null;
                $data['details'] = $this->product ? $this->product->details : null;
                break;
            case static::TARGET_BUSINESS_UNIT:
                $data['certifications'] = $this->businessUnit ? $this->businessUnit->certifications : null;
                break;
        }
        return $data;
    }

    protected function manyToManyPortfolio($models)
    {
        return array_filter(array_values(ArrayHelper::map($models, 'uid', function ($model) {
            return $model->portfolio ? $model->portfolio->uid : null;
        })));
    }

    public function getItem()
    {
        $item = lcfirst(Inflector::id2camel($this->target_label, '_'));
        if ($item == 'motherCorporate') {
            $item = 'corporate';
        } else if ($item == 'bundlingAndPacking') {
            $item = 'product';
        }
        if ($this->hasProperty($item)) {
            return $this->$item;
        }
        return null;
    }

    protected function assignItems($items, $targetModel, $relationId, $byId, $byValue, $extraParams = [])
    {
        $old = $targetModel::find()->where([$byId => $byValue])->all();
        if (!empty($old) && is_array($old)) {
            foreach ($old as $m) {
                $m->delete();
            }
        }
        if (!empty($items) && is_array($items)) {
            foreach ($items as $i => $itemId) {
                $m = new $targetModel();
                $m->$byId = $byValue;
                $m->$relationId = $itemId;
                if (!empty($extraParams) && is_array($extraParams)) {
                    foreach ($extraParams as $paramName => $values) {
                        if ($m->hasProperty($paramName) && isset($values[$i])) {
                            $m->$paramName = $values[$i];
                        }
                    }
                }
                $m->save();
            }
        }
    }

    public static function listData($target)
    {
        return ArrayHelper::map(static::find()->where(['target' => $target])->orderBy(['name' => SORT_ASC])->all(), function ($row) {
            return $row->item->id;
        }, 'name');
    }
}
