<?php
/* @var $this BlackListedMobileController */
/* @var $model BlackListedMobile */

$this->breadcrumbs=array(
	'Black Listed Mobiles'=>array('index'),
	'Manage',
);




$this->menu=array(
	array('label'=>'Back to DNC', 'url'=>array('/dnc')),
array('label'=>'List Blacklisted Mobilenumbers <span class="label label-info pull-right">'.number_format(BlackListedMobile::getTotalBlacklistedCount()).'</span>', 'url'=>array('/blacklist/list')),
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


$dataProvider = $model->search();
$dataProvider->sort->defaultOrder = "date_created DESC";
?>

<h1>Manage Black Listed Mobiles</h1>


<?php 
	$this->widget('zii.widgets.grid.CGridView', 
	array(
	'id'=>'black-listed-mobile-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'mobile_number',
	),
)); ?>
