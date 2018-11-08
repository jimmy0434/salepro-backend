<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 14:43
 */

namespace common\components;


use yii\base\Component;

class Keycloak extends Component
{
    public $authServerUrl;
    public $realm;
    public $clientId;
    public $clientSecret;
    public $redirectUri = ['/auth/login'];
    public $encryptionAlgorithm = null; // 'RS256'
    public $encryptionKeyPath = null; // 'key.pem'
    public $encryptionKey = null; // contents_of_key_or_certificate
}