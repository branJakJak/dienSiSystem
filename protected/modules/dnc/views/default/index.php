<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
$this->menu=array(
	array('label'=>'Back to upload', 'url'=>  Yii::app()->getBaseUrl(true)."/whitelist/default" ),
);
Yii::app()->clientScript->registerScript('queueid', 'window.QUEUE_ID = '.$model->queue_id .';', CClientScript::POS_END);
?>

<div class="span6">

	<h3>
		<?php echo CHtml::encode($model->queue_name); ?>
	</h3>
	<hr>
	<div class="row">
        <?php
            $this->widget('bootstrap.widgets.TbAlert', array(
                'fade' => true,
                'closeText' => '×',
                'alerts' => array(
                    'success' => array('block' => true, 'fade' => true, 'closeText' => '×'),
                    'error' => array('block' => true, 'fade' => true, 'closeText' => '×'),
                ),
                'htmlOptions' => array('class' => 'alertStatusContainer')
            ));
        ?>
	</div>
	<div class='row'>
		<div class="span7"><strong>Status: </strong></div>
		<div class="span1"><?php echo $model->status ?></div>
		<br>
		<br>
	</div>
	<div class='row'>
		<div class="span7"><strong>Total <strong>Uploaded</strong> mobile numbers : </strong></div>
		<div class="span1">
			<span class="label label-info">
				<?php echo $totalUploadedMobileNumbers ?>
			</span>
		</div>
		<br>
		<br>
	</div>
	<div class='row'>
		<div class='span7'>
			<strong>Duplicates from file : </strong>
		</div>
		<div class='span1'>
			<span class="label label-info">
				<?php echo $totalDuplicatesRemoved; ?>
			</span>
		</div>
	</div>
	<hr>
	<div class=''>
		<a href="?download=true" title="download" class='btn btn-lg btn-primary btn-block'>
			Download
			<span class="label label-info">
				<?php echo $totalDataToDownload ?>
			</span>
		</a>
	</div>
	<br />
</div>


<script type="text/javascript">
	function checkExportStatus (queue_id) {
		 jQuery.ajax({
		   url: '/dnc/exportStatus/'.queue_id,
		   type: 'GET',
		   dataType: 'json',
		   beforeSend:function(a,b){
		   		jQuery(".alertStatusContainer").html('<img src="/img/loading.gif" style="height: 41px;">Rechecking data..');
		   },
		   success: function(data, textStatus, xhr) {
				if (data.status === 'ok') {
					window.location.reload();
				}else {
					window.checkExportStatus(queue_id);
				}
		   },
		   error: function(xhr, textStatus, errorThrown) {
		     console.error(xhr);
		     console.error(textStatus);
		     console.error(errorThrown);
		   }
		 });
	}
	checkExportStatus(window.QUEUE_ID);
</script>