<?php
    require_once 'header.php';
    $appRootDirectory = "application_data";

    function cloud_set_refresh_token($refreshToken) {
        $refreshTokenFilename = "dropbox-api-refresh-token";
        $textFile = fopen($refreshTokenFilename,"w");
        fwrite($textFile,$refreshToken);
        fclose($textFile);
    }

    if (isset($_GET['code']) && isset($_GET['state'])) {    
        //Bad practice! No input sanitization!
        $code = $_GET['code'];
        $state = $_GET['state'];

        //Fetch the AccessToken
        $accessToken = $authHelper->getAccessToken($code, $state, $callbackUrl);    

        cloud_set_refresh_token($accessToken->getRefreshToken());
        echo "<script>window.location.href='index.php'</script>";
    }
?>