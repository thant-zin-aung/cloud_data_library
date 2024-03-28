<?php
    include('cloud_execute_functions.php');
    if ( isset($_POST['download_button']) ) {
        $downloadFilepath = $_POST['download_filepath'];
        $downloadLink = cloud_get_download_link($dropbox,$downloadFilepath);

        // echo "<script>self.close()</script>";
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <title>Download File</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .icon-wrapper {
            font-size: 80px;
        }
        .text-wrapper {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 0.3em;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <iframe src="<?php echo $downloadLink?>" width=0 height=0 style="visibility: hidden;"></iframe>

    <div class="wrapper">
        <div class="icon-wrapper"><i class="fa-solid fa-download fa-bounce"></i></div>
        <div class="text-wrapper">DOWNLOADING</div>
    </div>

    <script>
        setTimeout(function() {
            self.close();
        }, 3000);
    </script>
</body>
</html>