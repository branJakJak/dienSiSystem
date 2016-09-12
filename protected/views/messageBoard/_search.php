<?php
/* @var $this MessageBoardController */
/* @var $model MessageBoard */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'rec_id'); ?>
		<?php echo $form->textField($model,'rec_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'messageType'); ?>
		<?php echo $form->textField($model,'messageType',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'messageStatus'); ?>
		<?php echo $form->textField($model,'messageStatus',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fullMessage'); ?>
		<?php echo $form->textArea($model,'fullMessage',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->