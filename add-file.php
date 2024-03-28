<?php
    use Kunnu\Dropbox\DropboxFile;

    include('execute_functions.php');
    include('cloud_execute_functions.php');

    session_start();
    $uploadFileSizeLimit = true;
    $shareDirectory = $_SESSION['share-directory'];
    $appRootDirectory = "application_data";

    if ( isset($_POST['submit'] )) {
        $checkedCheckbox = "";
        foreach($_POST['checkbox'] as $checkbox ) $checkedCheckbox = $checkbox;
        // $uploadFile = $_FILES['uploadFile']['name'];
        
        $upload_file_name = $_FILES['uploadFile']['name'];
        $upload_file_tmp = $_FILES['uploadFile']['tmp_name'];
        $upload_file_size = $_FILES['uploadFile']['size'];
        $upload_file_ext = substr(strrchr($upload_file_name, '.'), 1);
        $realFileName = trim($upload_file_name,".".$upload_file_ext);
        // Uploading actual file...
        // $uploadFile = move_uploaded_file($upload_file_tmp , $appRootDirectory."/".$realFileName.".".$upload_file_ext);
        $thumbnail_file_name = $_FILES['thumbnailFile']['name'];
        $thumbnail_file_tmp = $_FILES['thumbnailFile']['tmp_name'];
        $thumbnail_file_size = $_FILES['thumbnailFile']['size'];
        $thumbnail_file_ext = substr(strrchr($thumbnail_file_name, '.'), 1);
        $realFileName = trim($upload_file_name,".".$upload_file_ext);
        // Uploading thumbnail and set status file...
        // $thumbnailFile = move_uploaded_file($thumbnail_file_tmp , $appRootDirectory."/".$realFileName."-thumbnail-status-".$checkedCheckbox.".".$thumbnail_file_ext);

        // Checking if uploader is a public sharer...
        if ( $shareDirectory == "Public" ) {
            $realFileUpload = cloud_upload_file($dropbox,new DropboxFile($upload_file_tmp),"/".$appRootDirectory."/".$upload_file_name);
            if ( $realFileUpload ) cloud_upload_file($dropbox,new DropboxFile($thumbnail_file_tmp),"/".$appRootDirectory."/".$realFileName."-thumbnail-status-".$checkedCheckbox.".".$thumbnail_file_ext);
            echo "<script>window.location.href='index.php'</script>";
        } else {
            $realFileUpload = cloud_upload_file($dropbox,new DropboxFile($upload_file_tmp),"/".$appRootDirectory."/".$shareDirectory."/".$upload_file_name);
            if ($realFileUpload) cloud_upload_file($dropbox,new DropboxFile($thumbnail_file_tmp),"/".$appRootDirectory."/".$shareDirectory."/".$realFileName."-thumbnail-status-".$checkedCheckbox.".".$thumbnail_file_ext);
            echo "<script>window.location.href='profile.php'</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New File</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/loader-style.css">
    <link rel="stylesheet" href="styles/check-box-style.css">
    <link rel="stylesheet" href="styles/gallery-image-style.css">
    <link rel="stylesheet" href="styles/upload-button-style.css">
    <link rel="stylesheet" href="styles/add-file-style.css">
</head>
<body>

    <div class="header finisher-header cover-wrapper" style="width: 100%; height: 270px;">
        <div class="title">File Upload Page</div>
        <div class="sub-title">Upload new file and set the status of importance</div>
        <div class="intro">by <em><u>Blacksky</u></em> - a freelance java developer</div>
        <div class="intro">share to - <em><u class="share-path"><?php echo $shareDirectory?></u></em></div>
    </div>

    <section id="upload-info-wrapper">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="section-title">File and thumbnail</div>
            <div class="file-and-thumbnail-wrapper">
                <div class="file-wrapper">
                    <input type="file" id="file-upload" class="file-input" name="uploadFile" required>
                    <label for="file-upload" class="file-upload-wrapper">
                        <div class="gallary-image"></div>
                        <div class="detail-text">Upload file here</div>
                        <div class="detail-sub-text">the actual file - under 5MB</div>
                    </label>
                </div>
                <div class="thumbnail-wrapper">
                    <input type="file" accept="image/*" id="thumbnail-upload" class="thumbnail-input" name="thumbnailFile" required>
                    <label for="thumbnail-upload" class="thumbnail-upload-wrapper">
                        <div class="gallary-image"></div>
                        <div class="detail-text">Upload thumbnail here</div>
                        <div class="detail-sub-text">thumbnail of actual file</div>
                    </label>
                </div>
            </div>

            <div class="section-title">Status of importance</div>
            <div class="checkbox-wrapper">
                <div class="inner-checkbox-wrapper">
                    <div class="text-wrapper status need-status">Need</div>
                    <label class="container">
                        <input type="checkbox" checked="checked" class="need-checkbox" name="checkbox[]" value="need">
                        <div class="checkmark"></div>
                      </label>
                </div>
                <div class="inner-checkbox-wrapper">
                    <div class="text-wrapper status must-status">Must</div>
                        <label class="container">
                            <input type="checkbox" class="must-checkbox" name="checkbox[]" value="must">
                            <div class="checkmark"></div>
                        </label>
                </div>
                <div class="inner-checkbox-wrapper">
                    <div class="text-wrapper status important-status">Important</div>
                        <label class="container">
                            <input type="checkbox" class="important-checkbox" name="checkbox[]" value="important">
                            <div class="checkmark"></div>
                        </label>
                </div>
            </div>

            <button type="submit" class="btn submit-button" name="submit">
                <strong><i class="fa-solid fa-cloud-arrow-up fa-bounce" style="font-size: 16px"></i> UPLOAD</strong>
                <div id="container-stars">
                  <div id="stars"></div>
                </div>
              
                <div id="glow">
                  <div class="circle"></div>
                  <div class="circle"></div>
                </div>
            </button>              
        </form>
    </section>



    <div class="loading-wrapper">
        <div class="upper-wrapper">
            <div class="text-loader">
                <span class="u">U</span>
                <span class="p">p</span>
                <span class="l">l</span>
                <span class="o">o</span>
                <span class="a">a</span>
                <span class="d">d</span>
                <span class="i">i</span>
                <span class="n">n</span>
                <span class="g">g</span>
                <span class="d1">.</span>
                <span class="d2">.</span>
            </div>
        </div>

        <div class="loader">
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    <script src="scripts/finisher-header.es5.min.js" type="text/javascript"></script>
    <script src="scripts/add-file-script.js"></script>
</body>
</html>