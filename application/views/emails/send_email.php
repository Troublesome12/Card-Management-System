	<script src="<?php echo base_url('assets/js/tinymce/tinymce.min.js'); ?>"></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			elementpath: false,
			statusbar: false,
			theme: 'modern',
			plugins: [
				'advlist autolink lists link charmap print preview hr anchor pagebreak',
				'searchreplace visualblocks visualchars fullscreen',
				'insertdatetime media nonbreaking save contextmenu directionality',
				'emoticons paste textcolor colorpicker textpattern imagetools toc noneditable'
			],
			menubar: false,
			toolbar1: 'undo redo | insert | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview ',
			toolbar2: 'styleselect | fontselect | fontsizeselect | bold italic | forecolor backcolor | emoticons ',
			content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css',
				'<?=base_url("assets/css/bootstrap.css")?>',
				'<?=base_url("assets/css/send_email.css")?>'
			]
		});
	</script>
	<style>
		
	</style>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Send Email</h4>
			</div>
			<form id="sendEmailForm" class="form-horizontal">
				<div class="panel-body">
					<div class="form-group">
						<label for="to" class="col-sm-2 control-label">To</label>
						<div class="col-sm-10">
							<select id="to" class="ms form-control" multiple="multiple" name="groups[]">
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
	                            	value="<?php echo $contact->email;?>"><?php echo $contact->email;?></option>
	                            <?php }?>
                    		</select>
						</div>
					</div>
					<div class="form-group">
						<label for="from" class="col-sm-2 control-label">From</label>
						<div class="col-sm-10">
						  <input type="email" class="form-control" id="from" placeholder="Email address" value="<?=$user->email;?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="subject" class="col-sm-2 control-label">Subject</label>
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="subject" placeholder="About" value="<?=isset($manage) ? $manage->subject : '';?>">
						</div>
					</div>
					<div class="form-group">
						<label for="message" class="col-sm-2 control-label">Message</label>
						<div id="message" class="col-sm-10">
							<textarea rows="10">
								<div class="email-body"></div>
								<div id="email-footer" class="email-footer"><?=isset($manage) ? str_replace('>?','>',$manage->footer) : '';?></div>
							</textarea>
						</div>
					</div>
					
				</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-md-offset-2">
							<input type="submit" class="btn btn-primary" value="Send">
							<label class="fileContainer btn btn-default">
							    <i class="fa fa-paperclip" aria-hidden="true" title="Attach files"></i>
							    <input type="file" id="file" name="email-file" style="display: none"/>
							</label>
						</div>
					</div>
				</div>
				<input type="hidden" id="userId" value="<?=$user->id;?>">
			</form>
		</div>
	</div>
	