<?php
/* @var $this SiteController */

$allAccounts = Accounts::model()->findAll();

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl;

$this->menu=array(
    array('label'=>'Create Records', 'url'=>array('create')),
    array('label'=>'Manage Records', 'url'=>array('admin')),
);
?>
<div class="row-fluid">
    <div class="span3">
        <h2>[Menu Here]</h2>
        <?php
            /*$this->widget('zii.widgets.CMenu', array(
                 'type'=>'list', 
                'encodeLabel' => false,
                'items' => array(
                    array('label' => '<i class="icon icon-home"></i>  Dashboard <span class="label label-info pull-right">Back</span>', 'url' => array('/site/index'), 'itemOptions' => array('class' => '')),
                    // Include the operations menu
                    array('label' => 'Menu', 'items' => $this->menu),
                ),
            ));
            */
        ?>
    </div>
    <div class="span9">
    	<div class="span3">
            <?php  
                //foreach accounts 

                //  render template

            ?>

            <?php
        		$this->beginWidget('zii.widgets.CPortlet', array(
        			'title'=>'<span class="icon-picture"></span>Operations Chart',
        			'titleCssClass'=>''
        		  ));
        	?>
           asda


            <?php $this->endWidget(); ?>
    	</div>
    </div>
</div>



<script>
    $(function() {

    });
</script>