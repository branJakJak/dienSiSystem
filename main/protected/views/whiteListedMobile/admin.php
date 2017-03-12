<?php
/* @var $this WhiteListedMobileController */
/* @var $model WhiteListedMobile */

$this->breadcrumbs=array(
	'White Listed Mobiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WhiteListedMobile', 'url'=>array('index')),
	array('label'=>'Create WhiteListedMobile', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#white-listed-mobile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage White Listed Mobiles</h1>

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
	'id'=>'white-listed-mobile-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rec_id',
		'queue_id',
		'mobile_number',
		'status',
		'date_created',
		'date_updated',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
