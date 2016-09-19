<?php
/* @var $this WhitelistJobQueueController */
/* @var $model WhitelistJobQueue */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'queue_id'); ?>
		<?php echo $form->textField($model,'queue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'queue_name'); ?>
		<?php echo $form->textField($model,'queue_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_records'); ?>
		<?php echo $form->textField($model,'total_records'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'processed_record'); ?>
		<?php echo $form->textField($model,'processed_record'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_done'); ?>
		<?php echo $form->textField($model,'date_done'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_updated'); ?>
		<?php echo $form->textField($model,'date_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->