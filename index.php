<?php
    session_start();
    $_SESSION['share-directory'] = "Public";
    $_SESSION['developer_name'] = "";
    $_SESSION['developer_type'] = "";
    $_SESSION['developer_profile'] = "";
    
    include('execute_functions.php');
    include('cloud_execute_functions.php');

    $appRootDirectory = "application_data";

    // cloud_set_access_token($dropbox,$appClient,$appSecret);

    // Check app data folder was created or not on php server...
    if (!file_exists($appRootDirectory)) {
        mkdir($appRootDirectory);
    }
    // Check app data folder was created or not on dropbox cloud server...
    if ( !cloud_file_exists($dropbox,"/".$appRootDirectory) ) {
        cloud_create_folder($dropbox,"/".$appRootDirectory);
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blacksky Data Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="styles/explore-button-style.css">
    <link rel="stylesheet" href="styles/download-button-style.css">
    <link rel="stylesheet" href="styles/app-style.css">
</head>
<body>
    <nav>
        <div class="app-title-wrapper">
            <div>
                <i class="fa-solid fa-cloud-arrow-up"></i> BLACKSKY
            </div>
            <div class="app-sub-title">
                data library cloud
            </div>
        </div>
        <div class="add-user-button">
            <lord-icon
                src="https://cdn.lordicon.com/mecwbjnp.json"
                trigger="hover"
                style="width:40px;height:40px">
            </lord-icon>
        </div>
    </nav>

    <section id="user-list">
        <div class="title">List of users</div>

        <div class="user-list-wrapper splide__list">
            <?php
                // $scanDir = scandir($appRootDirectory);
                $scanDir = getSortedDirNames($appRootDirectory);
                for ( $count = 0 ; $count < sizeof($scanDir) ; $count++ ) {
                    // skipping if the data is not a directory...
                    if ( !is_dir($appRootDirectory."/".$scanDir[$count] )) continue;
                    $profilePath = getProfilePhoto($appRootDirectory,$scanDir[$count]);
                    $developerType = getDeveloperTypeText($appRootDirectory,$scanDir[$count]);
                    ?>
                        <div class="user-wrapper splide__slide">
                        <div class="overlay" style="background-image: url('<?php echo $profilePath?>');" loading="lazy"></div>
                            <div class="data-wrapper">
                                <div class="image-wrapper"><img src="<?php echo $profilePath?>" alt="Profile photo" loading="lazy"></div>
                                <div class="name-wrapper"><?php echo $scanDir[$count]?></div>
                                <div class="specialist-wrapper"><?php echo $developerType?></div>
                                <form action="profile.php" method="POST">
                                    <input type="text" value="<?php echo $profilePath?>" name="developer_profile" style="display: none;">
                                    <input type="text" value="<?php echo $scanDir[$count]?>" name="developer_name" style="display: none;">
                                    <input type="text" value="<?php echo $developerType?>" name="developer_type" style="display: none;">
                                    <button class="explore-button" type="submit" name="explore_more_button">
                                        <span class="explore-button_lg">
                                            <span class="explore-button_sl"></span>
                                            <span class="explore-button_text">Explore More</span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </section>

    <section id="public-share-data">
        <div class="title">For All Developers</div>

        <div class="share-data-list-wrapper">


            <?php
                // $scanDir = scandir($appRootDirectory);
                // $scanDir = getSortedPublicFilenames($appRootDirectory);
                $totalDir = cloud_get_total_list_of_folders($dropbox,"/".$appRootDirectory,false);
                $folderItems = cloud_get_list_of_folder_items($dropbox,"/".$appRootDirectory,false);
                foreach ( $folderItems as $item ) {
                        $filename = getFileNameWithoutExt($item->getName());
                        $fileExt = getExtWithoutFilename($item->getName());
                        $fileSize = convertByteToMegabyte($item->getSize());
                        $fileUploadDate = convertReadableDateFormat($item->getClientModified());
                        $fileThumbnail = cloud_get_file_thumbnail($dropbox,"/".$appRootDirectory,$item);
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
    <script src="scripts/app-script.js"></script>
</body>
</html>