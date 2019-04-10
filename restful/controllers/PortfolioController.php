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


use cnd\admin\models\activerecords\Log;
use cnd\core\api\SController;
use common\models\BusinessUnit;
use common\models\BusinessUnitQuery;
use common\models\File;
use common\models\Portfolio;
use common\models\PortfolioQuery;
use common\models\Product;
use common\models\ProductBusinessUnit;
use common\models\ProductQuery;
use common\models\ProductSectorQuery;
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

        Log::trace('Download Portfolio Items Data');

        return [
            'motherCorporates' => $motherCorporates,
            'corporates' => $corporates,
            'businessUnit' => $businessUnit,
            'brands' => $brands,
            'sectors' => $sectors,
        ];
    }

    /**
     * @SWG\Get(
     *     path="/products",
     *     tags={"Portfolio"},
     *     summary="Retrieves the collection of products resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Products collection response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionProducts()
    {
        $products = $this->list(Portfolio::TARGET_PRODUCT);
        Log::trace('Download products Items Data');
        return ['products' => $products];
    }

    protected function list($target)
    {
        $query = Portfolio::find();
        $query->where(['target' => $target, 'status' => Portfolio::STATUS_ENABLED]);
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
        $query->orderBy('portfolio.position ASC, portfolio.name ASC');
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
        Log::trace("Download Portfolio Item Data");
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
        $query->orderBy('portfolioPrimary.position ASC, portfolioPrimary.name ASC');
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
        Log::trace("Download Products of sector");
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
        Log::trace("Download Products of brand");
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
        $query = Portfolio::find();
        $query->from(['portfolioPrimary' => Portfolio::tableName()]);
        $query->where(['portfolioPrimary.target' => Portfolio::TARGET_PRODUCT]);
        $query->joinWith([
            'product' => function ($query) use ($uid) {
                /**
                 * @var $query ProductQuery
                 */
                $query->from(['product' => Product::tableName()]);
                $query->joinWith([
                    'productBusinessUnits' => function ($query) use ($uid) {
                        /**
                         * @var $query ProductSectorQuery
                         */
                        $query->from(['productBusinessUnits' => ProductBusinessUnit::tableName()]);
                        $query->joinWith([
                            'businessUnit' => function ($query) use ($uid) {
                                /**
                                 * @var $query SectorQuery
                                 */
                                $query->from(['businessUnit' => BusinessUnit::tableName()]);
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
        $query->orderBy('portfolioPrimary.position ASC, portfolioPrimary.name ASC');
        $products = $query->all();
        Log::trace("Download Products of Business Unit");
        return ['products' => $products];
    }

    /**
     * @SWG\Get(
     *     path="/products/{uid}/business-units",
     *     tags={"Portfolio"},
     *     summary="Retrieves all business units of product",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Portfolios response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="uid", required=true, in="path", type="string", description="The Portfolio UID")
     * )
     */
    public function actionProductBusinessUnits($uid)
    {
        $query = Portfolio::find();
        $query->from(['portfolioPrimary' => Portfolio::tableName()]);
        $query->where(['portfolioPrimary.target' => Portfolio::TARGET_BUSINESS_UNIT]);
        $query->joinWith([
            'businessUnit' => function ($query) use ($uid) {
                /**
                 * @var $query BusinessUnitQuery
                 */
                $query->from(['businessUnit' => BusinessUnit::tableName()]);
                $query->joinWith([
                    'businessUnitProducts' => function ($query) use ($uid) {
                        /**
                         * @var $query ProductSectorQuery
                         */
                        $query->from(['businessUnitProducts' => ProductBusinessUnit::tableName()]);
                        $query->joinWith([
                            "product" => function ($query) use ($uid) {
                                /**
                                 * @var $query SectorQuery
                                 */
                                $query->from(["product" => Product::tableName()]);
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
        $query->orderBy('portfolioPrimary.position ASC, portfolioPrimary.name ASC');
        $businessUnits = $query->all();
        Log::trace("Download Business Units of Product");
        return ['businessUnits' => $businessUnits];
    }

    /**
     * @SWG\Get(
     *     path="/products/bundling-packing",
     *     tags={"Portfolio"},
     *     summary="Retrieves the collection of products bundling & packing resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "products bundling & packing response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionBundlingPacking()
    {
        Log::trace("Download Bundling & Packing Products");
        return ['list' => $this->list(Portfolio::TARGET_BUNDLING_AND_PACKING)];
    }
}
