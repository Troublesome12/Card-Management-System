<div class="container">
	<br>
	<div class="panel panel-default">
		<div class="panel-body">
			<h4 class="text-center"><?php echo $user->name; ?></h4>
			<hr>
			<?php echo form_open_multipart('user/update', ['class' => 'form-horizontal']); ?>
				<input type="hidden" name="id" value="<?php echo $user->id; ?>">
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">Name</label>
						<div class="col-md-10">
							<?php echo form_input(['type'=>'text','name'=>'name','class'=>'form-control', 'value'=>$user->name, 'required'=>'required']); ?>
							<?php echo form_error('name'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-2 control-label">Email</label>
						<div class="col-md-10">
							<?php echo form_input(['type'=>'email','name'=>'email','class'=>'form-control','value'=>$user->email, 'required'=>'required']); ?>
							<?php echo form_error('email'); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Password</label>
						<div class="col-md-10">
							<?php echo form_input(['type'=>'password','name'=>'password','class'=>'form-control','placeholder'=>'Password', 'value'=>set_value('password')]); ?>
							<?php echo form_error('password'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-2 control-label">Password Confirm</label>
						<div class="col-md-10">
							<?php echo form_input(['type'=>'password','name'=>'password_confirm','class'=>'form-control','placeholder'=>'Confirm your password', 'value'=>set_value('password_confirm')]); ?>
							<?php echo form_error('password_confirm'); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Image</label>
						<div class="col-md-10">
							<?php echo form_upload(['name'=>'image','class'=>'form-control', 'value'=>set_value('image'), 'accept'=>'image/jpg, image/jpeg, image/png', 'id'=>"image-input"]); ?>
							<span id="image-error" class="text-danger hidden">only png, jpg & jpeg file types are allowed</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							<center>
							<?php if($user->image != null ) : ?>
								<img id="edit-image" src="<?php echo base_url('assets/images/'.$user->image) ?>" alt="user image"/>
							<?php else : ?>
								<img id="edit-image" src="<?php echo base_url('assets/images/default.jpg') ?>" alt="user image"/>
							<?php endif; ?>
							</center>
							<?php echo form_submit(['value'=>'Save','class'=>'btn btn-block btn-primary']); ?>
						</div>
					</div>
				</fieldset>
			<?php echo form_close() ?>
		</div>
	</div>
</div>