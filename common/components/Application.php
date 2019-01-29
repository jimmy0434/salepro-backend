<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 07/11/2018
 * Time: 09:28
 */

namespace common\components;

use backend\components\BiMapSync;
use cnd\cms\components\Cms;
use cnd\core\components\Authentication;
use cnd\core\components\Core;
use cnd\core\components\Helper;
use cnd\core\components\Image;
use cnd\core\components\Setting;
use cnd\core\data\TimeZone;
use cnd\notification\components\Notification;
use cnd\notification\components\PushNotification;
use yii\db\Connection;
use yii\web\UrlManager;


/**
 * Class Application
 *
 * @property Helper $helper
 * @property Core $core
 * @property Authentication $authentication
 * @property Setting $setting
 * @property Notification $notification
 * @property PushNotification $pushNotification
 * @property Cms $cms
 * @property Image $image
 * @property TimeZone $timezone
 * @property string $currency
 * @property UrlManager $urlManagerFrontend
 * @property UrlManager $urlManagerBackend
 * @property UrlManager $urlManagerApi
 * @property Keycloak $keycloak
 * @property Connection $bi
 * @property BiMapSync $biMapSync
 *
 */
class Application extends \yii\web\Application
{
    public function secretKey($id, $order)
    {
        return "CD" . $id . "?.*" . $order . "MP";
    }

    public function countries()
    {
        $list = [];
        $list["Afghanistan"] = "Afghanistan";
        $list["Albania"] = "Albania";
        $list["Algeria"] = "Algeria";
        $list["Andorra"] = "Andorra";
        $list["Angola"] = "Angola";
        $list["Antigua"] = "Antigua";
        $list["Argentina"] = "Argentina";
        $list["Armenia"] = "Armenia";
        $list["Aruba"] = "Aruba";
        $list["Australia"] = "Australia";
        $list["Austria"] = "Austria";
        $list["Azerbaijan"] = "Azerbaijan";
        $list["Bahamas"] = "Bahamas";
        $list[" The"] = " The";
        $list["Bahrain"] = "Bahrain";
        $list["Bangladesh"] = "Bangladesh";
        $list["Barbados"] = "Barbados";
        $list["Belarus"] = "Belarus";
        $list["Belgium"] = "Belgium";
        $list["Belize"] = "Belize";
        $list["Benin"] = "Benin";
        $list["Bhutan"] = "Bhutan";
        $list["Bolivia"] = "Bolivia";
        $list["Bosnia and Herzegovina"] = "Bosnia and Herzegovina";
        $list["Botswana"] = "Botswana";
        $list["Brazil"] = "Brazil";
        $list["Brunei "] = "Brunei ";
        $list["Bulgaria"] = "Bulgaria";
        $list["Burkina Faso"] = "Burkina Faso";
        $list["Burma"] = "Burma";
        $list["Burundi"] = "Burundi";
        $list["Cambodia"] = "Cambodia";
        $list["Cameroon"] = "Cameroon";
        $list["Canada"] = "Canada";
        $list["Cape Verde"] = "Cape Verde";
        $list["Central African Republic"] = "Central African Republic";
        $list["Chad"] = "Chad";
        $list["Chile"] = "Chile";
        $list["China"] = "China";
        $list["Colombia"] = "Colombia";
        $list["Comoros"] = "Comoros";
        $list["Congo"] = "Congo";
        $list[" Democratic Republic of the"] = " Democratic Republic of the";
        $list["Congo"] = "Congo";
        $list[" Republic of the"] = " Republic of the";
        $list["Costa Rica"] = "Costa Rica";
        $list["Cote d'Ivoire"] = "Cote d'Ivoire";
        $list["Croatia"] = "Croatia";
        $list["Cuba"] = "Cuba";
        $list["Curacao"] = "Curacao";
        $list["Cyprus"] = "Cyprus";
        $list["Czech Republic"] = "Czech Republic";
        $list["Denmark"] = "Denmark";
        $list["Djibouti"] = "Djibouti";
        $list["Dominica"] = "Dominica";
        $list["Dominican Republic"] = "Dominican Republic";
        $list["Ecuador"] = "Ecuador";
        $list["Egypt"] = "Egypt";
        $list["El Salvador"] = "El Salvador";
        $list["Equatorial Guinea"] = "Equatorial Guinea";
        $list["Eritrea"] = "Eritrea";
        $list["Estonia"] = "Estonia";
        $list["Ethiopia"] = "Ethiopia";
        $list["Fiji"] = "Fiji";
        $list["Finland"] = "Finland";
        $list["France"] = "France";
        $list["Gabon"] = "Gabon";
        $list["Gambia"] = "Gambia";
        $list[" The"] = " The";
        $list["Georgia"] = "Georgia";
        $list["Germany"] = "Germany";
        $list["Ghana"] = "Ghana";
        $list["Greece"] = "Greece";
        $list["Grenada"] = "Grenada";
        $list["Guatemala"] = "Guatemala";
        $list["Guinea"] = "Guinea";
        $list["Guinea-Bissau"] = "Guinea-Bissau";
        $list["Guyana"] = "Guyana";
        $list["Haiti"] = "Haiti";
        $list["Holy See"] = "Holy See";
        $list["Honduras"] = "Honduras";
        $list["Hong Kong"] = "Hong Kong";
        $list["Hungary"] = "Hungary";
        $list["Iceland"] = "Iceland";
        $list["India"] = "India";
        $list["Indonesia"] = "Indonesia";
        $list["Iran"] = "Iran";
        $list["Iraq"] = "Iraq";
        $list["Ireland"] = "Ireland";
        $list["Israel"] = "Israel";
        $list["Italy"] = "Italy";
        $list["Jamaica"] = "Jamaica";
        $list["Japan"] = "Japan";
        $list["Jordan"] = "Jordan";
        $list["Kazakhstan"] = "Kazakhstan";
        $list["Kenya"] = "Kenya";
        $list["Kiribati"] = "Kiribati";
        $list["Korea"] = "Korea";
        $list[" North"] = " North";
        $list["Korea"] = "Korea";
        $list[" South"] = " South";
        $list["Kosovo"] = "Kosovo";
        $list["Kuwait"] = "Kuwait";
        $list["Kyrgyzstan"] = "Kyrgyzstan";
        $list["Laos"] = "Laos";
        $list["Latvia"] = "Latvia";
        $list["Lebanon"] = "Lebanon";
        $list["Lesotho"] = "Lesotho";
        $list["Liberia"] = "Liberia";
        $list["Libya"] = "Libya";
        $list["Liechtenstein"] = "Liechtenstein";
        $list["Lithuania"] = "Lithuania";
        $list["Luxembourg"] = "Luxembourg";
        $list["Macau"] = "Macau";
        $list["Macedonia"] = "Macedonia";
        $list["Madagascar"] = "Madagascar";
        $list["Malawi"] = "Malawi";
        $list["Malaysia"] = "Malaysia";
        $list["Maldives"] = "Maldives";
        $list["Mali"] = "Mali";
        $list["Malta"] = "Malta";
        $list["Marshall Islands"] = "Marshall Islands";
        $list["Mauritania"] = "Mauritania";
        $list["Mauritius"] = "Mauritius";
        $list["Mexico"] = "Mexico";
        $list["Micronesia"] = "Micronesia";
        $list["Moldova"] = "Moldova";
        $list["Monaco"] = "Monaco";
        $list["Mongolia"] = "Mongolia";
        $list["Montenegro"] = "Montenegro";
        $list["Morocco"] = "Morocco";
        $list["Mozambique"] = "Mozambique";
        $list["Namibia"] = "Namibia";
        $list["Nauru"] = "Nauru";
        $list["Nepal"] = "Nepal";
        $list["Netherlands"] = "Netherlands";
        $list["Netherlands Antilles"] = "Netherlands Antilles";
        $list["New Zealand"] = "New Zealand";
        $list["Nicaragua"] = "Nicaragua";
        $list["Niger"] = "Niger";
        $list["Nigeria"] = "Nigeria";
        $list["North Korea"] = "North Korea";
        $list["Norway"] = "Norway";
        $list["Oman"] = "Oman";
        $list["Pakistan"] = "Pakistan";
        $list["Palau"] = "Palau";
        $list["Palestinian Territories"] = "Palestinian Territories";
        $list["Panama"] = "Panama";
        $list["Papua New Guinea"] = "Papua New Guinea";
        $list["Paraguay"] = "Paraguay";
        $list["Peru"] = "Peru";
        $list["Philippines"] = "Philippines";
        $list["Poland"] = "Poland";
        $list["Portugal"] = "Portugal";
        $list["Qatar"] = "Qatar";
        $list["Romania"] = "Romania";
        $list["Russia"] = "Russia";
        $list["Rwanda"] = "Rwanda";
        $list["Saint Kitts and Nevis"] = "Saint Kitts and Nevis";
        $list["Saint Lucia"] = "Saint Lucia";
        $list["Saint Vincent and the Grenadines"] = "Saint Vincent and the Grenadines";
        $list["Samoa "] = "Samoa ";
        $list["San Marino"] = "San Marino";
        $list["Sao Tome and Principe"] = "Sao Tome and Principe";
        $list["Saudi Arabia"] = "Saudi Arabia";
        $list["Senegal"] = "Senegal";
        $list["Serbia"] = "Serbia";
        $list["Seychelles"] = "Seychelles";
        $list["Sierra Leone"] = "Sierra Leone";
        $list["Singapore"] = "Singapore";
        $list["Sint Maarten"] = "Sint Maarten";
        $list["Slovakia"] = "Slovakia";
        $list["Slovenia"] = "Slovenia";
        $list["Solomon Islands"] = "Solomon Islands";
        $list["Somalia"] = "Somalia";
        $list["South Africa"] = "South Africa";
        $list["South Korea"] = "South Korea";
        $list["South Sudan"] = "South Sudan";
        $list["Spain "] = "Spain ";
        $list["Sri Lanka"] = "Sri Lanka";
        $list["Sudan"] = "Sudan";
        $list["Suriname"] = "Suriname";
        $list["Swaziland "] = "Swaziland ";
        $list["Sweden"] = "Sweden";
        $list["Switzerland"] = "Switzerland";
        $list["Syria"] = "Syria";
        $list["Taiwan"] = "Taiwan";
        $list["Tajikistan"] = "Tajikistan";
        $list["Tanzania"] = "Tanzania";
        $list["Thailand "] = "Thailand ";
        $list["Timor-Leste"] = "Timor-Leste";
        $list["Togo"] = "Togo";
        $list["Tonga"] = "Tonga";
        $list["Trinidad and Tobago"] = "Trinidad and Tobago";
        $list["Tunisia"] = "Tunisia";
        $list["Turkey"] = "Turkey";
        $list["Turkmenistan"] = "Turkmenistan";
        $list["Tuvalu"] = "Tuvalu";
        $list["Uganda"] = "Uganda";
        $list["Ukraine"] = "Ukraine";
        $list["United Arab Emirates"] = "United Arab Emirates";
        $list["United Kingdom"] = "United Kingdom";
        $list["United States of America"] = "United States of America";
        $list["Uruguay"] = "Uruguay";
        $list["Uzbekistan"] = "Uzbekistan";
        $list["Vanuatu"] = "Vanuatu";
        $list["Venezuela"] = "Venezuela";
        $list["Vietnam"] = "Vietnam";
        $list["Yemen"] = "Yemen";
        $list["Zambia"] = "Zambia";
        $list["Zimbabwe"] = "Zimbabwe";
        return $list;
    }

    static private $regionsList = null;
    public function regions()
    {
        if(!static::$regionsList) {
            $default = 'Middle East,Asia,Europe,Africa,North America,South Americ';
            $regions = explode(',',\cnd\admin\models\activerecords\Setting::get('regions', $default));
            static::$regionsList = [];
            if(!empty($regions) && is_array($regions)){
                foreach($regions as $region){
                    static::$regionsList[$region] = $region;
                }
            }
        }
        return static::$regionsList;
    }
}
