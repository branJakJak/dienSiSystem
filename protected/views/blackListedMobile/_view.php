<?php
/* @var $this BlackListedMobileController */
/* @var $data BlackListedMobile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rec_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rec_id), array('view', 'id'=>$data->rec_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_id')); ?>:</b>
	<?php echo CHtml::encode($data->queue_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_number')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />


</div>