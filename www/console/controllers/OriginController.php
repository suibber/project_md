<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\base\ErrorException;
use common\H5Utils;
use common\models\User;
use m\controllers\OriginController as mOriginC;


class OriginController extends Controller
{

    public $defaultAction = 'current-version';

    private $_copied_files = [];

    public function actionCurrentVersion()
    {
        echo "Current html5 origin version is:  " . H5Utils::getLastestVersion();
        echo "\n";
    }

    function listFiles($basedir, $rdir=''){
        $current_dir = rtrim($basedir, '/') . '/' . $rdir;
        $ffs = scandir($current_dir);
        $arr = [];
        foreach($ffs as $ff) {
            if($ff != '.' && $ff != '..') {
                if(is_dir($current_dir . '/' . $ff)) {
                    $arr = array_merge($arr, $this->listFiles($basedir, $rdir . '/' .$ff));
                } else {
                    $arr[] = $rdir. '/' . $ff;
                }
            }
        }
        return $arr;
    }

    public function rollback()
    {
        echo "Rolling back...\n";
        foreach ($this->_copied_files as $f){
            echo "Delete file: " . $f . "\n";
            unlink($f);
            echo "->Done!\n";
        }
        echo "Rollback is done!!\n";
    }

    public function actionImportSource()
    {
        $path = Yii::getAlias('@html5_src');
        if (!is_dir($path)) {
            echo "Source need to be a path \n";
            exit(1);
        }
        $new_version = H5Utils::getLastestVersion() + 1;

        try {
            $file_count = 0;
            $all_files = $this->listFiles($path);
            foreach ($all_files as $file){
                $old_f = H5Utils::getLastestViewFileWithAbsolutePath($file);
                $new_f = rtrim($path, '/') . $file;
                $to_f = H5Utils::getViewFileWithAbsolutePath($file, $new_version);
                $file_count += 1;
                if ($this->isFileChanged($old_f, $new_f)) {
                    $this->copyFile($new_f, $to_f);
                } else {
                    echo "$file is not changed, no need to copy!\n";
                }
            }
            $c = count($this->_copied_files);
            echo $c . " files cloned \n";

            if ($c==0){
                echo "No file changed, No need to add new version! \n";
                exit(1);
            }
            echo "**************************************************\n";
            echo "Generate file maps...\n";
            $map = [];
            foreach($all_files as $file) {
                $tmpf = H5Utils::getViewFile($file, H5Utils::getLastestVersion($file));
                if ($tmpf){
                    $map[$file] = $tmpf;
                }
            }
            $vinfo = [];
            $vinfo['baseUrl'] = Yii::$app->params['baseurl.h5_origin'];
            $vinfo['fileMaps'] = $map;
            $vfile= H5Utils::getVersionFile($new_version);
            if (!file_exists(dirname($vfile))){
                mkdir(dirname($vfile), 0755, true);
            }
            $fp = fopen($vfile, 'w');
            fwrite($fp, json_encode($vinfo, JSON_UNESCAPED_SLASHES));
            fclose($fp);
            echo "Generation is done!\n\n";
            echo "**************************************************\n";
            echo "Current version is: " . $new_version . "\n";
        } catch (ErrorException $e){
            $this->rollback();
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            exit(1);
        }
    }

    public function copyFile($f, $to_file)
    {
        echo "File: " . $f . " is copying...\n";
        echo "\tCopy To: " . $to_file . "\n";
        $path = dirname($to_file);
        if (!file_exists($path)){
            if (!mkdir($path, 0755, true)){
                echo "Path: $path create failed!";
                exit(1);
            }
        }
        if (copy($f, $to_file)) {
            $this->_copied_files[] = $to_file;
            echo "->Done!\n";
        } else {
            throw new ErrorException('Failed to copy file from: '. $f . ' to file: ' . $to_file . "\n" . 'Please check permission!!!!!!!!!'."\n");
        }
    }

    public function isFileChanged($file1, $file2)
    {
        if (!file_exists($file1) || !file_exists($file2)){
            return true;
        }
        return sha1_file($file1)!=sha1_file($file2);
    }

    public function genereateMap($version, $files)
    {
        $file = $this->buildFilePath();
    }
}
