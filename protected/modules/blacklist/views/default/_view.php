<?php
/* @var $this JobQueueController */
/* @var $data JobQueue */
?>
<div class="view span3"  style='height : 200px'>
    <h3>
        <?php echo CHtml::encode($data->queue_name); ?>
    </h3>
    <hr>
    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->status); ?>
    <br />
    <?php if($data->status == JobQueue::$JOBQUEUE_STATUS_ON_GOING || JobQueue::$JOBQUEUE_STATUS_PRELOADED): ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('total_records')); ?>:</b>
        <?php echo CHtml::encode($data->total_records); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('processed_record')); ?>:</b>
        <?php echo CHtml::encode($data->processed_record); ?>
        <br />
    <?php endif;?>
    <?php if($data->status == JobQueue::$JOBQUEUE_STATUS_DONE): ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('date_done')); ?>:</b>
        <?php echo CHtml::encode($data->date_done); ?>
        <br />
    <?php endif?>

    <?php /*
  *
    <b><?php echo CHtml::encode($data->getAttributeLabel('queue_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->queue_id), array('view', 'id'=>$data->queue_id)); ?>
    <br />


    <b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
    <?php echo CHtml::encode($data->filename); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	*/ ?>
</div>