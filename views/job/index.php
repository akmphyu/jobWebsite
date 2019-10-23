<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1 class="page-header">Category<a class="btn btn-primary pull-right" href="/web/index.php?r=job/create">Create</a></h1>
<?php 
    $msg = yii::$app->getSession()->getFlash('success');
    if(null !== $msg) : ?>
    <div class="alert alert-success"><?= $msg; ?></div>
<?php
    endif;
?>
<?php if(!empty($jobs)) : ?>
<div class="row">
<?php foreach($jobs as $job) :?>
    <div class="col-sm-6 col-md-3 myjob">
        <h3><?= $job->title; ?></h3>
        <?php
            $description = strip_tags($job->description);
            if(strlen($description) > 100){
                $formated_des = substr($description, 0, 100);
                $description = substr($formated_des,0, strrpos($formated_des, ' '));
            }
        ?>
        <p><strong>Description: </strong><?= $description ?></p>
        <p><strong>City: </strong><?= $job->city; ?></p>
        <p><strong>Address: </strong><?= $job->address; ?></p>
        <?php
            $mydate = strtotime($job->create_date);
            $dtformat = date("F j,Y",$mydate);
        ?>
        <p><strong>Listed On: </strong><?= $dtformat ?></p>
        <a class="btn btn-primary pull-right" href="/web/index.php?r=job/details&id=<?= $job->id; ?>">Read More..</a>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <p class="lead">No job to list</p>
<?php endif; ?>
<?= LinkPager::widget(['pagination' => $pagination]); ?>
