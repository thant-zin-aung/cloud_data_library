<?php
    include('execute_functions.php');
    include('cloud_execute_functions.php');
    $cloudStorage = $dropbox->getSpaceUsage();

    $cloudUsedSpacePercent = cloud_get_percent_of_free_space($cloudStorage);
    $cloudTotalSpace = cloud_get_total_space_in_gb($cloudStorage);
    $cloudUsedSpace = cloud_get_used_space_in_gb($cloudStorage);
    $phpUsedSpacePercent = getPercentageOfFreeSpace();
    $phpTotalSpace = getTotalSpaceOfPhpServer();
    $phpUsedSpace = getUsedSpaceOfPhpServer();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Tab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/app-style.css">
    <link rel="stylesheet" href="styles/toggle-switch-style.css">
    <link rel="stylesheet" href="styles/setting-tab-style.css">
</head>
<body>
    
    <div class="title-wrapper">
        Settings
    </div>

    <div class="storage-wrapper">
        <div class="sub-title-wrapper">Storage statistics</div>

        <div class="storage-statistic-wrapper php-storage">
            <div class="progress-bar php-progress" style="width: <?php echo $phpUsedSpacePercent?>%;"></div>
            <div class="info-wrapper">
                <div class="left-wrapper">
                    <div class="percent-wrapper">
                        <div class="percent"><?php echo $phpUsedSpacePercent?>%</div>
                    </div>
                </div>
                <div class="right-wrapper">
                    <div class="storage-title">Available PHP Server Storage</div>
                    <div class="storage"><?php echo $phpUsedSpace?> GB out of <?php echo $phpTotalSpace?> GB used</div>
                </div>
            </div>
        </div>
        <div class="storage-statistic-wrapper cloud-storage">
            <div class="progress-bar cloud-progress" style="width: <?php echo $cloudUsedSpacePercent?>%;"></div>
            <div class="info-wrapper">
                <div class="left-wrapper">
                    <div class="percent-wrapper">
                        <div class="percent"><?php echo $cloudUsedSpacePercent?>%</div>
                    </div>
                </div>
                <div class="right-wrapper">
                    <div class="storage-title">Available Cloud Storage</div>
                    <div class="storage"><?php echo $cloudUsedSpace?> GB out of <?php echo $cloudTotalSpace?> GB used</div>
                </div>
            </div>
        </div>
    </div>

    <div class="app-setting-wrapper">
        <div class="sub-title-wrapper">App settings</div>
        <div class="setting-wrapper">
            <div class="text-wrapper">
                <div class="title">Dark Mode</div>
                <div class="sub-title">Not supported in this version</div>
            </div>
            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
        </div>
        <div class="setting-wrapper">
            <div class="text-wrapper">
                <div class="title">Upload Filesize Limit</div>
                <div class="sub-title">Limiting upload filesize to 5mb</div>
            </div>
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>
    </div>




    <div class="navigation-bar">
        <div class="tab-wrapper home-tab">
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

        <div class="tab-wrapper setting-tab selected-tab-color">
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

    <script src="scripts/setting-tab-script.js"></script>
</body>
</html>