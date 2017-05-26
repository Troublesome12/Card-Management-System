<style>
	td, th {
		text-align: center;
	}
	.well {
		margin-top: 10px;
	}
</style>

<div class="container">
	<div class="well well-sm">
		<?php echo form_open('user/searchLog'); ?>
		<?php echo form_input(['name'=>'search','id'=>'search', 'class'=>'form-control input-custom', 'placeholder'=>'search']); ?>
		<?php echo form_submit(['value'=>'Search', 'class'=>'btn btn-default btn-sm']); ?>	
		<?php echo anchor('user/log', 'Show All', ['class'=>'btn btn-default btn-sm']); ?>	
		<?php echo form_close(); ?>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>User</th>
				<th>Email</th>
				<th>IP Address</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = 1; ?>
			<?php foreach ($logs as $log) : ?>
			<tr>
				<td><?php echo $index++; ?></td>
				<td><?php echo $log->name; ?></td>
				<td><?php echo $log->email; ?></td>
				<td><?php echo $log->ip_address; ?></td>
				<td><?php echo date('d/m/Y h:i A', strtotime($log->created_at)); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<center><?php echo $links; ?></center>
</div>