<?php
/* @var $this WhitelistJobQueueController */
/* @var $data WhitelistJobQueue */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->queue_id), array('view', 'id'=>$data->queue_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_name')); ?>:</b>
	<?php echo CHtml::encode($data->queue_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_records')); ?>:</b>
	<?php echo CHtml::encode($data->total_records); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('processed_record')); ?>:</b>
	<?php echo CHtml::encode($data->processed_record); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_done')); ?>:</b>
	<?php echo CHtml::encode($data->date_done); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	*/ ?>

</div>