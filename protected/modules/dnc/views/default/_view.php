	<div class="view">
	<div class=''>
		<div class="btn-group">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-gear"></i>
				<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a class="" href="<?php echo Yii::app()->getBaseUrl(true).'/dnc/'.$data->queue_id ?>">
						<i class="fa fa-eye"></i>
						Load
					</a>
				</li>
				<li>
					<a class="" href="<?php echo Yii::app()->getBaseUrl(true).'/dnc/delete?queue_id='.$data->queue_id ?>" onclick = 'return confirm("Are you sure you want to delete this ?")'>
						<i class="fa fa-trash"></i>
						Delete
					</a>
				</li>
			</ul>
		</div>
	</div>	
	<h5>
	<small>
	<b>Filename</b> <br>
	</small>
	<a href="<?php echo Yii::app()->getBaseUrl(true) ?>/dnc/<?php echo $data->queue_id ?>">
		<strong>
			<?php echo $data->queue_name ?>
		</strong>
	</a>
	<br>
	<small>
		<strong>Date uploaded : </strong>
		<?php echo date("jS \of F Y h:i:s A" , strtotime($data->date_created)); ?>
	</small>
	</h5>
	

</div>
