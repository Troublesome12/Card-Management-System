
		<style>
			.container{
				margin-bottom: 20px;
			}
			.btn-primary{
				background: #547ee0;
				border-color: #547ee0;
			}
		</style>
        <div class="container">
        	<div class="row">
        		<?php echo form_open_multipart('email/upload'); ?>
        		<div class="col-sm-6 col-sm-offset-3">
        			<div class="form-group">
			            <h4>Import CSV/Excel file</h4>
			            <div class="input-group">
			            	<input type="text" class="form-control" placeholder="Select only xls,csv file" readonly>
			                <label class="input-group-btn">
			                    <span class="btn btn-primary">
			                        Browse&hellip; <input type="file" class="form-control" name="contact_file" accept=".csv,.xlsx,.xls" style="display: none;">
			                    </span>
			                </label>   
			            </div>
		            </div>
		            <div class="form-group">
		            	<input type="submit" class="btn btn-success pull-right" value="Upload">
		            </div>
		        </div>
		        <?php echo form_close(); ?>
        	</div>
        </div>
        <div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-6 col-sm-6 text-right">
						<div class="footer-bottom-text">
							<p>© 2016 Epic Group. All rights reserved. Developed by <a href="https://www.flickmax.net/" target="blank">Flick Max Ltd.</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="<?php echo base_url('/assets/js/export/jquery.min.js'); ?>"></script>
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
        	<?php if ( $this->session->message ) :?>
                swal({
                    title: "<?php echo $_SESSION['message']; ?>",
                    type: "<?php echo $_SESSION['type']; ?>",
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                },
                function(){
                	<?php if($_SESSION['type'] == 'success'):?>
                		window.href=base_url+"email/contact";
                	<?php endif?>
                });
            <?php endif; ?>
		</script>

		<script>
		    var base_url = "<?php echo base_url();?>";
		</script>
		<script>
			$(function() {

			  // We can attach the `fileselect` event to all file inputs on the page
			  $(document).on('change', ':file', function() {
			    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			    input.trigger('fileselect', [numFiles, label]);
			  });

			  // We can watch for our custom `fileselect` event like this
			  $(document).ready( function() {
			      $(':file').on('fileselect', function(event, numFiles, label) {

			          var input = $(this).parents('.input-group').find(':text'),
			              log = numFiles > 1 ? numFiles + ' files selected' : label;

			          if( input.length ) {
			              input.val(log);
			          } else {
			              if( log ) alert(log);
			          }

			      });
			  });
			  
			});
		</script>
    </body>
</html>