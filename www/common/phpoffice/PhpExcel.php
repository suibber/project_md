<?php
namespace common\phpoffice;

use Yii;
use yii\base\Component;
use yii\base\ViewContextInterface;

class PhpExcel extends Component
{
    public function excelToArray($path){
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        foreach( $sheetData as $k => $v ){
            foreach( $v as $k2 => $v2 ){
                $v[$k2] = trim($v2,"'");
            }
            $sheetData[$k]  = $v;
        }
        return $sheetData;
    }
    
    public function dateExceltoPHP($date){
        if( strlen($date) < 10 ){
			$explode		= explode('-',$date);
			if(count($explode) == 3){
				list($m,$d,$y)  = $explode;
				$return         = '20'.$y.'-'.$m.'-'.$d;
			}else{
				$return         = $date;
			}
        }else{
            $return         = $date;
        }
        return $return;
    }

    public function arrayToExcel($array='',$name='miduoduo'){
        $objPHPExcel = new \PHPExcel();
        foreach( $array as $k => $v ){
            $objPHPExcel->getActiveSheet()->setCellValue($k, $v);
        }
        
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$name.'.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    public function convertUTF8($str){
       if(empty($str)) return '';
       return  iconv('gb2312', 'utf-8', $str);
    }
}
