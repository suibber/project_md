<?php $this->beginContent('@m/views/layouts/main.php'); ?>
<?php

$this->title = "操作成功";
?>
<div class="xiugaichenggong">
     <div class="xiugai-cg">
        <?=$message?>
    </div>
</div>

<a href="<?=$next?>" >
 <button type="button" class="btn-anniu"> 确定 </button>
</a>
</div>
<?php $this->endContent(); ?>
