<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if($template == 2) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/card_template/template2.css'); ?>">
<?php elseif($template == 3) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/card_template/template3.css'); ?>">
<?php else : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/card_template/template1.css'); ?>">
<?php endif; ?>

<?php if($hasPermission) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin.css'); ?>">
<?php endif; ?>
	<div class="container">
		<div class="well well-sm" style="margin-top: 10px;">
			<?php echo form_open('card/search'); ?>
			<?php echo form_input(['name'=>'search','id'=>'search', 'class'=>'form-control input-custom', 'placeholder'=>'search']); ?>
			<?php echo form_submit(['value'=>'Search', 'class'=>'btn btn-default btn-sm']); ?>	
			<?php echo anchor('card', 'Show All', ['class'=>'btn btn-default btn-sm']); ?>	
			<?php echo form_close(); ?>
			
			<div class="btn-group pull-right">  	
	            <button id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span>List</button> 
	            <button id="grid" class="btn btn-default btn-sm"><span
	                class="glyphicon glyphicon-th"></span>Grid</button>
	    	</div>
	    	<div class="dropdown pull-right">
				<button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Export
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="#" id="cardExportExcel">Excel</a></li>
					<li><a href="#" id="cardExportCSV">CSV</a></li>
					<li><a href="#" id="cardExportPDF">PDF</a></li>
				</ul>
			</div>
	    	<button id="print" class="btn btn-default btn-sm pull-right"><span class="fa fa-print"></span> Print</button>
	    	<a href="<?php echo base_url('card/getPinnedCard'); ?>" class="btn btn-default btn-sm pull-right"><span class="fa fa-thumb-tack"></span> Pinned Card</a>
	    </div>
		<div id="details" class="row" style="margin-top: -30px">
		<?php if($cards != NULL) : ?>
			<!-- card Start -->
			<?php foreach ($cards as $card) : ?>
			<div class="col-sm-4">
				<div class="cards">
					<div class="card-top">
						<!-- Toggle menu -->
						<div class="menubtn" id="<?php echo $card->id; ?>"><span></span></div>
						<nav class="navmenu" id="navmenu<?php echo $card->id; ?>">		
							<ul class="text-list">
								<li><a onclick="cardEdit(<?php echo $card->id; ?>)">Edit</a></li>
								<li><a onclick="cardDuplicate(<?php echo $card->id; ?>)">Duplicate</a></li>
								<li><a onclick="cardDelete(<?php echo $card->id; ?>)">Delete</a></li>
							</ul>								
						</nav>

						<?php if($pinnedCard!=null) : ?>
							<!-- pin icon -->
							<?php if (($key = array_search(['card_id', $card->id], $pinnedCard)) !== false) : ?>
								<a class="pin pin-icon" data-id="<?php echo $card->id; ?>"><span></span><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
							<?php else : ?>
								<a class="pin pin-icon-skew" data-id="<?php echo $card->id; ?>"><span></span><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
							<?php endif; ?>
						<?php else : ?> 
							<a class="pin pin-icon-skew" data-id="<?php echo $card->id; ?>"><span></span><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
						<?php endif; ?>

						<!-- Card Heading -->
						<div class="cardheading text-center">
							<div style="width: 65%; margin: 0 auto">
								<h4 class="data"><?php echo $card->name; ?></h4>
							</div>
							<div>
								<p class="data"><?php echo $card->designation; ?></p>
							</div>
						</div>
					</div>
					<div class="card-body">
						<form>
							<ul>
								<li>
									<span>Address:</span>
									<p class="data"><?php echo $card->address; ?></p>
									<i class="fa fa-copy" aria-hidden="true"></i>
								</li>
								<li>
									<span>Mobile:</span>
									<p class="data"><?php echo $card->mobile; ?></p>
									<i class="fa fa-copy" aria-hidden="true"></i>
								</li>
								<li>
									<span>Email:</span>
									<p class="data"><a id="x" href="mailto:<?php echo $card->email; ?>"><?php echo $card->email; ?></a></p>
									<i class="fa fa-copy" onclick="copyToClipboard()"></i>
								</li>
								<li>
									<span>Website:</span>
									<p class="data"><a href="https://<?php echo $card->website; ?>" target="_empty"><?php echo $card->website; ?></a></p>
									<i class="fa fa-copy" aria-hidden="true"></i>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div> <!-- card End -->
			<?php endforeach ?>
		<?php endif; ?>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
				</div>
				<div class="modal-body">
					<?php echo form_open('card/update', ['class' => 'form-horizontal', 'id'=>'cardEditForm']); ?>
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'text', 'id'=>'name', 'name'=>'name','class'=>'form-control','placeholder'=>'Name', 'required'=>'required']); ?>
							<?php echo form_error('name'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Designation</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'text', 'id'=>'designation', 'name'=>'designation','class'=>'form-control','placeholder'=>'Designation', 'required'=>'required']); ?>
							<?php echo form_error('designation'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Company</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'text', 'id'=>'company', 'name'=>'company','class'=>'form-control','placeholder'=>'company']); ?>
							<?php echo form_error('company'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'text', 'id'=>'address', 'name'=>'address','class'=>'form-control','placeholder'=>'Address', 'required'=>'required']); ?>
							<?php echo form_error('address'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'email', 'id'=>'email', 'name'=>'email','class'=>'form-control','placeholder'=>'Email', 'required'=>'required']); ?>
							<?php echo form_error('email'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mobile No</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'text', 'id'=>'mobile', 'name'=>'mobile','class'=>'form-control','placeholder'=>'Mobile no', 'required'=>'required']); ?>
							<?php echo form_error('mobile'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Website</label>
						<div class="col-md-9">
							<?php echo form_input(['type'=>'text', 'id'=>'website', 'name'=>'website','class'=>'form-control','placeholder'=>'Website']); ?>
							<?php echo form_error('website'); ?>
						</div>
					</div>
					<?php echo form_close() ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="button" onclick="confirmEdit()" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- hidden div for exporting data  -->
	<div id="printArea" style="opacity: 0; height: 0px">
		<h3 class="text-center">Card List</h3>
		<hr>
		<br>
		<table id="myTable" class="table">
			<thead>
			<tr>
			    <th>Name</th>
			    <th>Designation</th>
			    <th>Address</th>
			    <th>Mobile</th>
			    <th>Email</th>
			    <th>Website</th>
			</tr>
		</thead>
		<tbody id="exportTableBody" ></tbody>
		</table>
	</div>

	<center><?php echo $links; ?></center>

	<script src="<?php echo base_url('/assets/js/export/jquery.min.js'); ?>"></script>
	<!-- export table library -->
	<script src="<?php echo base_url('/assets/js/export/FileSaver/FileSaver.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/js-xlsx/xlsx.core.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/jsPDF/jspdf.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/jsPDF-AutoTable/jspdf.plugin.autotable.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/tableExport.min.js'); ?>"></script>
	<script src="<?php echo base_url('/assets/js/export/printThis.js'); ?>"></script>

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
		<?php if($hasPermission) : ?>
			<script src="<?php echo base_url('assets/js/admin.js'); ?>"></script>
		<?php endif; ?>
		<script src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>
		<script>
			$(window).on('load', function() {
				$(this).impulse();
			});
			new WOW().init();
		</script>
		<script>
			var theToggle = document.getElementById('toggle');
			// based on Todd Motto functions
			// http://toddmotto.com/labs/reusable-js/
			// hasClass
			function hasClass(elem, className) {
			return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
			}
			// addClass
			function addClass(elem, className) {
				if (!hasClass(elem, className)) {
					elem.className += ' ' + className;
				}
			}
			// removeClass
			function removeClass(elem, className) {
				var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
				if (hasClass(elem, className)) {
					while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
						newClass = newClass.replace(' ' + className + ' ', ' ');
					}
					elem.className = newClass.replace(/^\s+|\s+$/g, '');
				}
			}
			// toggleClass
			function toggleClass(elem, className) {
				var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
				if (hasClass(elem, className)) {
					while (newClass.indexOf(" " + className + " ") >= 0 ) {
						newClass = newClass.replace( " " + className + " " , " " );
					}
					elem.className = newClass.replace(/^\s+|\s+$/g, '');
				} else {
					elem.className += ' ' + className;
				}
			}
			theToggle.onclick = function() {
				toggleClass(this, 'on');
				return false;
			}
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