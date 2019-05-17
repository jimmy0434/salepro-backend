<?php

namespace common\models;

use cnd\admin\models\activerecords\Log;
use Yii;
use yii\base\Exception;
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
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $target_list
 * @property array $target_values
 * @property string $target_label
 *
 * @property array $status_list
 * @property array $status_values
 * @property string $status_label
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
class Portfolio extends \common\components\ActiveRecord
{

    const TARGET_MOTHER_CORPORATE = 1;
    const TARGET_CORPORATE = 2;
    const TARGET_BUSINESS_UNIT = 3;
    const TARGET_BRAND = 4;
    const TARGET_SECTOR = 5;
    const TARGET_PRODUCT = 6;
    const TARGET_BUNDLING_AND_PACKING = 7;

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

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
        return $this->hasMany(SalesOffice::className(), ['id' => 'sales_office_id'])->orderBy(['position' => SORT_ASC])->via('portfolioSalesOffices');
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
                    $this->assignItems($this->sectorsIds, '\common\models\CorporateSector', 'sector_id', 'corporate_id', $item->id, [], '\common\models\Sector');
                    $this->assignItems($this->businessUnitIds, '\common\models\CorporateBusinessUnit', 'business_unit_id', 'corporate_id', $item->id, [], '\common\models\BusinessUnit');

                    $this->sendNotificationToModels($item->sectors);
                    $this->sendNotificationToModels($item->businessUnits);
                }
                break;
            case static::TARGET_BRAND:
                Brand::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->sectorsIds, '\common\models\SectorBrand', 'sector_id', 'brand_id', $item->id, [], '\common\models\Sector');
                    $this->assignItems($this->productsIds, '\common\models\ProductBrand', 'product_id', 'brand_id', $item->id, [], '\common\models\Product');
                    $this->assignItems($this->businessUnitIds, '\common\models\BrandBusinessUnit', 'business_unit_id', 'brand_id', $item->id, [], '\common\models\BusinessUnit');

                    $this->sendNotificationToModels($item->sectors);
                    $this->sendNotificationToModels($item->products);
                    $this->sendNotificationToModels($item->businessUnits);
                }
                break;
            case static::TARGET_SECTOR:
                Sector::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->brandsIds, '\common\models\SectorBrand', 'brand_id', 'sector_id', $item->id, [], '\common\models\Brand');
                    $this->assignItems($this->productsIds, '\common\models\ProductSector', 'product_id', 'sector_id', $item->id, [], '\common\models\Product');
                    $this->assignItems($this->businessUnitIds, '\common\models\SectorBusinessUnit', 'business_unit_id', 'sector_id', $item->id, [], '\common\models\BusinessUnit');

                    $this->sendNotificationToModels($item->brands);
                    $this->sendNotificationToModels($item->products);
                    $this->sendNotificationToModels($item->businessUnits);
                }
                break;
            case static::TARGET_PRODUCT:
            case static::TARGET_BUNDLING_AND_PACKING:
                Product::relateToPortfolio($this->id);
                $item = $this->item;
                if ($item) {
                    $this->assignItems($this->brandsIds, '\common\models\ProductBrand', 'brand_id', 'product_id', $item->id, [], '\common\models\Brand');
                    $this->assignItems($this->sectorsIds, '\common\models\ProductSector', 'sector_id', 'product_id', $item->id, [], '\common\models\Sector');
                    $this->assignItems($this->businessUnitIds, '\common\models\ProductBusinessUnit', 'business_unit_id', 'product_id', $item->id, [], '\common\models\BusinessUnit');
                    $this->assignItems($this->certificationsIds, '\common\models\ProductCertification', 'certification_id', 'product_id', $item->id);

                    $this->sendNotificationToModels($item->brands);
                    $this->sendNotificationToModels($item->sectors);
                    $this->sendNotificationToModels($item->businessUnits);
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
        if ($this->hasAttribute("privilege") && Yii::$app->helper->isJson($this->privilege)) {
            $privilege = Json::decode($this->privilege);

            if (isset($privilege['protected'])) {
                $users = User::find()->where(['type' => User::TYPE_SALESMAN])->all();
                $granted = in_array($privilege['protected'], ['user.*.1.0.0', 'user.*.1.1.0']) || in_array($privilege['groups'], ['group.*.1.0.0', 'group.*.1.1.0']);
                if (!empty($users) && is_array($users)) {
                    foreach ($users as $user) {
                        $userGranted = false;
                        if (isset($privilege['private'][$user->id])) {
                            $userGranted = $granted || in_array($privilege['private'][$user->id], ['user.' . $user->id . '.1.1.0', 'user.' . $user->id . '.1.0.0']);
                        }
                        $this->grantNotification($user, $userGranted);
                    }
                }
                $groups = Group::find()->orderBy(['name' => SORT_ASC])->all();
                if (!empty($groups) && is_array($groups)) {
                    foreach ($groups as $group) {
                        $groupGranted = false;
                        if (isset($privilege['group'][$group->id])) {
                            $groupGranted = $granted || in_array($privilege['group'][$group->id], ['group.' . $group->id . '.1.1.0', 'group.' . $group->id . '.1.0.0']);
                        }
                        if (!empty($group->users) && is_array($group->users)) {
                            foreach ($group->users as $user) {
                                $this->grantNotification($user, $groupGranted);
                            }
                        }
                    }
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function grantNotification($user, $granted)
    {
        Yii::$app->notification->send("portfolio-update-grant", [
            'message' => 'The ' . $this->target_label . ' portfolio `' . $this->name . '` was ' . ($granted ? 'enabled for' : 'disabled from') . ' watching.',
            'id' => $this->id,
            'uid' => $this->uid,
            'target' => $this->target_label,
            'granted' => $granted,
        ], [$user->id]);
        $userName = $user->name;
        Log::trace('#user-portfolio-permission: ' . ($granted ? 'Enabled ' . $userName . ' to' : 'Disabled ' . $userName . ' from') . ' view the ' . $this->target_label . ' portfolio `' . $this->name . '` #' . $this->id);
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

    protected function assignItems($items, $targetModel, $relationId, $byId, $byValue, $extraParams = [], $relatedModel = null)
    {
        $oldIds = [];
        $old = $targetModel::find()->where([$byId => $byValue])->all();
        if (!empty($old) && is_array($old)) {
            foreach ($old as $m) {
                $oldIds[] = $m->$relationId;
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
                if (!in_array($itemId, $oldIds) && $relatedModel) {
                    $m = $relatedModel::findOne($itemId);
                    $m->portfolio->sendNotification();
                }
            }
        }
        if ($relatedModel) {
            $updates = array_diff($oldIds, $items);
            if (!empty($updates) && is_array($updates)) {
                foreach ($updates as $updatedId) {
                    $m = $relatedModel::findOne($updatedId);
                    $m->portfolio->sendNotification();
                }
            }
        }
    }

    public static function listData($target)
    {
        return ArrayHelper::map(static::find()->where(['target' => $target])->orderBy(['name' => SORT_ASC])->all(), function ($row) {
            return $row->item->id;
        }, 'name');
    }

    public function sendNotification($model = null)
    {
        if (!$model) {
            $model = $this;
        }
        $users = array_values(ArrayHelper::map(User::find()->where(['type' => User::TYPE_SALESMAN, 'status' => User::STATUS_ACTIVE])->all(), 'id', 'id'));
        if (!empty($users) && is_array($users)) {
            Yii::$app->notification->send('portfolio-update', [
                'message' => 'The ' . $model->target_label . ' portfolio `' . $model->name . '` was updated',
                'id' => $this->id,
                'uid' => $this->uid,
                'target' => $model->target_label,
            ], $users);
        }
    }

    public function sendNotificationToModels($models)
    {
        /*if (!empty($models) && is_array($models)) {
            foreach ($models as $model) {
                try {
                    $this->sendNotification($model->portfolio);
                } catch (Exception $e) {

                }
            }
        }*/
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = static::STATUS_ENABLED;
            if (in_array($this->target, [static::TARGET_PRODUCT, static::TARGET_BUNDLING_AND_PACKING])) {
                $this->status = static::STATUS_DISABLED;
            }
        }
        return parent::beforeValidate();
    }
}
