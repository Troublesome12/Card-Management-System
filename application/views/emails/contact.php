	<div class="container">
   		<div class="row">
   			<div class="well well-sm" style="margin-top: 10px;">
				<?php echo form_open('email/search',['class'=>'form-inline','method'=>'get']); ?>
				<?php echo form_input(['name'=>'search','id'=>'search', 'class'=>'form-control input-custom', 'placeholder'=>'search']); ?>
				<?php echo form_hidden('from', 'contacts'); ?>
				<?php echo form_submit(['value'=>'Search', 'class'=>'btn btn-default btn-sm']); ?>	
				<?php echo anchor('email/contact', 'Show All', ['class'=>'btn btn-default btn-sm']); ?>
				<?php echo form_close(); ?>
				
				<?php if($hasPermission) : ?>
				<div class="btn-group pull-right">  	
		            <a href="#" data-toggle="collapse" data-target="#create-contact" class="btn btn-default btn-sm">Create New</a>
		    	</div>
		    	<?php endif; ?>

		    	<div class="dropdown pull-right">
					<button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Export
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#" id="contactExportExcel">Excel</a></li>
						<li><a href="#" id="contactExportCSV">CSV</a></li>
						<li><a href="#" id="contactExportPDF">PDF</a></li>
					</ul>
				</div>

				<?php if($hasPermission) : ?>
				<div class="dropdown pull-right">
					<button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Import
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url('assets/files/sampleEmail.csv');?>">Sample Excel/CSV</a></li>
						<li><a href="<?=base_url('email/import');?>">Choose Excel/CSV</a></li>
					</ul>
				</div>
				<?php endif; ?>
		    	
		    	<a href="" id="contactPagePrint" class="btn btn-default btn-sm pull-right"><span class="fa fa-print"></span> Print</a>
	    	</div>
			
			<?php if($hasPermission) : ?>
			<div id="create-contact" class="well collapse <?php if(validation_errors()){echo 'in';} ?>">
				<?php echo form_open('email/createContact'); ?>
				<div class="form-group">
				    <label for="name">Name</label>
				     	<?php echo form_input(['name'=>'name','id'=>'name', 'class'=>'form-control', 'value'=> set_value('name'), 'placeholder'=>'Name','required'=>'']); ?>
				     	<?php echo form_error('name'); ?>
				</div>
				<div class="form-group">
				    <label for="email">Email</label>
				    <?php echo form_input(['type'=>'email','name'=>'email','id'=>'email', 'class'=>'form-control', 'value'=> set_value('email'),'placeholder'=>'Email address','required'=>'']); ?>
				    <?php echo form_error('email'); ?>
				</div>
				<div class="form-group">
				    <label for="name">Mobile</label>
				     <?php echo form_input(['name'=>'mobile','id'=>'mobile', 'class'=>'form-control', 'value'=> set_value('mobile'), 'placeholder'=>'Contact number']); ?>
				    <?php echo form_error('mobile'); ?>
				</div>
			    <div class="text-right">
			     <?php echo form_submit(['value'=>'Create Contact', 'class'=>'btn btn-primary']); ?>
			    </div>
					
				<?php echo form_close(); ?>
			</div>
			<?php endif; ?>

			<div class="panel panel-default panel-table">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-6">
							<h3 class="panel-title">Email Contact List</h3>
						</div>
					</div>
				</div>
  				<div id="printList" class="panel-body">
            		<table class="table table-striped table-bordered table-list">
						<thead>
							<tr>
							    <th class="hidden-xs">ID</th>
							    <th>Name</th>
							    <th>Email</th>
							    <th>Contact</th>
							    <?php if($hasPermission) : ?>
							    	<th style="text-align: center"><i class="fa fa-cog"></i></th>
								<?php endif; ?>
							</tr> 
						</thead>
						<tbody">
							<?php
								if($page == 0){ $id = 1;}
								else{ $id = $page+1;}
								if($contacts):
									foreach($contacts as $contact):
							?>
							<tr>
							    <td align="center" class="hidden-xs"><?=$id++;?></td>
							    <td>
							    	<div id="name_<?=$contact->id;?>" class="name">
							    		<?=$contact->name;?>
							    	</div>
							    	<div>
										<input type="text" class="hide name2" id="edit_name_<?=$contact->id;?>" value="<?=$contact->name;?>">
							    	</div>	
							    </td>
							    <td>
							    	<div id="email_<?=$contact->id;?>" class="email">
							    		<?=$contact->email;?>
							    	</div>
							    	<div>
										<input type="text" class="hide email2" id="edit_email_<?=$contact->id;?>" value="<?=$contact->email;?>">
							    	</div>
							    </td>
							    <td>
							    	<div id="mobile_<?=$contact->id;?>" class="mobile">
							    		<?=$contact->mobile==''?'N/A':$contact->mobile;?>
							    	</div>
							    	<div>
										<input type="text" class="hide mobile2" id="edit_mobile_<?=$contact->id;?>" value="<?=$contact->mobile;?>">
							    	</div>
							    </td>
							    <?php if($hasPermission) : ?>
							    <td align="center">
							    	<div id="option_button_<?=$contact->id;?>" class="option">
							      		<button type="button" onclick="editContact('<?=$contact->id;?>')" class="btn btn-default"><i class="fa fa-pencil"></i></button>
							      		<button type="button" onclick="deleteContact('<?=$contact->id;?>')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
						      		</div>
						      		<div id="save_option_button_<?=$contact->id;?>" class="hide option2">
						      			<button type="button" onclick="updateEditContact('<?=$contact->id;?>')" class="btn btn-success"><i class="fa fa-check"></i></button>
						      			<button type="button" onclick="cancleEditContact('<?=$contact->id;?>')" class="btn btn-danger"><i class="fa fa-times"></i></button>
						      		</div>
						    	</td>
						    	<?php endif; ?>
							</tr>
							<?php
									endforeach;
								else:
									echo "<tr><td colspan='5'><h3 align='center'>No cantact information found</h3></td></tr>";
								endif
							?>
						</tbody>
            		</table>
				</div>
				<div id="printArea" style="opacity: 0; height: 0px">
  					<table id="myTable">
  						<thead>
							<tr>
							    <th>Name</th>
							    <th>Email</th>
							    <th>Contact</th>
							</tr>
						</thead>
						<tbody id="exportTableBody" ></tbody>
  					</table>
				</div>
				<center><?php echo $links; ?></center>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('/assets/js/export/jquery.min.js'); ?>"></script>
	<!-- export table library -->
	<script src="<?php echo base_url('/assets/js/export/FileSaver/FileSaver.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/js-xlsx/xlsx.core.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/jsPDF/jspdf.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/jsPDF-AutoTable/jspdf.plugin.autotable.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/tableExport.min.js'); ?>"></script>
	<!-- custom script file -->
	<script src="<?php echo base_url();?>assets/js/customEmail.js"></script>

	</div> <!-- End of main-body -->	
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-6 col-sm-6 text-right">
						<div class="footer-bottom-text">
							<p>© <?php echo $settings->copyright; ?>. All rights reserved. Developed by <a href="https://www.flickmax.net/" target="blank">Flick Max Ltd.</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/bootsnav.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/easejs.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/azexo_transitions.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/tweenjs.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/lucid.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/wow.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>

		<script>
			$(window).on('load', function() {
				$(this).impulse();
			});
			new WOW().init();
		</script>
		<!-- sweet alert to show flush message -->
		<script>
        	<?php if ( isset($_SESSION['message']) ) :?>
                swal({
                    title: "<?php echo $_SESSION['message']; ?>",
                    type: "<?php echo $_SESSION['type']; ?>",
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                });
            <?php endif; ?>
		</script>

		<script>
		    var base_url = "<?php echo base_url();?>";
		</script>		
	</body>
</html>