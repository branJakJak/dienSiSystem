<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->account_id,
);

$this->menu=array(
	array('label'=>'List Accounts', 'url'=>array('index')),
	array('label'=>'Create Accounts', 'url'=>array('create')),
	array('label'=>'Update Accounts', 'url'=>array('update', 'id'=>$model->account_id)),
	array('label'=>'Delete Accounts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accounts', 'url'=>array('admin')),
);









?>

<h1>View Accounts #<?php echo $model->account_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_id',
		'claimAccountName',
		'claimAccountDescription',
		'websiteURL',
		// 'date_created',
		// 'date_updated',
	),
)); ?>

<a onclick="generateCode()" href="#generateCodeMdl" role="button" class="btn btn-primary" data-toggle="modal">Generate Code</a>
 
<!-- Modal -->
<div id="generateCodeMdl" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Generate Code</h3>
  </div>
  <div class="modal-body">
  	<strong>Paste the generate code to your target website</strong>
  	<p class="hint">* make sure that you configure the code according to your needs</p>

    <textarea id="generatedCodeOutputArea" style="margin: 0px 0px 9px; width: 511px; height: 264px;">
		$entriesTable = '[ENTRIES_TABLE]';
		$account_id = <?php echo $model->account_id ?>;//depends on each website
		$dataArr = array(
				"[THE_LABEL]" => "[THE_VALUE]",
				"Date Submitted"=>date("Y-m-d H:i:s"),
				"IP Address"=>$requestInformation['REMOTE_ADDR'],
		);
		$postfields = array(
				"account_id"=>$account_id,
				"data"=>json_encode($dataArr),
				"ip_address"=>$requestInformation['REMOTE_ADDR'],
				"other_info"=>json_encode($requestInformation),
			);
		$postfields = http_build_query($postfields);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, "http://claimdatastorage.ezfastloans4u.com/index.php/import");
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		$curl_res = curl_exec($ch);
    </textarea>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>







