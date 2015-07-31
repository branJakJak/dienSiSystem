<?php
/* @var $this ClaimsettingsController */
/* @var $model Claimsettings */


$this->layout = "column1";
$this->breadcrumbs=array(
	'Claimsettings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Claimsettings', 'url'=>array('index')),
	array('label'=>'Create Claimsettings', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#claimsettings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Claimsettings</h1>

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
	'id'=>'claimsettings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'settings_id',
		'settings_key',
		// 'settings_val',
		array(
			"header"=>"Setting Val",
			"name"=>'settings_val',
			"value"=>'substr($data->settings_val, 0,200)."...."',

		),
		'date_created',
		'date_updated',
		array(
			'header'=>'Owner',
			'name'=>'settings_owner',
			'filter'=>CHtml::listData(Accounts::model()->findAll(array('order'=>'claimAccountName')),'account_id','claimAccountName'),
			'value'=>'Accounts::getAccountName($data->settings_owner)'
			
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
