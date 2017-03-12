<?php
/* @var $this RecordsController */
/* @var $model Records */

$this->breadcrumbs=array(
	'Records'=>array('index'),
	'Manage',
);
$this->layout = "column1";

$this->menu=array(
	array('label'=>'List Records', 'url'=>array('index')),
	array('label'=>'Create Records', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#records-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Records</h1>

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
	'id'=>'records-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'record_id',
		'account_id',
		'claimData',
		'ip_address',
		'date_created',
		// 'other_information',
		/*
		'date_updated',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
