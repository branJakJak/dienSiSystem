<?php 
/* @var $this ImportController */

?>



    <?php if (Yii::app()->user->hasFlash("error")): ?>
    	<?php echo Yii::app()->user->getFlash('error'); ?>
    <?php endif ?>
    <?php if (Yii::app()->user->hasFlash("success")): ?>
    	<?php echo Yii::app()->user->getFlash('success'); ?>
    <?php endif ?>
<br>
<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
<?php echo CHtml::fileField('import_file'); ?>
<?php echo CHtml::submitButton('Submit'); ?>
<?php echo CHtml::endForm(); ?>
