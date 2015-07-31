<?php
/* @var $this MessageBoardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Message Boards',
);

$this->menu=array(
	array('label'=>'Create MessageBoard', 'url'=>array('create')),
	array('label'=>'Manage MessageBoard', 'url'=>array('admin')),
);
?>

<h1>Message Boards</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
