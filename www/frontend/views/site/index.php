<?php
use common\Seo;
use common\Utils;

/********* seo start ***********/
$seocity    = isset($city->name)?$city->name:'';
$block      = '';
$type       = '';
$clearance_type = '';
$conpany    = '';
$task_title = '';
$page_type  = 'index';

$seo_code   = Seo::makeSeoCode($seocity,$block,$type,$clearance_type,$conpany,$task_title,$page_type);

$this->page_title = $seo_code['title'];
$this->page_keywords = $seo_code['keywords'];
$this->page_description = $seo_code['description'];
/********* seo end ***********/
?>
<div class="qiuzhi-banner">
  <div class="cent">
      <div class="pic-top"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/jianzhi-pic.png" width="805" height="170"></div>
    <div class="erwei-box" style="width:1020px;">
      <div class="erweibox" style="width: 255px;"> <img src="http://static.miduoduo.cn/www/static/img/ban-erwei.jpg" width="140" height="140">
        <p>关注微信号</p>
      </div>
      <div class="erweibox" style="width: 255px;"> <img src="http://static.miduoduo.cn/www/static/img/ios-app.jpg" width="140" height="140">
        <p>下载苹果App</p>
      </div>
      
    <div class="erweibox" style="width: 255px;"> <img src="http://static.miduoduo.cn/www/static/img/android-app.jpg" width="140" height="140">
        <p>下载安卓App</p>
      </div><div class="erweibox" style="width: 255px;"> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/qiye.jpg" width="140" height="140">
        <p>企业微信号</p>
      </div>
    </div>
  </div>
</div>
<div class="miduoduo-one">
  <div class="miduoduo-ms">
    <div id="zan-mi">
      <div class="zan-box">
          <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/quanmianfei.jpg" width="535" height="285">
        <div class="zan">
          <ul>
            <li><span class="touxiang1"></span><span class="qipao1"><span class="jt1"></span>你们收押金什么的不？</span></li>
            <li><span class="miduoudo-tx"></span><span class="qipao2"><span class="jt2"></span>我们承诺不收取任何费用，没有押金，没有中介费~</span></li>
            <li><span class="touxiang1"></span><span class="qipao1"><span class="jt1"></span>讲真？</span></li>
            <li><span class="miduoudo-tx"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/miduoduo-tx.jpg" width="40" height="40"></span><span class="qipao2"><span class="jt2"></span>亲，这点可以狠狠的放心！</span></li>
          </ul>
        </div>
      </div>
      <div class="zan-box">
          <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/ganpeifu.jpg" width="535" height="285">
        <div class="zan">
          <ul>
          <li><span class="touxiang2"></span><span class="qipao1"><span class="jt1"></span>今天兼职没到时间就让我们走了，钱只给结了一半...</span></li>
          <li><span class="miduoudo-tx"></span><span class="qipao2"><span class="jt2"></span>非常抱歉，企业临时做了调整，我们把剩下一半工资赔付给你，今天辛苦了~</span></li>
        </ul>
        </div>
      </div>
       <div class="zan-box">
           <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/zhenfuze.jpg" width="535" height="285">
        <div class="zan">
          <ul>
          <li><span class="touxiang3"></span><span class="qipao1"><span class="jt1"></span>这个兼职是假的！白跑一趟！还让我交钱！</span></li>
          <li><span class="miduoudo-tx"></span><span class="qipao2"><span class="jt2"></span>真是抱歉，非常感谢你的及时反馈，我们会将这份兼职下架，今天你往返的路费我们会补贴给你，再次抱歉并且表示感谢。</span></li>
        </ul>
        </div>
      </div>
      <div class="zan-box">
          <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/haokoubei.jpg" width="535" height="285">
        <div class="zan">
          <ul>
          <li><span class="touxiang4"></span><span class="qipao1"><span class="jt1"></span>米多多真心靠谱！以后就跟着米多多混了！</span></li>
          <li><span class="touxiang5"></span><span class="qipao1"><span class="jt1"></span>米多多好负责，以后找兼职就来米多多了。</span></li>
          <li><span class="touxiang6"></span><span class="qipao1"><span class="jt1"></span>坚决拥护米多多，找工作真快！够给力。</span></li>
          <li><span class="miduoudo-tx"></span><span class="qipao2"><span class="jt2"></span>谢谢各位米亲，米多多一定会好好努力，争取给大家提供更多更好更靠谱的兼职。</span></li>
        </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="position-type-box">
  <ul>
    <li class="orange">派单员</li>
    <li class="blue">会展</li>
    <li class="light-green"><a href="<?=Yii::$app->params['baseurl.model']?>">模特</a></li>
    <li class="dark-red">舞蹈教练</li>
    <li class="orange">翻译</li>
    <li class="blue">视频</li>
    <li class="light-green">产品</li>
    <li class="dark-red">运营</li>
    <li class="orange">SEO</li>
    <li class="blue">家教</li>
    <li class="light-green">CAD</li>
    <li class="light-blue">平面</li>
    <li class="blue">程序</li>
    <li class="light-blue">运维</li>
    <li class="blue">促销</li>
    <li class="light-green">美工</li>
    <li class="dark-red">法律</li>
    <li class="blue">高薪服务员</li>
  </ul>
</div>
<div class="service"> <span>米多多</span>
  <p>我们能为您做到那些？</p>
</div>
<div class="function-display" >
  <ul id="suc1">
      <li> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/function-pic.jpg" width="330" height="330">
      <div class="text"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/free-icon.png" width="71" height="32">
        <p>完全免费</p>
      </div>
    </li>
    <li> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/function-pic1.jpg" width="330" height="330">
    <div class="text"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/xing.png" width="96" height="29">
        <p>一流合作企业</p>
      </div>
    </li>
    <li> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/function-pic2.jpg" width="330" height="330">
    <div class="text"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/gaoxin.png" width="39" height="42">
        <p>众多高薪职位</p>
      </div>
    </li>
    <li> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/function-pic3.jpg" width="330" height="330">
    <div class="text"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/anquan.png" width="41" height="46">
        <p>安全担保</p>
      </div>
    </li>
    <li> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/function-pic4.jpg" width="330" height="330">
    <div class="text"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/lignhuo.png" width="38" height="38">
        <p>时间灵活</p>
      </div>
    </li>
    <li> <img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/function-pic5.jpg" width="330" height="330">
    <div class="text"><img src="<?=Yii::$app->params["baseurl.static.www"]?>/static/img/jiujin.png" width="43" height="41">
        <p>就近择业</p>
      </div>
    </li>
  </ul>
</div>
<div class="bottom-bsnner">
  <div class="toumin-box"></div>
  <div class="text-mi">米多多，不仅仅是兼职！</div>
</div> 
<?php $this->beginBlock('js') ?>
    <script>
        $(function(){
          $(function(){
          $('#suc1 li').hover(function(){
            $('.text',this).stop().animate({
              height:'0'
            });
          },function(){
            $('.text',this).stop().animate({
              height:'330px'
            });
          });
        });
        })

        $(function(){
          $(function(){
          $('#zan-mi .zan-box').hover(function(){
            $('.zan',this).stop().animate({
              height:'258px'
            });
          },function(){
            $('.zan',this).stop().animate({
              height:'0'
            });
          });
        });
        })
    </script>
<?php $this->endBlock('js') ?>