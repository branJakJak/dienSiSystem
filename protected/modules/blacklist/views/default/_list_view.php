	<div class="view">
	<div class=''>
		<div class="btn-group">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-gear"></i>
				<span class="caret"></span></a>
			<ul class="dropdown-menu" >
				<li>
					<a class="" href="<?php echo Yii::app()->getBaseUrl(true).'/blacklist/delete?queue_id='.$data->queue_id ?>" onClick='return confirm("Are you sure you want to delete this ?")'>
						<i class="fa fa-trash"></i>
						Delete
					</a>
				</li>
				<li>
					<a target="_blank" href="<?php echo Yii::app()->getBaseUrl(true).'/blackListedMobile/admin?BlackListedMobile[queue_id]='.$data->queue_id ?>" >
						<i class="fa fa-eye"></i>
						View
					</a>
				</li>
			</ul>
		</div>
	</div>	
	<h5>
		<small>
		<b>Queue Name</b> <br>
		</small>
			<strong>
				<?php 
					$model = JobQueue::model()->findByAttributes(array('queue_id'=>$data->queue_id));
					if ($model) {
						echo basename($model->queue_name);
					}else{
						echo "Not Available";
					}
					
				?>
			</strong>
		<br>
		<small>
			<b>Date Uploaded</b> <br>
		</small>
			<strong>
				<?php echo date("jS \of F Y h:i:s A" , strtotime($data->date_created)); ?>
			</strong>
	</h5>
	

</div>
