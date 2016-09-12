<?php
/* @var $this MessageBoardController */
/* @var $model MessageBoard */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-board-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'messageType'); ?>

		<?php echo $form->dropDownList($model,'messageType' , array("warning"=>"Website Under Maintenance","normal"=>"Online Mode")); ?>

		<?php echo $form->error($model,'messageType'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'messageStatus'); ?>
		<?php echo $form->textField($model,'messageStatus',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'messageStatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fullMessage'); ?>
		<?php echo $form->textArea($model,'fullMessage',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'fullMessage'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-lg btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
