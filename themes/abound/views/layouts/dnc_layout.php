<?php /* @var $this Controller */ ?>
<?php 
    $criteria = new CDbCriteria();
    $criteria->group = "queue_id";
    $criteria->select  = "queue_id , queue_name, date_created";
    $dataprovider = new CActiveDataProvider('WhitelistJobQueue',array('criteria'=>$criteria));
    $dataprovider->pagination = false;
    $dataprovider->sort->defaultOrder = "date_created DESC";
?>
<?php $this->beginContent('//layouts/main'); ?>

<style>
#yw2 > div.items {
  margin: 5px 16px;
}
</style>


<div class="row-fluid">
    <div class="span3">
        <div class="sidebar-nav">

            <?php
            $this->widget('zii.widgets.CMenu', array(
                /* 'type'=>'list', */
                'encodeLabel' => false,
                'items' => array(
                    array('label' => '<i class="icon icon-home"></i>  Dashboard <span class="label label-info pull-right">Back</span>', 'url' => array('/site/index'), 'itemOptions' => array('class' => '')),
                    // Include the operations menu
                    array('label' => 'OPERATIONS', 'items' => $this->menu),

                ),
            ));
            ?>
        </div>


        <div class="">
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataprovider,
                'template'=>'{summary}{sorter}{pager}{items}{pager}',
                'itemView'=>'application.modules.dnc.views.default._view',
                'htmlOptions'=>array(
                    "style"=>"   height: 691px;    overflow-y: scroll;    -webkit-box-shadow: -1px 0px 10px 0px rgba(0,0,0,0.65); -moz-box-shadow: -1px 0px 10px 0px rgba(0,0,0,0.65); box-shadow: -1px 0px 10px 0px rgba(0,0,0,0.65);",
                    'id'=>'whitelistMobileList',
                )
            )); ?>
        </div>

        <br>

    </div><!--/span-->
    <div class="span9">
        <?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link('Dashboard'),
                'htmlOptions' => array('class' => 'breadcrumb')
            ));
        ?><!-- breadcrumbs -->
<?php endif ?>

        <!-- Include content pages -->
<?php echo $content; ?>

    </div><!--/span-->
</div><!--/row-->


<?php $this->endContent(); ?>
