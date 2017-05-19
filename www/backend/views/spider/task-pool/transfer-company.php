<?php

?>
<h2>
公司: <?=$company->name?>
</h2>

<p>
共导入: <?=$count?> 条数据
</p>

<?php
foreach($all_tasks as $task){
    echo $this->render('_view_task', [
        'model'=>$task
    ]);
}
?>
