<?php

namespace Simpledom\Core\Classes;

class Config {

    public static function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * return the path we have to use for upload
     * @return string
     */
    public static function GetImagePath() {
        return "C:/xampp/htdocs/simpledom/public/userupload/image";
    }

    /**
     * return the maximum file size
     * @return type
     */
    public static function getMaxUserImageFileSizeUploadLimit() {
        return 1024 * 1024 * 8;
    }

}