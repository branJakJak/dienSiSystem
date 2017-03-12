<?php
/* @var $this MessageBoardController */
/* @var $model MessageBoard */

$this->breadcrumbs=array(
	'Message Boards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MessageBoard', 'url'=>array('index')),
	array('label'=>'Manage MessageBoard', 'url'=>array('admin')),
);
?>

<h1>Create MessageBoard</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>