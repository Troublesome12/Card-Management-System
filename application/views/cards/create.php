<div class="container">
	<br>
	<h4 class="text-center">Create New Card</h4>
	<hr>
	<?php echo form_open('card/store', ['class' => 'form-horizontal']); ?>
		<fieldset>
			<div class="form-group">
				<label class="col-md-2 control-label">Name</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'text','name'=>'name','class'=>'form-control','placeholder'=>'Name', 'value'=>set_value('name'), 'required'=>'required']); ?>
					<?php echo form_error('name'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Designation</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'text','name'=>'designation','class'=>'form-control','placeholder'=>'Designation', 'value'=>set_value('designation'), 'required'=>'required']); ?>
					<?php echo form_error('designation'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Company</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'text','name'=>'company','class'=>'form-control','placeholder'=>'company', 'value'=>set_value('company')]); ?>
					<?php echo form_error('company'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Address</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'text','name'=>'address','class'=>'form-control','placeholder'=>'Address', 'value'=>set_value('address'), 'required'=>'required']); ?>
					<?php echo form_error('address'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Email</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'email','name'=>'email','class'=>'form-control','placeholder'=>'Email', 'value'=>set_value('email'), 'required'=>'required']); ?>
					<?php echo form_error('email'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Mobile No</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'text','name'=>'mobile','class'=>'form-control','placeholder'=>'Mobile no', 'value'=>set_value('mobile'), 'required'=>'required']); ?>
					<?php echo form_error('mobile'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Website</label>
				<div class="col-md-10">
					<?php echo form_input(['type'=>'text','name'=>'website','class'=>'form-control','placeholder'=>'Website', 'value'=>set_value('website')]); ?>
					<?php echo form_error('website'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-6 col-md-offset-3">
					<?php echo form_submit(['value'=>'Create','class'=>'btn btn-block btn-primary']); ?>
				</div>
			</div>
		</fieldset>
	<?php echo form_close() ?>
</div>