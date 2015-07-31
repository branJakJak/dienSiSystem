<?php 

	$criteria = new CDbCriteria();
	$criteria->group = "queue_id";
	$criteria->select  = "queue_id , date_created";
	$criteria->addCondition("queue_id <> null or queue_id <> '' ");
	$dataprovider = new CActiveDataProvider('BlackListedMobile',array('criteria'=>$criteria));
	$dataprovider->pagination = false;
	$dataprovider->sort->defaultOrder = "date_created DESC";

?>

<style type="text/css">
.items {
	margin: 0 13px;
}

</style>
<div class="">
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataprovider,
        'template'=>'<h4>{summary}</h4>{sorter}{pager}{items}{pager}',
        'itemView'=>'application.modules.blacklist.views.default._list_view',
		'htmlOptions'=>array(
			"style"=>" height: 691px;    overflow-y: scroll;    -webkit-box-shadow: -1px 0px 10px 0px rgba(0,0,0,0.65); -moz-box-shadow: -1px 0px 10px 0px rgba(0,0,0,0.65); box-shadow: -1px 0px 10px 0px rgba(0,0,0,0.65);",
			)
    )); ?>
</div>