<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\District;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--?= Html::a('Create Data Daily', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <div id="w0" class="grid-view">
        <div>
            <?php $form = ActiveForm::begin([
                'method'    => 'get',
                'action'    => '/data-user',
            ]); 
                // 城市选项
                $model  = new District();
                $city   = $model->find()->where(['level'=>'city','is_alive'=>1])->addOrderBy(['id'=> SORT_ASC])->asArray()->all();
                $cityarr= array(0=>'全部城市');
                foreach( $city as $k => $v ){
                    $cityarr[$v['id']]    = $v['name'];
                }
            ?>
                
                <div class="form-group field-district-level required">
                    <select id="district-level" class="form-control" name="type_id">
                    <option value="1" <?php if( Yii::$app->request->get('type_id') ==1 ){echo 'selected';} ?>>用户端</option>
                    <option value="2" <?php if( Yii::$app->request->get('type_id') ==2 ){echo 'selected';} ?> >职位</option>
                    <option value="3" <?php if( Yii::$app->request->get('type_id') ==3 ){echo 'selected';} ?>>微信</option>
                    <option value="4" <?php if( Yii::$app->request->get('type_id') ==4 ){echo 'selected';} ?>>工资-流水</option>
                    <option value="5" <?php if( Yii::$app->request->get('type_id') ==5 ){echo 'selected';} ?>>工资-提现</option>
                    </select>
                    <div class="help-block"></div>
                </div> 

                <div class="form-group field-district-level required">
                    <select id="district-level" class="form-control" name="city_id">
                        <?php foreach($cityarr as $k => $v){ ?>
                            <option value="<?= $k ?>" <?php if( Yii::$app->request->get('city_id') == $k ){echo 'selected';} ?>><?= $v ?></option>
                        <?php } ?>
                    </select>
                    <div class="help-block"></div>
                </div> 

                起始日期：
                <?= DatePicker::widget([
                    'name' => 'dateStart',
                    'value' => $dateStart,
                    //'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
                结束日期：
                <?= DatePicker::widget([
                    'name' => 'dateEnd',
                    'value' => $dateEnd,
                    //'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
                &nbsp;
                <button class="btn btn-success" type="submit">搜索</button>
                &nbsp;&nbsp;快速查看：
                <a href="/data-user?type_id=<?= $data_type ?>&city_id=<?= $city_id ?><?= $ztUrl ?>">昨天</a> | 
                <a href="/data-user?type_id=<?= $data_type ?>&city_id=<?= $city_id ?><?= $qtUrl ?>">7天</a> | 
                <a href="/data-user?type_id=<?= $data_type ?>&city_id=<?= $city_id ?><?= $sstUrl ?>">30天</a>
                ------------
                <a class="btn btn-danger" onclick="if(confirm('如统计数据无误，请勿清空缓存，否则造成服务器压力，是否继续？')){window.location.href='/index.php/data-user/clearup'}" href="javascript:;">清空缓存</a>
            <?php ActiveForm::end(); ?>
        </div>
        <div style="font-weight:bold;color:blue;margin-top:10px;">
            点击表头可显示走势图
        </div>
        
        <?php if($data_type==3){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th class="show-highcharts" id="zgz">
                        剩余关注
                        <?php $zgz='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zgz .= isset($v['zgz']) ? $v['zgz']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zgz-data' value='".trim($zgz,',')."'>"; ?>
                        <input type='hidden' id='zgz-title' value='剩余关注'>
                    </th>
                    <th class="show-highcharts" id="jrgz">
                        当日关注
                        <?php $jrgz='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrgz .= isset($v['jrgz']) ? $v['jrgz']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrgz-data' value='".trim($jrgz,',')."'>"; ?>
                        <input type='hidden' id='jrgz-title' value='当日关注'>
                    </th>
                    <th class="show-highcharts" id="ztd">
                        总退订
                        <?php $ztd='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $ztd .= isset($v['ztd']) ? $v['ztd']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='ztd-data' value='".trim($ztd,',')."'>"; ?>
                        <input type='hidden' id='ztd-title' value='总退订'>
                    </th>
                    <th class="show-highcharts" id="jrtd">
                        当日退订
                        <?php $jrtd='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrtd .= isset($v['jrtd']) ? $v['jrtd']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrtd-data' value='".trim($jrtd,',')."'>"; ?>
                        <input type='hidden' id='jrtd-title' value='当日退订'>
                    </th>
                    <th class="show-highcharts" id="jrtsrs">
                        当日推送人数
                        <?php $jrtsrs='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrtsrs .= isset($v['jrtsrs']) ? $v['jrtsrs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrtsrs-data' value='".trim($jrtsrs,',')."'>"; ?>
                        <input type='hidden' id='jrtsrs-title' value='当日推送人数'>
                    </th>
                    <th class="show-highcharts" id="jrtszl">
                        当日推送总量
                        <?php $jrtszl='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrtszl .= isset($v['jrtszl']) ? $v['jrtszl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrtszl-data' value='".trim($jrtszl,',')."'>"; ?>
                        <input type='hidden' id='jrtszl-title' value='当日推送总量'>
                    </th>
                    <th class="show-highcharts" id="jrwxzc">
                        当日微信注册
                        <?php $jrwxzc='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrwxzc .= isset($v['jrwxzc']) ? $v['jrwxzc']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrwxzc-data' value='".trim($jrwxzc,',')."'>"; ?>
                        <input type='hidden' id='jrwxzc-title' value='当日微信注册'>
                    </th>
                    <th class="show-highcharts" id="jrwxtdrs">
                        当日微信投递人数
                        <?php $jrwxtdrs='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrwxtdrs .= isset($v['jrwxtdrs']) ? $v['jrwxtdrs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrwxtdrs-data' value='".trim($jrwxtdrs,',')."'>"; ?>
                        <input type='hidden' id='jrwxtdrs-title' value='当日微信投递人数'>
                    </th>
                    <th class="show-highcharts" id="jrwxtdzl">
                        当日微信投递总量
                        <?php $jrwxtdzl='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrwxtdzl .= isset($v['jrwxtdzl']) ? $v['jrwxtdzl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrwxtdzl-data' value='".trim($jrwxtdzl,',')."'>"; ?>
                        <input type='hidden' id='jrwxtdzl-title' value='当日微信投递总量'>
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['zgz']) ? $v['zgz'] : 0 ?></td>
                    <td><?= isset($v['jrgz']) ? $v['jrgz'] : 0 ?></td>
                    <td><?= isset($v['ztd']) ? $v['ztd'] : 0 ?></td>
                    <td><?= isset($v['jrtd']) ? $v['jrtd'] : 0 ?></td>
                    <td><?= isset($v['jrtsrs']) ? $v['jrtsrs'] : 0 ?></td>
                    <td><?= isset($v['jrtszl']) ? $v['jrtszl'] : 0 ?></td>
                    <td><?= isset($v['jrwxzc']) ? $v['jrwxzc'] : 0 ?></td>
                    <td><?= isset($v['jrwxtdrs']) ? $v['jrwxtdrs'] : 0 ?></td>
                    <td><?= isset($v['jrwxtdzl']) ? $v['jrwxtdzl'] : 0 ?></td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }elseif($data_type==2){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th class="show-highcharts" id="ztl">
                        总贴量
                        <?php $ztl='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $ztl .= isset($v['ztl']) ? $v['ztl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='ztl-data' value='".trim($ztl,',')."'>"; ?>
                        <input type='hidden' id='ztl-title' value='总贴量'>
                    </th>
                    <th class="show-highcharts" id="zzxtl">
                        总在线贴量
                        <?php $zzxtl='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zzxtl .= isset($v['zzxtl']) ? $v['zzxtl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zzxtl-data' value='".trim($zzxtl,',')."'>"; ?>
                        <input type='hidden' id='zzxtl-title' value='总在线贴量'>
                    </th>
                    <th class="show-highcharts" id="htxz">
                        后台新增
                        <?php $htxz='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $htxz .= isset($v['htxz']) ? $v['htxz']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='htxz-data' value='".trim($htxz,',')."'>"; ?>
                        <input type='hidden' id='htxz-title' value='后台新增'>
                    </th>
                    <th class="show-highcharts" id="zqxz">
                        抓取新增
                        <?php $zqxz='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zqxz .= isset($v['zqxz']) ? $v['zqxz']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zqxz-data' value='".trim($zqxz,',')."'>"; ?>
                        <input type='hidden' id='zqxz-title' value='抓取新增'>
                    </th>
                    <th class="show-highcharts" id="yhxz">
                        用户新增
                        <?php $yhxz='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $yhxz .= isset($v['yhxz']) ? $v['yhxz']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='yhxz-data' value='".trim($yhxz,',')."'>"; ?>
                        <input type='hidden' id='yhxz-title' value='用户新增'>
                    </th>
                    <th class="show-highcharts" id="zdsh">
                        总待审核
                        <?php $zdsh='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zdsh .= isset($v['zdsh']) ? $v['zdsh']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zdsh-data' value='".trim($zdsh,',')."'>"; ?>
                        <input type='hidden' id='zdsh-title' value='总待审核'>
                    </th>
                    <th class="show-highcharts" id="zgq">
                        总过期
                        <?php $zgq='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zgq .= isset($v['zgq']) ? $v['zgq']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zgq-data' value='".trim($zgq,',')."'>"; ?>
                        <input type='hidden' id='zgq-title' value='总过期'>
                    </th>
                    <th class="show-highcharts" id="jrgq">
                        当日过期
                        <?php $jrgq='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrgq .= isset($v['jrgq']) ? $v['jrgq']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrgq-data' value='".trim($jrgq,',')."'>"; ?>
                        <input type='hidden' id='jrgq-title' value='当日过期'>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['ztl']) ? $v['ztl'] : 0 ?></td>
                    <td><?= isset($v['zzxtl']) ? $v['zzxtl'] : 0 ?></td>
                    <td><?= isset($v['htxz']) ? $v['htxz'] : 0 ?></td>
                    <td><?= isset($v['zqxz']) ? $v['zqxz'] : 0 ?></td>
                    <td><?= isset($v['yhxz']) ? $v['yhxz'] : 0 ?></td>
                    <td><?= isset($v['zdsh']) ? $v['zdsh'] : 0 ?></td>
                    <td><?= isset($v['zgq']) ? $v['zgq'] : 0 ?></td>
                    <td><?= isset($v['jrgq']) ? $v['jrgq'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }elseif($data_type==1){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th class="show-highcharts" id="zczl">
                        注册总量
                        <?php $zczl='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zczl .= isset($v['zczl']) ? $v['zczl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zczl-data' value='".trim($zczl,',')."'>"; ?>
                        <input type='hidden' id='zczl-title' value='注册总量'>
                    </th>
                    <th class="show-highcharts" id="jlzl">
                        简历总量
                        <?php $jlzl='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jlzl .= isset($v['jlzl']) ? $v['jlzl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jlzl-data' value='".trim($jlzl,',')."'>"; ?>
                        <input type='hidden' id='jlzl-title' value='简历总量'>
                    </th>
                    <th class="show-highcharts" id="tdzl">
                        投递总量
                        <?php $tdzl='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $tdzl .= isset($v['tdzl']) ? $v['tdzl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='tdzl-data' value='".trim($tdzl,',')."'>"; ?>
                        <input type='hidden' id='tdzl-title' value='投递总量'>
                    </th>
                    <th class="show-highcharts" id="tdrs">
                        投递人数
                        <?php $tdrs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $tdrs .= isset($v['tdrs']) ? $v['tdrs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='tdrs-data' value='".trim($tdrs,',')."'>"; ?>
                        <input type='hidden' id='tdrs-title' value='投递人数'>
                    </th>
                    <th class="show-highcharts" id="jrzczl">
                        当日注册总量
                        <?php $jrzczl='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrzczl .= isset($v['jrzczl']) ? $v['jrzczl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrzczl-data' value='".trim($jrzczl,',')."'>"; ?>
                        <input type='hidden' id='jrzczl-title' value='当日注册总量'>
                    </th>
                    <th class="show-highcharts" id="jrjlzl">
                        当日简历总量
                        <?php $jrjlzl='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrjlzl .= isset($v['jrjlzl']) ? $v['jrjlzl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrjlzl-data' value='".trim($jrjlzl,',')."'>"; ?>
                        <input type='hidden' id='jrjlzl-title' value='当日简历总量'>
                    </th>
                    <th class="show-highcharts" id="jrtdzl">
                        当日投递总量
                        <?php $jrtdzl='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrtdzl .= isset($v['jrtdzl']) ? $v['jrtdzl']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrtdzl-data' value='".trim($jrtdzl,',')."'>"; ?>
                        <input type='hidden' id='jrtdzl-title' value='当日投递总量'>
                    </th>
                    <th class="show-highcharts" id="jrtdrs">
                        当日投递人数
                        <?php $jrtdrs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrtdrs .= isset($v['jrtdrs']) ? $v['jrtdrs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrtdrs-data' value='".trim($jrtdrs,',')."'>"; ?>
                        <input type='hidden' id='jrtdrs-title' value='当日投递人数'>
                    </th>
                    <th class="show-highcharts" id="jrxyhtd">
                        当日新投递用户
                        <?php $jrxyhtd='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrxyhtd .= isset($v['jrxyhtd']) ? $v['jrxyhtd']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrxyhtd-data' value='".trim($jrxyhtd,',')."'>"; ?>
                        <input type='hidden' id='jrxyhtd-title' value='当日新用户投递'>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['zczl']) ? $v['zczl'] : 0 ?></td>
                    <td><?= isset($v['jlzl']) ? $v['jlzl'] : 0 ?></td>
                    <td><?= isset($v['tdzl']) ? $v['tdzl'] : 0 ?></td>
                    <td><?= isset($v['tdrs']) ? $v['tdrs'] : 0 ?></td>
                    <td><?= isset($v['jrzczl']) ? $v['jrzczl'] : 0 ?></td>
                    <td><?= isset($v['jrjlzl']) ? $v['jrjlzl'] : 0 ?></td>
                    <td><?= isset($v['jrtdzl']) ? $v['jrtdzl'] : 0 ?></td>
                    <td><?= isset($v['jrtdrs']) ? $v['jrtdrs'] : 0 ?></td>
                    <td><?= isset($v['jrxyhtd']) ? $v['jrxyhtd'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }elseif($data_type==4){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th class="show-highcharts" id="bs">
                        交易笔数
                        <?php $bs='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $bs .= isset($v['bs']) ? $v['bs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='bs-data' value='".trim($bs,',')."'>"; ?>
                        <input type='hidden' id='bs-title' value='交易笔数'>
                    </th>
                    <th class="show-highcharts" id="rs">
                        交易人数
                        <?php $rs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $rs .= isset($v['rs']) ? $v['rs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='rs-data' value='".trim($rs,',')."'>"; ?>
                        <input type='hidden' id='rs-title' value='交易人数'>
                    </th>
                    <th class="show-highcharts" id="dds">
                        订单数
                        <?php $dds='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $dds .= isset($v['dds']) ? $v['dds']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='dds-data' value='".trim($dds,',')."'>"; ?>
                        <input type='hidden' id='dds-title' value='投递总量'>
                    </th>
                    <th class="show-highcharts" id="jrqs">
                        当日金额
                        <?php $jrqs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrqs .= isset($v['jrqs']) ? intval($v['jrqs'])."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrqs-data' value='".trim($jrqs,',')."'>"; ?>
                        <input type='hidden' id='jrqs-title' value='当日金额'>
                    </th>
                    <th class="show-highcharts" id="zqs">
                        总金额
                        <?php $zqs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zqs .= isset($v['zqs']) ? intval($v['zqs'])."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zqs-data' value='".trim($zqs,',')."'>"; ?>
                        <input type='hidden' id='zqs-title' value='总金额'>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['bs']) ? $v['bs'] : 0 ?></td>
                    <td><?= isset($v['rs']) ? $v['rs'] : 0 ?></td>
                    <td><?= isset($v['dds']) ? $v['dds'] : 0 ?></td>
                    <td><?= isset($v['jrqs']) ? $v['jrqs'] : 0 ?></td>
                    <td><?= isset($v['zqs']) ? $v['zqs'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }elseif($data_type==5){ ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>日期</th>
                    <th class="show-highcharts" id="bs">
                        成功提现笔数
                        <?php $bs='';$dataRowsH=array_reverse($dataRows);foreach($dataRowsH as $k => $v){ ?>    
                            <?php $bs .= isset($v['bs']) ? $v['bs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='bs-data' value='".trim($bs,',')."'>"; ?>
                        <input type='hidden' id='bs-title' value='交易笔数'>
                    </th>
                    <th class="show-highcharts" id="rs">
                        成功提现人数
                        <?php $rs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $rs .= isset($v['rs']) ? $v['rs']."," : 0 ?>
                        <?php } echo "<input type='hidden' id='rs-data' value='".trim($rs,',')."'>"; ?>
                        <input type='hidden' id='rs-title' value='交易人数'>
                    </th>
                    <th class="show-highcharts" id="jrqs">
                        成功提现当日金额
                        <?php $jrqs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $jrqs .= isset($v['jrqs']) ? intval($v['jrqs'])."," : 0 ?>
                        <?php } echo "<input type='hidden' id='jrqs-data' value='".trim($jrqs,',')."'>"; ?>
                        <input type='hidden' id='jrqs-title' value='当日金额'>
                    </th>
                    <th class="show-highcharts" id="zqs">
                        成功提现总金额
                        <?php $zqs='';foreach($dataRowsH as $k => $v){ ?>    
                            <?php $zqs .= isset($v['zqs']) ? intval($v['zqs'])."," : 0 ?>
                        <?php } echo "<input type='hidden' id='zqs-data' value='".trim($zqs,',')."'>"; ?>
                        <input type='hidden' id='zqs-title' value='总金额'>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataRows as $k => $v){ ?>
                <tr data-key="2">
                    <td><?= isset($v['date']) ? $v['date'] : 0 ?></td>
                    <td><?= isset($v['bs']) ? $v['bs'] : 0 ?></td>
                    <td><?= isset($v['rs']) ? $v['rs'] : 0 ?></td>
                    <td><?= isset($v['jrqs']) ? $v['jrqs'] : 0 ?></td>
                    <td><?= isset($v['zqs']) ? $v['zqs'] : 0 ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
    <div id="container" style="height:400px;border:1px solid #ccc;padding-top:10px;"></div>
</div>

<?php $this->beginBlock('css') ?>
    <link href="/css/jquery.timepicker.css" media="all" rel="stylesheet" />
    <style>
        .show-highcharts{
            cursor:pointer;
        }
    </style>
<?php $this->endBlock('css') ?>
<?php $this->beginBlock('js') ?>
    <script>
        $(function () {
            $(".show-highcharts").click(function(){
                var dataid      = $(this).attr('id');
                var datavalue   = eval('['+$("#"+dataid+"-data").val()+']');
                var datatitle   = $("#"+dataid+"-title").val();
                makeHighcharts(datavalue,datatitle);
                $('html, body, .content').animate({scrollTop: $(document).height()},500); 
            });
            function makeHighcharts(datavalue,datatitle){
                $('#container').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: datatitle+'-走势图'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: [
                            <?php $dataRows=array_reverse($dataRows);foreach($dataRows as $k => $v){ ?>    
                                <?= isset($v['date']) ? "'".$v['date']."'," : 0 ?>
                            <?php } ?>
                        ]
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        enabled: false,
                        formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: [{
                        name: datatitle,
                        data: datavalue
                    }]
                });
            }
        });
    </script>
    
<?php $this->endBlock() ?>

