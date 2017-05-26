		<script src="<?php echo base_url('assets/js/tinymce/tinymce.min.js'); ?>"></script>
		<script>
			tinymce.init({
				selector: 'textarea',
				elementpath: false,
				resize: false,
				statusbar: false,
				theme: 'modern',
				plugins: [
					'advlist autolink lists link image charmap print preview hr anchor pagebreak',
					'searchreplace visualblocks visualchars fullscreen',
					'insertdatetime media nonbreaking save contextmenu directionality',
					'emoticons paste textcolor colorpicker textpattern imagetools toc'
				],
				menubar: false,
				toolbar1: 'undo redo | insert | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview',
				toolbar2: 'styleselect | fontselect | fontsizeselect | bold italic | forecolor backcolor emoticons',
				image_advtab: true,
				content_css: [
					'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
					'//www.tinymce.com/css/codepen.min.css'
				]
			});
		</script>
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Manage Email</h4>
					</div>
					<form id="manageForm" class="form-horizontal">
						<div class="panel-body">
							<div class="form-group">
								<label for="group" class="col-sm-2 control-label">Group</label>
								<div class="col-sm-4">
									<select id="groups" class="ms form-control" multiple="multiple" name="groups[]">
										<?php
											$group_id = array();
											if(isset($manage))
												$group_id = explode(',',$manage->group_id);
										?>
										<option
										<?php
											if(isset($manage) && in_array('0', $group_id)){
												echo 'selected=selected';
											}
										?>
										value="0">All Groups</option>
			                            <?php foreach ($groups as $group){ ?>
			                            	<option
												<?php
													if( isset($manage) && in_array($group->id, $group_id)){
														echo 'selected=selected';
													}
												?>
			                            		value="<?php echo $group->id;?>"><?php echo $group->name;?></option>
			                            <?php }?>
	                        		</select>
								</div>
								<label for="email" class="col-sm-1 control-label">Email</label>
								<div class="col-sm-5">
								 	<select id="contacts" class="ms form-control" multiple="multiple" name="contacts[]">
								 		<?php
											$contact_id = array();
											if(isset($manage))
												$contact_id = explode(',',$manage->contact_id);
										?>
			                            <?php foreach ($contacts as $contact){ ?>
			                            <option
											<?php
												if( isset($manage) && in_array($contact->id, $contact_id)){
													echo 'selected=selected';
												}
											?>
			                            	value="<?php echo $contact->id;?>"><?php echo $contact->email;?></option>
			                            <?php }?>
	                        		</select>
								</div>
							</div>
							<div class="form-group">
								<label for="subject" class="col-sm-2 control-label">Subject</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="subject" placeholder="About" value="<?=isset($manage) ? $manage->subject : '';?>">
								</div>
							</div>
							<div class="form-group">
								<label for="footer" class="col-sm-2 control-label">Footer</label>
								<div id="footer" class="col-sm-10">
									<textarea rows="3"><?=isset($manage) ? str_replace('>?','>',$manage->footer) : '';?></textarea>
								</div>
							</div>
							
						</div>
						<div align="right" class="panel-footer">
							<input type="submit" class="btn btn-primary" value="Save">
							<a href="#" id="manageReset" class="btn btn-warning">Reset</a>
						</div>
						<input type="hidden" id="userId" value="<?=$user_id;?>">
					</form>
				</div>
			</div>
		</div>

