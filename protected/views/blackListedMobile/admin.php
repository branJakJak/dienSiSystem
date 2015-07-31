<?php
/* @var $this BlackListedMobileController */
/* @var $model BlackListedMobile */

$this->breadcrumbs=array(
	'Black Listed Mobiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BlackListedMobile', 'url'=>array('index')),
	array('label'=>'Create BlackListedMobile', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#black-listed-mobile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Black Listed Mobiles</h1>

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
	'id'=>'black-listed-mobile-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'value'=>'$data->rec_id',	
			'type'=>'raw',
			'header'=>'#'
		),
		// 'rec_id',
		// 'queue_id',
		'mobile_number',
		'origin',
		'ip_address',
		'date_created',
		// 'date_updated',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>