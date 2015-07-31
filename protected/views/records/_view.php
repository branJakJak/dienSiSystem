<?php
/* @var $this RecordsController */
/* @var $data Records */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->record_id), array('view', 'id'=>$data->record_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('claimData')); ?>:</b>
	<?php echo CHtml::encode($data->claimData); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->ip_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_information')); ?>:</b>
	<?php echo CHtml::encode($data->other_information); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />


</div>