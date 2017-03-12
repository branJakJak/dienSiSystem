<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'claimAccountName'); ?>
		<?php echo $form->textField($model,'claimAccountName',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'claimAccountName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'claimAccountDescription'); ?>
		<?php echo $form->textArea($model,'claimAccountDescription',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'claimAccountDescription'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'websiteURL'); ?>
		<?php echo $form->textField($model,'websiteURL',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'websiteURL'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_status'); ?>
		<?php echo $form->textField($model,'application_status',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'application_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'database_status'); ?>
		<?php echo $form->textField($model,'database_status',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'database_status'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->