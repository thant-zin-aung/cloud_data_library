<?php

    function getProfilePhoto($appRootDirectory,$username) {
        $scan_process = scandir($appRootDirectory."/".$username);
        for ( $count = 2 ; $count < sizeof($scan_process) ; $count++ ) {
            if ( strpos($scan_process[$count],"profile_photo") !== false ) {
                return $appRootDirectory."/".$username."/".$scan_process[$count];
            }
        }
    }

    function getDeveloperTypeText($appRootDirectory,$username) {
        $file = fopen($appRootDirectory."/".$username."/developer_type","r");
        $dev_type = "";
        while (!feof($file)) {
            $dev_type = fgets($file);
        }
        fclose($file);
        return $dev_type;
    }

    function getSortedDirNames($appRootDirectory) {
        $sortedFiles = array();
        $dates = array();
        $scanDir = scandir($appRootDirectory);
        for ( $count=2 ; $count < sizeof($scanDir) ; $count++ ) {
            if ( is_dir($appRootDirectory."/".$scanDir[$count]) ) {
                array_push($dates,filemtime($appRootDirectory."/".$scanDir[$count] ));
            }
        }
        sort($dates);
        foreach ( $dates as $date ) {
            for ( $count=2 ; $count < sizeof($scanDir) ; $count++ ) {
                if ( is_dir($appRootDirectory."/".$scanDir[$count]) ) {
                    if ( filemtime($appRootDirectory."/".$scanDir[$count]) == $date ) {
                        array_push($sortedFiles,$scanDir[$count]);
                        break;
                    }
                }
            }
        }
        return $sortedFiles;
    }

    function getSortedPublicFilenames($appRootDirectory) {
        $sortedFiles = array();
        $dates = array();
        $scanDir = scandir($appRootDirectory);
        for ( $count=2 ; $count < sizeof($scanDir) ; $count++ ) {
            if ( !is_dir($appRootDirectory."/".$scanDir[$count]) && strpos($scanDir[$count],"-thumbnail") !== false ) {
                array_push($dates,filectime($appRootDirectory."/".$scanDir[$count] ));
            }
        }
        sort($dates);
        foreach ( $dates as $date ) {
            for ( $count=2 ; $count < sizeof($scanDir) ; $count++ ) {
                if ( !is_dir($appRootDirectory."/".$scanDir[$count]) && strpos($scanDir[$count],"-thumbnail") !== false ) {
                    if ( filectime($appRootDirectory."/".$scanDir[$count]) == $date ) {
                        array_push($sortedFiles,$scanDir[$count]);
                        break;
                    }
                }
            }
        }
        return $sortedFiles;
    }

    function getFileNameWithoutExt($filename) {
        $ext = substr(strrchr($filename, '.'), 1);
        $realname = trim($filename,".".$ext);
        return $realname;
    }

    function getExtWithoutFilename($filename) {
        return substr(strrchr($filename, '.'), 1);
    }

    function convertByteToMegabyte($byte) {
        $kb = $byte/1024;
        $mb = $kb/1024;
        return number_format((float)$mb, 2, '.', '');
    }

    function convertReadableDateFormat($dateTime) {
        $modifiedDateTemp =  $dateTime;
        $modifiedDateWihNumber = explode("T",$modifiedDateTemp);
        $modifiedDateMonthTemp = explode("-",$modifiedDateWihNumber[0]);
        $modifiedDateMonth = date("F", mktime(0, 0, 0, $modifiedDateMonthTemp[1], 10));
        $modifiedDate = $modifiedDateMonthTemp[0]."-".$modifiedDateMonth."-".$modifiedDateMonthTemp[2];
        return $modifiedDate;
    }

    function getPercentageOfFreeSpace() {
        return "34";
    }
    function getUsedSpaceOfPhpServer() {
        return "1.7";
    }
    function getTotalSpaceOfPhpServer() {
        return "5.0";
    }
?>