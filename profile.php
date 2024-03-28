<?php

    session_start();
    include("execute_functions.php");
    include("cloud_execute_functions.php");

    // cloud_set_access_token($dropbox,$appClient,$appSecret);

    $appRootDirectory = "application_data";

    $developerName = $_SESSION['developer_name'];
    $developerType = $_SESSION['developer_type'];
    $developerProfile = $_SESSION['developer_profile'];

    if ( isset($_POST['explore_more_button']) ) {
        $developerName = $_POST['developer_name'];
        $developerType = $_POST['developer_type'];
        $developerProfile = $_POST['developer_profile'];
        $_SESSION['developer_name'] = $developerName;
        $_SESSION['developer_type'] = $developerType;
        $_SESSION['developer_profile'] = $developerProfile;
        $_SESSION['share-directory'] = $developerName;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/download-button-style.css">
    <link rel="stylesheet" href="styles/app-style.css">
    <link rel="stylesheet" href="styles/profile-style.css">
</head>
<body>
    <section id="profile-info">
        <div class="cover-wrapper">
            <div class="cover-image-wrapper">
                <img src="<?php echo $developerProfile?>" alt="">
            </div>
            <div class="profile-wrapper" style="background-image: url('<?php echo $developerProfile?>');"></div>
        </div>

        <div class="name-wrapper"><?php echo $developerName?></div>
        <div class="developer-type-wrapper">@ <?php echo $developerType?></div>
        <div class="skills-wrapper">
            <div class="skill-wrapper">
                <div class="percent-wrapper">70%</div>
                <div class="text-wrapper">free time</div>
            </div>
            <div class="skill-wrapper middle-skill-wrapper">
                <div class="percent-wrapper">20%</div>
                <div class="text-wrapper">money</div>
            </div>
            <div class="skill-wrapper">
                <div class="percent-wrapper">99%</div>
                <div class="text-wrapper">energy</div>
            </div>
        </div>
    </section>


    <section id="share-data">

        <div class="share-data-list-wrapper">
        <?php
                // $scanDir = scandir($appRootDirectory);
                // $scanDir = getSortedPublicFilenames($appRootDirectory);
                $totalDir = cloud_get_total_list_of_folders($dropbox,"/".$appRootDirectory."/".$developerName,false);
                $folderItems = cloud_get_list_of_folder_items($dropbox,"/".$appRootDirectory."/".$developerName,false);
                foreach ( $folderItems as $item ) {
                        $filename = getFileNameWithoutExt($item->getName());
                        $fileExt = getExtWithoutFilename($item->getName());
                        $fileSize = convertByteToMegabyte($item->getSize());
                        $fileUploadDate = convertReadableDateFormat($item->getClientModified());
                        $fileThumbnail = cloud_get_file_thumbnail($dropbox,"/".$appRootDirectory."/".$developerName,$item);
                        $fileStatus = cloud_get_file_status($fileThumbnail);
                    ?>
                    <div class="share-data-wrapper">
                        <div class="image-wrapper" style="background-image: url('<?php echo $fileThumbnail?>');" loading="lazy">
                            <!-- <div class="opacity-div"></div> -->
                        </div>
                        <div class="data-wrapper">
                            <div class="title-wrapper"><?php echo $filename?></div>
                            <div class="type-wrapper">Type: <?php echo $fileExt?></div>
                            <div class="size-wrapper">Size: <?php echo $fileSize?> MB</div>
                            <div class="date-wrapper">Upload date: <?php echo $fileUploadDate?></div>
                        </div>
                        <form action="download-file.php" method="POST" target="_blank">
                            <div class="upper-layer">
                                <input type="text" value="<?php echo $item->getPathDisplay()?>" name="download_filepath" style="display: none;">
                                <button class="download-button-wrapper delete-button" type="submit" name="delete_button">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                                <button class="download-button-wrapper download-button" type="submit" name="download_button">
                                    <i class="fa-solid fa-cloud-arrow-down"></i> Download
                                </button>
                            </div>
                        </form>
                        <div class="status-wrapper <?php echo $fileStatus?>-color"><?php echo $fileStatus?></div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </section>


    <div class="navigation-bar">
        <div class="tab-wrapper home-tab selected-tab-color">
            <div class="icon-wrapper">
                <i class="fa-solid fa-house tab-icon"></i>
                <div class="text-wrapper">Home</div>
            </div>
        </div>

        <div class="tab-wrapper post-tab">
            <div class="icon-wrapper">
                <i class="fa-solid fa-pen-to-square tab-icon"></i>
                <div class="text-wrapper">Post</div>
            </div>
        </div>

        <div class="tab-wrapper add-file-tab">
            <div class="icon-wrapper">
                <div class="add-file-icon-wrapper">
                    <i class="fa-solid fa-plus add-file-icon"></i>
                </div>
            </div>
        </div>

        <div class="tab-wrapper setting-tab">
            <div class="icon-wrapper">
                <i class="fa-solid fa-gear tab-icon"></i>
                <div class="text-wrapper">Settings</div>
            </div>
        </div>

        <div class="tab-wrapper about-tab">
            <div class="icon-wrapper">
                <i class="fa-solid fa-circle-exclamation tab-icon"></i>
                <div class="text-wrapper">About</div>
            </div>
        </div>
    </div>


    <!-- <footer>
        <div>Copyright &copy; 2023, All rights reserved.</div>
        <div>Design & developed by Thant Zin Aung</div>
    </footer> -->

    <script src="scripts/profile-script.js"></script>
</body>
</html>