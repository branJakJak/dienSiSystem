<?php
/* @var $this RecordsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Records',
);

$this->menu=array(
	array('label'=>'Create Records', 'url'=>array('create')),
	array('label'=>'Manage Records', 'url'=>array('admin')),
);
?>

<h1>Records</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
