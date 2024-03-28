<?php
    include('cloud_execute_functions.php');

    $appRootDirectory = "application_data";
    $profilePhotoName = "profile_photo";
    $developerTypeFilename = "developer_type";

    if ( isset($_POST['submit']) ) {
        $name = $_POST['name'];
        $developerType = $_POST['developer_type'];

        // If the user is new and directory was not created...
        if ( !file_exists($appRootDirectory."/".$name) ) {
            $createDirectory = mkdir($appRootDirectory."/".$name);
            $file_name = $_FILES['profile_photo_file']['name'];
            $file_tmp = $_FILES['profile_photo_file']['tmp_name'];
            $file_ext = substr(strrchr($file_name, '.'), 1);
            $uploadFile;
            
            if ( $createDirectory ) {
                $uploadFile = move_uploaded_file($file_tmp , $appRootDirectory."/".$name."/".$profilePhotoName.".".$file_ext);
            }

            if ( $uploadFile ) {
                $textFile = fopen($appRootDirectory."/".$name."/".$developerTypeFilename,"w");
                fwrite($textFile,$developerType);
                fclose($textFile);
                cloud_create_folder($dropbox,"/".$appRootDirectory."/".$name);
                echo "<script>window.location.href='index.php'</script>";
                
            }
        
        } else {
            echo "<script>alert('Error code: username $name is already exist.') </script>";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/add-user-button.css">
    <link rel="stylesheet" href="styles/add-user-style.css">
</head>
<body>
    <nav>
        <i class="fa-solid fa-arrow-left-long back-button"></i>
        <div class="title-wrapper">Profile</div>
        <i class="fa-solid fa-id-card"></i>
    </nav>

    <section id="data">
        <form action="#" method="POST" enctype="multipart/form-data">
            <input type="file" accept="image/*" id="profile-photo-file" name="profile_photo_file" required>
            <label for="profile-photo-file">
                <div class="profile-card">
                    <div class="profile-data-wrapper">
                        <i class="fa-solid fa-image"></i>
                        <div class="add-profile-text">Add profile photo</div>
                        <div class="add-profile-hint-text">Potrait photo is better</div>
                    </div>
                </div>
            </label>

            <label for="profile-name" class="box-label">Enter full name</label>
            <input type="text" id="profile-name" class="input-box" spellcheck="false" name="name" required>

            <label for="profile-name" class="box-label">Enter developer type</label>
            <input type="text" id="profile-name" class="input-box" spellcheck="false" name="developer_type" required>

            <button class="explore-button" type="submit" name="submit">
                <span class="explore-button_lg">
                    <span class="explore-button_sl"></span>
                    <span class="explore-button_text">Add New Profile</span>
                </span>
            </button>
        </form>
        
    </section>


    <script src="scripts/add-user-script.js"></script>
</body>
</html>