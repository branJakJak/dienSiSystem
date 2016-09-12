<?php
/* @var $this MessageBoardController */
/* @var $data MessageBoard */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rec_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rec_id), array('view', 'id'=>$data->rec_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('messageType')); ?>:</b>
	<?php echo CHtml::encode($data->messageType); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('messageStatus')); ?>:</b>
	<?php echo CHtml::encode($data->messageStatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullMessage')); ?>:</b>
	<?php echo CHtml::encode($data->fullMessage); ?>
	<br />


</div>