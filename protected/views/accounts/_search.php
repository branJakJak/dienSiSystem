<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'claimAccountName'); ?>
		<?php echo $form->textField($model,'claimAccountName',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'claimAccountDescription'); ?>
		<?php echo $form->textArea($model,'claimAccountDescription',array('rows'=>6, 'cols'=>50)); ?>
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