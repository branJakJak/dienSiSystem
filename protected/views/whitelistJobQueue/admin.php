<?php
/* @var $this WhitelistJobQueueController */
/* @var $model WhitelistJobQueue */

$this->breadcrumbs=array(
	'Whitelist Job Queues'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WhitelistJobQueue', 'url'=>array('index')),
	array('label'=>'Create WhitelistJobQueue', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#whitelist-job-queue-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Whitelist Job Queues</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'whitelist-job-queue-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'queue_id',
		'queue_name',
		'status',
		'total_records',
		'processed_record',
		'filename',
		/*
		'date_done',
		'date_created',
		'date_updated',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
