<?php
/**
 * Created by JetBrains PhpStorm.
 * User: EMAXX-A55-FM2
 * Date: 2/16/15
 * Time: 10:45 PM
 * To change this template use File | Settings | File Templates.
 */
$criteria = new CDbCriteria();
$criteria->group = "queue_id";

$criteria->select  = "queue_id , queue_name, date_created";
$criteria->limit = 100;
$dataprovider = new CActiveDataProvider('WhitelistJobQueue',array('criteria'=>$criteria));
$dataprovider->pagination = false;
$dataprovider->sort->defaultOrder = "date_created DESC";


$this->menu=array(
	array('label'=>'List Blacklisted Mobile Numbers', 'url'=>array('/blacklist/list')),
);


?>


<style type="text/css">
.list-view div.view {
	border: none;
	border-bottom: solid 1px #DDDDDD !important;
}
#yw1 > div.items {
	border-top: solid 1px #DDDDDD !important;
}
</style>

<div class='span10'>
<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, 
    'closeText'=>'×', 
    'alerts'=>array( 
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
	    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
    ),
)); 
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataprovider,
	'template'=>'<div class="pull-left"><h4>{sorter}</h4></div>  <div class="pull-right"><h4>{summary}</h4></div> <div class="clearfix"></div>{pager}{items}{pager}',
	'itemView'=>'_view',
	'sortableAttributes'=>array(
       'date_created' => 'Date Uploaded',
    ),
    'summaryText'=>'Viewing all {count}'
)); ?>

</div>
