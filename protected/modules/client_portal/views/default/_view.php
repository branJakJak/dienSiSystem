<?php
/* @var $data BlackListedMobile */
?>

<div class="view">
		<div class="span1 offset1">
			<i class="fa fa-mobile" style="font-size: 80px;"></i>
		</div>
		<div class="span5">
			<h3>
				<?php echo $data->mobile_number ?>
				&nbsp;&nbsp;
				<small>
					submitted from <?php echo CHtml::encode($data->ip_address); ?>
				</small>
			</h3>
			<?php $this->widget(
			    'yiiwheels.widgets.timeago.WhTimeAgo',
			    array(
			        'date' => $data->date_created
			    )
			); ?>
		</div>
		<div class="clearfix"></div>
</div>