<?php
session_start();

require_once 'vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

//Configure Dropbox Application
$app = new DropboxApp("z64dx6empd79rc8", "o7z2262itlx9aat");

//Configure Dropbox service
$dropbox = new Dropbox($app);

//DropboxAuthHelper
$authHelper = $dropbox->getAuthHelper();

//Callback URL
$callbackUrl = "http://localhost/data_library_web_project/login-callback.php";

// Additional user provided parameters to pass in the request
$params = [];

// Url State - Additional User provided state data
$urlState = null ;

// Token Access Type
$tokenAccessType = "offline";
?>