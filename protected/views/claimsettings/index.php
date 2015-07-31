<?php
/* @var $this ClaimsettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Claimsettings',
);

$this->menu=array(
	array('label'=>'Create Claimsettings', 'url'=>array('create')),
	array('label'=>'Manage Claimsettings', 'url'=>array('admin')),
);
?>

<h1>Claimsettings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
