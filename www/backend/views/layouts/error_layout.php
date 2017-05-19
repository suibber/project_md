<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
    <?php $this->beginBody() ?>
<div class="container-fluid">
<?= $content ?>
</div>
    <?php $this->endBody() ?>
    <script>
        GB={};
        GB.is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
        GB.click_event = GB.is_mobile?'touchstart':'click';
    </script>
    <?php echo isset($this->blocks['js'])?$this->blocks['js']:''; ?>
    <script>
        $(function(){
            var uri=location.pathname;
            console.info(uri);
            $.each($('#sidebar a'), function(i, v){
                var a =$(v);
                var muri = a.attr('href');
                if (uri==muri){
                    a.closest('li').addClass('active');
                }
            });
        });

    </script>
        <script>
    $("#sidebar-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>
<?php $this->endPage() ?>
