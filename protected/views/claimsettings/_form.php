<?php
/* @var $this ClaimsettingsController */
/* @var $model Claimsettings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claimsettings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'settings_key'); ?>
		<?php echo $form->textField($model,'settings_key',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'settings_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'settings_val'); ?>
		<?php echo $form->textArea($model,'settings_val') ?>
		<?php echo $form->error($model,'settings_val'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'settings_owner'); ?>
		<?php //echo $form->textField($model,'settings_owner'); ?>
		<?php //echo CHtml::listData(Accounts::model()->findAll(array('order'=>'claimAccountName')),'account_id','claimAccountName') ?>
		<?php echo $form->dropDownList( $model,'settings_owner' ,CHtml::listData(Accounts::model()->findAll(array('order'=>'claimAccountName')),'account_id','claimAccountName') )   ?>
		<?php echo $form->error($model,'settings_owner'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->