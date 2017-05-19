<?php
namespace common;

use Yii;

class H5Utils
{
    //   以下是 为 h5 的龙套
    public function getViewPath()
    {
        return Yii::getAlias('@html5_dest');
    }

    public function getClosestVersion($file, $version)
    {
        // do not use getViewPath to get view path, there is a bug!!!!!!!!!
        $path = H5Utils::getViewPath() . '/' . $file;
        if (!file_exists($path)){
            return null;
        }
        $v = 0;
        foreach (scandir($path, SCANDIR_SORT_DESCENDING) as $f){
            $cv = intval(current(explode('.', $f)));
            if ($cv>0 && $cv<=$version && $cv>$v){
                $v = $cv;
            }
        }
        return $v;
    }

    public function getLastestVersion($file=null)
    {
        $file = $file?$file:Constants::H5_VERSION_MARKER;
        return H5Utils::getClosestVersion($file, 9999999999);
    }

    public function getLastestViewFileWithAbsolutePath($file)
    {
        return H5Utils::getViewPath() . '/'
            . H5Utils::getViewFile($file, H5Utils::getLastestVersion($file));
    }


    public function getViewFile($file, $v)
    {
        $tarr = explode('.', $file);
        $file = rtrim($file, '/');
        $file_suffix = count($tarr)>1?end($tarr):'html';
        if ($v>0){
            return $file . '/' . $v . '.' . $file_suffix;
        }
        return null;
    }


    public function getViewFileWithAbsolutePath($file, $v)
    {
        return H5Utils::getViewPath() . '/' . H5Utils::getViewFile($file, $v);
    }

    public function getVersionFile($version)
    {
        return H5Utils::getViewFileWithAbsolutePath(Constants::H5_VERSION_MARKER, $version);
    }

    public function generateUrl($version)
    {
        return Yii::$app->params['baseurl.h5_origin'] . '/' . 
            Constants::H5_VERSION_MARKER . '/' . $version .
                Constants::H5_VERSION_MARKER;
    }
}
