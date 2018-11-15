<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 14:42
 */

namespace restful\controllers;

use Yii;
use cnd\core\api\Controller;

class PublicController extends Controller
{
    public function actionTest(){
        return ['done'=>true];
    }

    public function actionLogin()
    {
        $keycloak = Yii::$app->keycloak;
        $options = [
            'authServerUrl' => $keycloak->authServerUrl,
            'realm' => $keycloak->realm,
            'clientId' => $keycloak->clientId,
            'clientSecret' => $keycloak->clientSecret,
            'redirectUri' => $keycloak->redirectUri,
        ];
        if($keycloak->encryptionAlgorithm){
            $options['encryptionAlgorithm'] = $keycloak->encryptionAlgorithm;
        }
        if($keycloak->encryptionKeyPath){
            $options['encryptionKeyPath'] = $keycloak->encryptionKeyPath;
        }
        if($keycloak->encryptionKey){
            $options['encryptionKey'] = $keycloak->encryptionKey;
        }

        $provider = new \Stevenmaguire\OAuth2\Client\Provider\Keycloak($options);

        if (!isset($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authUrl);
            exit;

            // Check given state against previously stored one to mitigate CSRF attack
        }/* elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            unset($_SESSION['oauth2state']);
            exit('Invalid state, make sure HTTP sessions are enabled.');

        }*/ else {

            // Try to get an access token (using the authorization coe grant)
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                exit('Failed to get access token: ' . $e->getMessage());
            }

            $user = null;
            // Optional: Now you have a token you can look up a users profile data
            try {

                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

                // Use these details to create a new profile
                //printf('Hello %s!', $user->getName());

            } catch (Exception $e) {
                exit('Failed to get resource owner: ' . $e->getMessage());
            }

            // Use this to interact with an API on the users behalf
            return ['user' => $user->toArray(), 'token' => $token->getToken()];
        }
    }
}