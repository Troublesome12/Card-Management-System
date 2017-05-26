<div class="container">

	<br><br>
	<div class="panel panel-default">
		<div class="panel-body">
			<h4 class="text-center">User</h4>
			<hr>
			<h5><a data-toggle="collapse" data-target="#create_user"  style="cursor: pointer;"><i class="fa fa-plus"></i> Create New User</a></h5>
			
		    <div id="create_user" class="collapse <?php if(validation_errors()) echo 'in'; ?>">
		        <div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Create User</h3>
					</div>
		                
		            <div class="panel-body ">
		                <?php echo form_open("user/createUser",['class' => 'form-horizontal']); ?>
		                <div class="form-group">
							<label class="col-md-3">Name</label>
							<div class="col-md-9">
								<?php echo form_input(['type'=>'text','name'=>'name','class'=>'form-control','placeholder'=>'Name', 'value'=>set_value('name'), 'required'=>'required']); ?>
								<?php echo form_error('name'); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3">Email</label>
							<div class="col-md-9">
								<?php echo form_input(['type'=>'email', 'name'=>'email','class'=>'form-control','placeholder'=>'Email', 'value'=>set_value('email'), 'required'=>'required']); ?>
								<?php echo form_error('email'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3">Password</label>
							<div class="col-md-9">
								<?php echo form_input(['type'=>'password','name'=>'password','class'=>'form-control','placeholder'=>'Password', 'value'=>set_value('password'), 'required'=>'required']); ?>
								<?php echo form_error('password'); ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3">Confirm Password</label>
							<div class="col-md-9">
								<?php echo form_input(['type'=>'password','name'=>'password_confirm','class'=>'form-control','placeholder'=>'Confirm your password', 'value'=>set_value('password_confirm'), 'required'=>'required']); ?>
								<?php echo form_error('password_confirm'); ?>
							</div>
						</div>

		                <div class="form-group">
		                    <label class="col-md-3">User Permissions</label>
		                    <div class="col-md-9">
		                        <select class="ms form-control" multiple="multiple" name="permissions[]">
		                            <?php foreach ($permission_list as $permission){ ?>
		                            <option value="<?php echo $permission->id;?>"><?php echo $permission->name;?></option>
		                            <?php }?>
		                        </select>
		                   	</div>
		                </div>

		                <div class="form-group">
							<label class="col-md-3">Make Admin</label>
							<div class="col-md-7">
								<?php echo form_input(['type'=>'checkbox','name'=>'isAdmin', 'value'=>'1']); ?>
								<?php echo form_error('isAdmin'); ?>
							</div>
						</div>

		                <div class="form-group">
		                    <div class="col-md-4 col-md-offset-4">
		                    <?php echo form_input(['type'=>'submit' ,'class'=>'btn btn-primary btn-block', 'value'=>'Submit']); ?>
		                    </div>
		                </div>
		                <?php echo form_close(); ?>
		            </div>           
		        </div>            
		    </div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Permission</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $count=1; ?>
					<?php foreach ($users as $user) : ?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $user->name; ?></td>
							
								<?php 
									$permissions = $this->db->query(
									"SELECT user_permission.permission_id AS id, permissions.name 
									FROM permissions, user_permission 
									WHERE permissions.id = user_permission.permission_id 
									AND user_permission.user_id = $user->id")->result(); 
								?>
							<td>
								<?php $index = 0; ?>
								<?php foreach ($permissions as $permission) : ?>
									<?php if($index != 0) :?>
										<?php echo ', '; ?>
									<?php endif; ?>
									<?php echo $permission->name; ?>
									<?php $index ++; ?>
								<?php endforeach; ?>
							</td>
							<td>
								<button data-toggle="modal" data-target="#editPermission<?php echo $user->id;?>" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
								<button onClick="deleteUser(<?php echo $user->id;?>)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>

								<div class="modal fade" id="editPermission<?php echo $user->id;?>" role="dialog">
		                            <div class="modal-dialog modal-lg">
		                                <div class="modal-body" style="background-color: transparent;">
		                                    <div class="col-sm-12">
		                                        <div class="panel employee">
		                                            <div class="panel-heading head">
		                                                <h4 class="panel-title">Permission Edit</h4>
		                                                <button type="button" class="close" data-dismiss="modal" style="margin-top: -17px;">&times;</button>
		                                            </div>
		                                            <div class="panel-body ">
		                                                <?php echo form_open("user/editPermission"); ?>
		                                                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
		                                                <div class="form-group col-sm-12">
		                                                    <label class="control-label">User Name </label>
		                                                    <input type='text' class="form-control" value="<?php echo $user->name;?>" readonly>                                    
		                                                </div>        

		                                                <div class="form-group col-sm-12" style="padding: 0px;">
		                                                    <div class=" col-md-12">
		                                                        <label class="control-label">Choose Permission</label>
		                                                        <select class="ms" multiple="multiple" name="permissions[]">

		                                                            <?php foreach ($permission_list as $permission){ ?>
		                                                            <option <?php
		                                                                        if(in_array($permission, $permissions)) {
		                                                                            echo 'selected=selected';
		                                                                        }
		                                                                    ?> value="<?php echo $permission->id;?>"><?php echo $permission->name;?></option>
		                                                            <?php }?>
		                                                        </select>
		                                                    </div>                                                                                                                                                                           
		                                                </div>

		                                                <div class="form-group col-sm-12" style="padding: 0px;">
															<label class="col-sm-3">Admin</label>
															<div class="col-sm-7">
																<?php echo form_input(['type'=>'checkbox','name'=>'isAdmin', 'value'=>'1']); ?>
																<?php echo form_error('isAdmin'); ?>
															</div>
														</div>

		                                                <div class="col-sm-4 margin pull-right" style="margin-top:20px;">
		                                                    <button id="btn_emp" type="submit" class="btn btn-primary btn-block">Save</button>
		                                                </div>
		                                                <?php echo form_close(); ?>              
		                                                <br>
		                                            </div>          
		                                        </div>
		                                    </div> 
		                                </div>
		                            </div>
		                        </div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<br><br>
	<div class="panel panel-default">
		<div class="panel-body">
			<h4 class="text-center">Website</h4>
			<hr>
			<?php echo form_open_multipart('user/saveSettings', ['class' => 'form-horizontal', 'id'=>'settings_form', 'onsubmit'=>"return confirm('Do you really want to save the form?');"]); ?>
			<div class="row">
				<div class="form-group">
					<label class="col-md-2 control-label" style="margin-top: 50px">Logo</label>	
					<div class="col-md-6" style="margin-top: 50px">
						<?php echo form_upload(['name'=>'logo','class'=>'form-control', 'value'=>set_value('logo'), 'accept'=>'image/png', 'id'=>"logo-input"]); ?>
						<span id="image-error" class="text-danger hidden">*only png file is allowed</span>
					</div>
					
					<div class="pull-right">
						<img src="<?php echo base_url('assets/images/'.$settings->logo); ?>" class="logo-sample">	
					</div>
				</div>
			</div>
			<br><br>
			<div class="form-group">
				<label class="col-md-2 control-label"><i class="fa fa-facebook"></i> &nbsp;&nbsp;&nbsp; Facebook</label>
				<div class="col-md-6">
					<?php echo form_input(['type'=>'url','name'=>'facebook','class'=>'form-control','placeholder'=>'facebook link', 'value'=>$settings->facebook_link]); ?>
					<?php echo form_error('facebook'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-2 control-label"><i class="fa fa-twitter"></i> &nbsp;&nbsp;&nbsp; Twitter</label>
				<div class="col-md-6">
					<?php echo form_input(['type'=>'url','name'=>'twitter','class'=>'form-control','placeholder'=>'twitter link', 'value'=>$settings->twitter_link]); ?>
					<?php echo form_error('twitter'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><i class="fa fa-linkedin"></i> &nbsp;&nbsp;&nbsp; Linkedin</label>
				<div class="col-md-6">
					<?php echo form_input(['type'=>'url','name'=>'linkedin','class'=>'form-control','placeholder'=>'linkedin link', 'value'=>$settings->linkedin_link]); ?>
					<?php echo form_error('linkedin'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><i class="fa fa-google-plus"></i> &nbsp;&nbsp;&nbsp; Google plus</label>
				<div class="col-md-6">
					<?php echo form_input(['type'=>'url','name'=>'google','class'=>'form-control','placeholder'=>'google plus link', 'value'=>$settings->google_plus_link]); ?>
					<?php echo form_error('google'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><i class="fa fa-copyright"></i> &nbsp;&nbsp;&nbsp; Copyright</label>
				<div class="col-md-6">
					<?php echo form_input(['type'=>'text','name'=>'copyright','class'=>'form-control','placeholder'=>'copyright', 'value'=>$settings->copyright]); ?>
					<?php echo form_error('copyright'); ?>
				</div>
			</div>
			<br><br>
			<div class="col-md-6 col-md-offset-2">
				<?php echo form_submit(['value'=>'Save','class'=>'btn btn-block btn-primary', 'id'=>'save']); ?>
			</div>
			<br>
			<?php echo form_close() ?>	
			<br>
		</div>
	</div>
</div>