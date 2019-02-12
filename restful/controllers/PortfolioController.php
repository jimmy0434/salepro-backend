<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/26/2019
 * Time: 11:34 AM
 */

namespace restful\controllers;


use cnd\core\api\SController;
use common\models\Brand;
use common\models\BrandQuery;
use common\models\BusinessUnit;
use common\models\BusinessUnitQuery;
use common\models\File;
use common\models\Portfolio;
use common\models\PortfolioQuery;
use common\models\Product;
use common\models\ProductQuery;
use common\models\ProductSectorQuery;
use common\models\Sector;
use common\models\SectorQuery;

class PortfolioController extends SController
{
    /**
     * @SWG\Get(
     *     path="/portfolios",
     *     tags={"Portfolio"},
     *     summary="Retrieves the collection of portfolios resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolios collection response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */

    public function actionList()
    {
        $motherCorporates = $this->list(Portfolio::TARGET_MOTHER_CORPORATE);
        $corporates = $this->list(Portfolio::TARGET_CORPORATE);
        $businessUnit = $this->list(Portfolio::TARGET_BUSINESS_UNIT);
        $brands = $this->list(Portfolio::TARGET_BRAND);
        $sectors = $this->list(Portfolio::TARGET_SECTOR);

        return [
            'motherCorporates' => $motherCorporates,
            'corporates' => $corporates,
            'businessUnit' => $businessUnit,
            'brands' => $brands,
            'sectors' => $sectors,
        ];
    }

    protected function list($target)
    {
        $query = Portfolio::find();
        $query->where(['target' => $target]);
        $query->from(['portfolio' => Portfolio::tableName()]);
        $query->joinWith([
            'brochure' => function ($query) {
                $query->from(['brochure' => File::tableName()]);
            },
            'presentation' => function ($query) {
                $query->from(['presentation' => File::tableName()]);
            },
            'video' => function ($query) {
                $query->from(['video' => File::tableName()]);
            }
        ], false);
        return $query->all();
    }

    /**
     * @SWG\Get(
     *     path="/portfolios/{uid}",
     *     tags={"Portfolio"},
     *     summary="Retrieves portfolio resources",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolio response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Portfolio UID")
     * )
     */
    public function actionOne($uid)
    {
        $query = Portfolio::find();
        $query->where(['uid' => $uid]);
        $model = $query->one();
        return ['portfolio' => $model];
    }

    protected function products($uid, $relationModel, $relationName, $targetModel, $targetName)
    {
        $query = Portfolio::find();
        $query->from(['portfolioPrimary' => Portfolio::tableName()]);
        $query->where(['portfolioPrimary.target' => Portfolio::TARGET_PRODUCT]);
        $query->joinWith([
            'product' => function ($query) use ($uid, $relationModel, $relationName, $targetModel, $targetName) {
                /**
                 * @var $query ProductQuery
                 */
                $query->from(['product' => Product::tableName()]);
                $query->joinWith([
                    $relationName => function ($query) use ($uid, $relationModel, $relationName, $targetModel, $targetName) {
                        /**
                         * @var $query ProductSectorQuery
                         */
                        $query->from([$relationName => $relationModel::tableName()]);
                        $query->joinWith([
                            $targetName => function ($query) use ($uid, $targetModel, $targetName) {
                                /**
                                 * @var $query SectorQuery
                                 */
                                $query->from([$targetName => $targetModel::tableName()]);
                                $query->joinWith([
                                    'portfolio' => function ($query) use ($uid) {
                                        /**
                                         * @var $query PortfolioQuery
                                         */
                                        $query->from(['portfolio' => Portfolio::tableName()]);
                                        $query->where(['portfolio.uid' => $uid]);
                                    }
                                ]);
                            },
                        ]);
                    },
                ]);
            },
        ]);
        $products = $query->all();
        return ['products' => $products];
    }

    /**
     * @SWG\Get(
     *     path="/sectors/{uid}/products",
     *     tags={"Portfolio"},
     *     summary="Retrieves all products of sector",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolios response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Portfolio UID")
     * )
     */
    public function actionSectorsProducts($uid)
    {
        return $this->products($uid, '\common\models\ProductSector', 'productSectors', '\common\models\Sector', 'sector');
    }

    /**
     * @SWG\Get(
     *     path="/brands/{uid}/products",
     *     tags={"Portfolio"},
     *     summary="Retrieves all products of brand",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolios response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Portfolio UID")
     * )
     */
    public function actionBrandsProducts($uid)
    {
        return $this->products($uid, '\common\models\ProductBrand', 'productBrands', '\common\models\Brand', 'brand');
    }

    /**
     * @SWG\Get(
     *     path="/business-unit/{uid}/products",
     *     tags={"Portfolio"},
     *     summary="Retrieves all products of business unit",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolios response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Portfolio UID")
     * )
     */
    public function actionBusinessUnitProducts($uid)
    {
        $businessUnitJointure = function ($name) use ($uid) {
            return [
                'businessUnits' => function ($query) use ($name, $uid) {
                    /**
                     * @var $query BusinessUnitQuery
                     */
                    $query->from(['businessUnits_' . $name => BusinessUnit::tableName()]);
                    $query->joinWith([
                        'portfolio' => function ($query) use ($name, $uid) {
                            /**
                             * @var $query PortfolioQuery
                             */
                            $query->from(['portfolio_bu_' . $name => Portfolio::tableName()]);
                            $query->andWhere(['portfolio_bu_' . $name . '.uid' => $uid]);
                        }
                    ]);
                }
            ];
        };

        $query = Portfolio::find();
        $query->from(['portfolioPrimary' => Portfolio::tableName()]);
        $query->where(['portfolioPrimary.target' => Portfolio::TARGET_PRODUCT]);
        $query->joinWith([
            'product' => function ($query) use ($businessUnitJointure) {
                /**
                 * @var $query ProductQuery
                 */
                $query->from(['product' => Product::tableName()]);
                $query->joinWith([
                    'brands' => function ($query) use ($businessUnitJointure) {
                        /**
                         * @var $query BrandQuery
                         */
                        $query->from(['brands' => Brand::tableName()]);
                        $query->joinWith($businessUnitJointure('brand'));
                    },
                    'sectors' => function ($query) use ($businessUnitJointure) {
                        /**
                         * @var $query SectorQuery
                         */
                        $query->from(['sectors' => Sector::tableName()]);
                        $query->joinWith($businessUnitJointure('sector'));
                    }
                ]);
            }
        ]);
        $products = $query->all();
        return ['products' => $products];
    }
}
