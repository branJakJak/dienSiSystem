<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
$this->menu=array(
	array('label'=>'Back to upload', 'url'=>  Yii::app()->getBaseUrl(true)."/whitelist/default" ),
);




?>

<div class="span6">
	<h3>
		<?php echo CHtml::encode($model->queue_name); ?>
	</h3>
	<hr>
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
	<div class='row'>
		<div class="span7"><strong>Removed mobile numbers(blacklist) : </strong></div>
		<div class="span1">
			<span class="label label-info">
				<?php echo count($removedMobileNumbersArr) ?>
				<?php //echo $totalRemovedMobileNumbers; ?>
			</span>
		</div>
		<br>
		<br>
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
<div class="span5">
	<h3>
		Removed mobile numbers
	</h3>
	<div class="span5">
		<textarea style="margin: 0px 0px 9px; width: 227px; height: 205px;"><?php if (isset($removedMobileNumbersArr)): ?><?php foreach ($removedMobileNumbersArr as $key => $value): ?><?php echo $value['mobile_number']."\n" ?><?php endforeach ?><?php endif ?></textarea>	</div>
</div>
