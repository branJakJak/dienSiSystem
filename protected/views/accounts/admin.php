<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Accounts', 'url'=>array('index')),
	array('label'=>'Create Accounts', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$datasource = $model->search();
$datasource->pagination = false;

?>

<h1>Manage Accounts</h1>

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
	'id'=>'accounts-grid',
	'dataProvider'=>$datasource,
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CButtonColumn',
		),
		'claimAccountName',
		'claimAccountDescription',
		array(
				'header'=>'temp',
				'type'=>'raw',
				'value'=>'$data->account_id." ".$data->claimAccountName',
			),
		array(
				'header'=>'Application status',
				'type'=>'raw',
				'value'=>'$data->application_status',
			),
		array(
				'header'=>'Database Status',
				'type'=>'raw',
				'value'=>'$data->database_status',
			)
	),
)); ?>


