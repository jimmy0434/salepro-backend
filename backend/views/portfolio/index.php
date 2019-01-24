<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/24/2019
 * Time: 5:05 PM
 *
 * @var $this View
 * @var $dataLocator DataLocator
 * @var $context PortfolioController
 */

use backend\controllers\PortfolioController;
use cnd\grid\DataLocator;
use yii\web\View;

$context = $this->context;

$this->title = "Portfolio Management | " . $context->targets[$context->target];
$this->title = "Portfolio Management | " . $context->targets[$context->target];