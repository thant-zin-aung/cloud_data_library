<?php
    include('dropbox_api.php');

    cloud_set_access_token($dropbox,$appClient,$appSecret);

    function cloud_set_refresh_token($refreshToken) {
        $refreshTokenFilename = "dropbox-api-refresh-token";
        $textFile = fopen($refreshTokenFilename,"w");
        fwrite($textFile,$refreshToken);
        fclose($textFile);
    }

    function cloud_get_refresh_token() {
        $refreshTokenFilename = "dropbox-api-refresh-token";
        $file = fopen($refreshTokenFilename,"r");
        $refesh_token = "";
        while (!feof($file)) {
            $refesh_token = fgets($file);
        }
        fclose($file);
        return $refesh_token;
    }

    function cloud_generate_new_access_token($appClient,$appSecret,$refreshToken) {
        $arr = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.dropbox.com/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=$refreshToken");
        curl_setopt($ch, CURLOPT_USERPWD, $appClient. ':' . $appSecret);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $result_arr = json_decode($result,true);
        
        if (curl_errno($ch)) {
            $arr = ['status'=>'error','token'=>null];
        }elseif(isset($result_arr['access_token'])){
            $arr = ['status'=>'okay','token'=>$result_arr['access_token']];
        }
        curl_close($ch);
        return $arr['token'];
    }

    function cloud_set_access_token($dropbox,$appClient,$appSecret) {
        $refreshTokenFilename = "dropbox-api-refresh-token";
        if ( !file_exists($refreshTokenFilename) ) {
            echo "<script>window.location.href='login.php'</script>";
        } else {
            $newAccessToken = cloud_generate_new_access_token($appClient,$appSecret,cloud_get_refresh_token());
            $dropbox->setAccessToken($newAccessToken);
        }
    }

    function check_access_token_error($dropbox,$errorText,$exceptionMessage) {
        return strpos($exceptionMessage,$errorText) !== false;
    }

    // checking folder or file is exists on dropbox....
    function cloud_file_exists($dropbox,$path) {
        try {
            $dropbox->getMetadata($path);
            return true;
        } catch ( Exception $e ) {
            if ( check_access_token_error($dropbox,"expired_access_token",$e->getMessage())) {
                echo "[Error]: cloud drive access token expired<br>";
            }
            return false;
        }
    }


    // Create Folder
    function cloud_create_folder($dropbox,$path) {
        try {
            $dropbox->createFolder($path);
        } catch ( Exception $e ) {
            echo "[Error]: cloud create folder error<br>";
        }
    }

    function cloud_upload_file($dropbox,$dropboxFile,$destPath) {
        try {
            $dropbox->simpleUpload($dropboxFile, $destPath, ['autorename' => true]); 
            return true;
        } catch ( Exception $e ) {
            echo "[Error]: cloud file upload error<br>";
            return false;
        }
    }

    function cloud_get_total_list_of_folders($dropbox,$path,$scanFolder) {
        $listFolderContents = $dropbox->listFolder($path);
        $items = $listFolderContents->getItems();
        $files = 0;
        $tag = $scanFolder ? "folder" : "file";
        foreach($items as $item) {
            if ( $item->getTag() == $tag ) {
                ++$files;
            }
        }
        return $files;
    }

    function cloud_get_list_of_folder_items($dropbox, $path, $scanFolder ) {
        $listFolderContents = $dropbox->listFolder($path);
        $items = $listFolderContents->getItems();
        $createDatesArray = array();
        $itemArray = array();
        $tag = $scanFolder ? "folder" : "file";

        foreach ( $items as $item ) {
            if ( $item->getTag() == $tag  && strpos($item->getName(),"-thumbnail-status") === false ) {
                array_push($createDatesArray,$item->getClientModified());
            } 
        }
        // Sorting files in decending order....
        rsort($createDatesArray);

        foreach($createDatesArray as $date) {
            foreach($items as $item) {
                if ( $item->getTag() == $tag  && strpos($item->getName(),"-thumbnail-status") === false && 
                        $item->getClientModified() == $date ) {
                    array_push($itemArray,$item);
                    break;
                }
            }
        }
        return $itemArray;
    }

    function cloud_get_list_of_folder_items_thumbnails($dropbox, $path ) {
        $listFolderContents = $dropbox->listFolder($path);
        $items = $listFolderContents->getItems();
        $itemArray = array();
        
        foreach ( $items as $item ) {
            if ( strpos($item->getName(),"-thumbnail-status") !== false ) {
                array_push($itemArray,$item);
            } 
        }

        return $itemArray;
    }

    function cloud_get_file_thumbnail($dropbox,$path,$file) {
        $phpServerFiles = scandir(substr($path,1));
        for ( $count = 2 ; $count < sizeof($phpServerFiles) ; $count++ ) {
            if ( strpos($phpServerFiles[$count], getFileNameWithoutExt($file->getName())) !== false ) {
                return substr($path,1)."/".$phpServerFiles[$count];
            }
        }
        $appRootDirectory = "application_data";
        $totalFiles = cloud_get_list_of_folder_items_thumbnails($dropbox,$path);
        $realFilename = getFileNameWithoutExt($file->getName());
        $thumbnailCloudPath;

        foreach ($totalFiles as $item ) {
            if ( strpos($item->getName(),$realFilename) !== false ) {
                $thumbnailCloudPath = $item->getPathDisplay();
                break;
            }
        }

        // Available sizes: 'thumb', 'small', 'medium', 'large', 'huge'
        $size = 'large';
        $format = 'jpeg';
        $thumbnailMetadata = $dropbox->getMetadata($thumbnailCloudPath);
        $thumbnailFile = $dropbox->getThumbnail($thumbnailCloudPath, $size, $format);
        $thumbnailFilename = $thumbnailMetadata->getName();
        $contents = $thumbnailFile->getContents();
        file_put_contents(__DIR__ . $path."/".$thumbnailFilename, $contents);
        return substr($path,1)."/".$thumbnailFilename;
    }

    function cloud_get_file_status($thumbnailPath) {
        $filename = getFileNameWithoutExt($thumbnailPath);
        return substr(strrchr($filename, '-'), 1);
    }

    function cloud_get_download_link($dropbox,$path) {
        $temporaryLink = $dropbox->getTemporaryLink($path);
        return $temporaryLink->getLink();
    }

    function cloud_get_used_space($cloudStorage) {
        return $cloudStorage['used'];
    }
    function cloud_get_used_space_in_gb($cloudStorage) {
        $kb = cloud_get_used_space($cloudStorage)/1024;
        $mb = $kb/1024;
        return number_format($mb/1024,1);
    }
    function cloud_get_total_space($cloudStorage) {
        return $cloudStorage['allocation']['allocated'];
    }
    function cloud_get_total_space_in_gb($cloudStorage) {
        $kb = cloud_get_total_space($cloudStorage)/1024;
        $mb = $kb/1024;
        return number_format($mb/1024,1);
    }
    function cloud_get_percent_of_free_space($cloudStorage) {
        $used = cloud_get_used_space($cloudStorage);
        $allocated = cloud_get_total_space($cloudStorage);
        return number_format(($used/$allocated)*100,0);
    }

?>