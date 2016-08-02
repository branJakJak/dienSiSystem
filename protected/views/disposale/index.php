<?php
/* @var $this DisposaleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Disposales',
);

$this->menu=array(
	array('label'=>'Create Disposale', 'url'=>array('create')),
	array('label'=>'Manage Disposale', 'url'=>array('admin')),
);
?>

<h1>List of Disposales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
