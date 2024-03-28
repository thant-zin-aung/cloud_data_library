<?php
    require_once 'vendor/autoload.php';
    use Kunnu\Dropbox\Dropbox;
    use Kunnu\Dropbox\DropboxApp;

    $appClient = "";
    $appSecret = "";

    $app = new DropboxApp($appClient, $appSecret);
    $dropbox = new Dropbox($app);
?>