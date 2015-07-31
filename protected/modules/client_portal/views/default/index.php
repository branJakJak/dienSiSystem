<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);

$criteria2 = new CDbCriteria;
$criteria2->compare("origin","client");
$counttot = BlackListedMobile::model()->count($criteria2);

$label = "<span class=\"badge badge-info pull-right\">$counttot</span>";

$this->menu=array(

	array('label'=>'Mobile Opted from Client '.$label, 'url'=>  Yii::app()->getBaseUrl(true)."/whitelist/default" ),
);



?>

<style type="text/css">
.list-view div.view {
	border: none;
	border-top: solid 1px #DDDDDD;
	border-bottom: solid 1px #DDDDDD;
}

</style>

<h1>
	Opt out mobile number <br>
	<small>List of mobile numbers who opted out coming from client source.</small>
</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'id'=>"listviewData",
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
