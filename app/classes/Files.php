<?php

namespace app\classes;
class Files{
   
    public static $path;
    public static function issetDir(){
        return is_dir(self::$path);
    }

    
    public static function removeDir(){
        $path = self::$path;
        $path = escapeshellarg($path);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
            exec("rmdir /s /q $path");
        }else{
        
            exec("rm -rf $path"); 
        }
    }

    public static function makeDir(){
        mkdir(self::$path);
    }


    public static function createFile($filename,$body){

        file_put_contents(self::$path."/$filename", $body);

    }
     
   
    
}