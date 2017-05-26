		</div> <!-- End of main-body -->	
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-6 col-sm-6 text-right">
						<div class="footer-bottom-text">
							<p>© <?php echo $settings->copyright; ?>. All rights reserved.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="<?php echo base_url('assets/js/jquery-3.1.1.min.js'); ?>"></script>
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
		<script src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.email-autocomplete.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/customEmail.js'); ?>"></script>
	    <script>
	        $('.ms').select2({ width: '100%' });
	    </script>

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

		<script>
			$("input[type='email']").emailautocomplete({
		        domains: ["flickmax.net"] //add your own domains
	      	});
		</script>
	</body>
</html>