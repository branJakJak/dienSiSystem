<?php
/* @var $this ClaimsettingsController */
/* @var $data Claimsettings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('settings_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->settings_id), array('view', 'id'=>$data->settings_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('settings_key')); ?>:</b>
	<?php echo CHtml::encode($data->settings_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('settings_val')); ?>:</b>
	<?php echo CHtml::encode($data->settings_val); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('settings_owner')); ?>:</b>
	<?php echo CHtml::encode($data->settings_owner); ?>
	<br />


</div>