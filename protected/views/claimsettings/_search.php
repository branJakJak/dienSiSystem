<?php
/* @var $this ClaimsettingsController */
/* @var $model Claimsettings */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'settings_id'); ?>
		<?php echo $form->textField($model,'settings_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'settings_key'); ?>
		<?php echo $form->textField($model,'settings_key',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'settings_val'); ?>
		<?php echo $form->textField($model,'settings_val',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_updated'); ?>
		<?php echo $form->textField($model,'date_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'settings_owner'); ?>
		<?php echo $form->textField($model,'settings_owner'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->