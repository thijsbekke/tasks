<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 19:12
 */

session_start();
include "vendor/autoload.php";

chdir(__DIR__);

$whoops = new \Whoops\Run;
if(php_sapi_name() !== 'cli') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}else{
    $whoops->pushHandler(new \Whoops\Handler\PlainTextHandler);
}

$whoops->register();

include_once "app/Config.php";
include_once "app/Database.php";
include_once "app/Controllers/AuthController.php";
include_once "app/TokenStore/TokenCache.php";
include_once "app/Controllers/OutlookController.php";
include_once "app/Controllers/Outlook/Task.php";

$GLOBALS['OAUTH_APP_ID'] = Config::get('connectors.outlook.oauth.app_id');
$GLOBALS['OAUTH_APP_PASSWORD'] = Config::get('connectors.outlook.oauth.app_password');
$GLOBALS['OAUTH_REDIRECT_URI'] = Config::get('connectors.outlook.oauth.redirect_uri');
$GLOBALS['OAUTH_SIGNIN_URI'] = Config::get('connectors.outlook.oauth.signin_uri');
$GLOBALS['OAUTH_AUTHORIZE_ENDPOINT'] = 'common/oauth2/v2.0/authorize';
$GLOBALS['OAUTH_AUTHORITY'] = 'https://login.microsoftonline.com/';
$GLOBALS['OAUTH_TOKEN_ENDPOINT'] = 'common/oauth2/v2.0/token';
$GLOBALS['OAUTH_SCOPES'] = 'openid profile offline_access user.read tasks.read';

function dd() {
    $args = func_get_args();

    foreach ($args as $key => $value) {
        echo "<pre>" .  print_r($value, 1) . "</pre>";
    }

    die;
}


function env($key) {
    return $GLOBALS[$key] ?? '';
}

