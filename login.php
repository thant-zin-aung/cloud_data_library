<?php
require_once 'header.php';

//Fetch the Authorization/Login URL
$authUrl = $authHelper->getAuthUrl($callbackUrl,$params,$urlState,$tokenAccessType);

// echo "<a href='" . $authUrl . "'>Log in with Dropbox</a>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dropbox</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <style>
        *,html {
            padding: 0px;
            margin: 0px;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
        }
        a {
            text-decoration: none;
        }
        .button-wrapper {
            width: 300px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 1px 1px 5px 1px #DEDEDE;
            border-radius: 10px;
            padding: 10px;
        }
        .sync-icon-wrapper,.dropbox-icon-wrapper {
            width: 15%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .sync-icon-wrapper {
            font-size: 35px;
            color: #1B76BA;
        }
        .dropbox-icon-wrapper img {
            width: 100%;
            height: 50%;
            object-fit: cover;
        }
        .text-wrapper {
            width: 80%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: black;
        }
        .text-wrapper .title {
            font-size: 20px;
            font-weight: bold;
        }
        .text-wrapper .sub-title {
            font-size: 12px;
            font-weight: bold;
            opacity: 0.7;
        }

    </style>
</head>
<body>
    <a class="button-wrapper" href="<?php echo $authUrl?>">
        <div class="item sync-icon-wrapper"><i class="fa-solid fa-rotate"></i></div>
        <div class="item text-wrapper">
            <div class="title">Synchronize</div>
            <div class="sub-title">app with dropbox</div>
        </div>
        <div class="item dropbox-icon-wrapper"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Dropbox_Icon.svg/2202px-Dropbox_Icon.svg.png" alt=""></div>
    </a>
</body>
</html>