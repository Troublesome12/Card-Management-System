		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/home-users.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/home.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fullcalendar.min.css'); ?>">
		<div class="container">

			<br>
			<div class="col-md-8">
				<div class="portlet light">
					<div id="calendar"></div>
				</div>
			</div>

			<div style="margin-top: 100px;">
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-blue panel-widget ">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<i class="fa fa-id-card fa-3x"></i>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $cardCount; ?></div>
								<div class="text-muted">Cards</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-orange panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<i class="fa fa-envelope fa-3x"></i>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $contactCount; ?></div>
								<div class="text-muted">Contacts</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-teal panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<i class="fa fa-user fa-3x"></i>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $userCount; ?></div>
								<div class="text-muted">Users</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-red panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<i class="fa fa-file fa-3x"></i>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $viewCount; ?></div>
								<div class="text-muted">Page Views</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="user">
				<div class="col-lg-12 col-xs-12 col-sm-12">
	                <div class="portlet light ">
	                    <div class="portlet-title">
	                        <div class="caption">
	                            <i class="icon-bubble font-dark hide"></i>
	                            <span class="caption-subject font-hide bold uppercase">Users</span>
	                        </div>
	                    </div>

	                    <div class="portlet-body">
	                        <div class="row">
	                        	<?php foreach ($users as $user) : ?>
	                            <div class="col-md-4">
	                                <!--begin: widget 1-1 -->
	                                <div class="mt-widget-1">
	                                    <div class="mt-img">
	                                    <?php if($user->image) : ?>
	                                        <img class="img-circle image" src="<?php echo base_url('assets/images/'.$user->image);?>"> </div>
	                                    <?php else : ?>
											<img class="img-circle image" src="<?php echo base_url('assets/images/default.jpg');?>"> </div>
	                                    <?php endif; ?>

	                                    <div class="mt-body">
	                                        <h3 class="mt-username"><?php echo $user->name; ?></h3>
	                                        <p class="mt-user-title"><?php echo $user->email; ?></p>
	                                        <div class="mt-stats">
	                                            <div class="btn-group btn-group btn-group-justified">
	                                                <a href="javascript:;" class="btn font-red">
	                                                    <i class="fa fa-mail-reply-all"></i> 30 </a>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <!--end: widget 1-1 -->
	                            </div>
	                        	<?php endforeach; ?>
	                        </div>
	                    </div>
	                </div>
	            </div>
			</div>
		</div><!--/. container -->
		
		<!-- Modal For Adding Events -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form class="form-horizontal" method="POST" action="<?php echo base_url('user/addEvent');?>">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Add Event</h4>
						</div>
						
						<div class="modal-body">
							<div class="form-group">
								<label for="start" class="col-sm-4 control-label">Title </label>
								<div class="col-sm-8">
									<input type="text" name="title" class="form-control" id="title" required>
								</div>
							</div>

							<div class="form-group">
								<label for="start" class="col-sm-4 control-label">Start date</label>
								<div class="col-sm-8">
									<input type="text" name="start" class="form-control datepicker" id="start" >
								</div>
							</div>
		
							<div class="form-group">
								<label for="end" class="col-sm-4 control-label">End date</label>
								<div class="col-sm-8">
									<input type="text" name="end" class="form-control datepicker" id="end" >
								</div>
							</div>
							
							<div class="form-group">
								<label for="start" class="col-sm-4 control-label">Description </label>
								<div class="col-sm-8">
									<textarea name="description" class="form-control" id="description" ></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="color" class="col-sm-4 control-label">Color </label>
								<div class="col-sm-8">
									<select name="color" class="form-control" id="color">
										<option value="#364958" style="color:#364958;">Black</option>
										<option value="#DD6B55" style="color:#DD6B55;">Red</option>
										<option value="#539987" style="color:#539987;">Green</option>
										<option value="#3A87AD" style="color:#3A87AD;">Blue</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Modal For Editing Events -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myEditModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form class="form-horizontal" method="POST" action="<?php echo base_url('user/editEvent');?>">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myEditModalLabel">Edit Event</h4>
						</div>
		
						<div class="modal-body">                              
							<input type="hidden" id="id" name="id">
							
							<div class="form-group">
								<label for="start" class="col-sm-4 control-label">Title </label>
								<div class="col-sm-8">
									<input type="text" name="title" class="form-control" id="edit-title" required>
								</div>
							</div>                   
							
							<div class="form-group">
								<label class="col-sm-4 control-label">Start date</label>
								<div class="col-sm-8">
									<input type="text" name="start" class="form-control datepicker" id="edit-start" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label">End date</label>
								<div class="col-sm-8">
									<input type="text" name="end" class="form-control datepicker" id="edit-end" >
								</div>
							</div>

							<div class="form-group">
								<label for="start" class="col-sm-4 control-label">Description </label>
								<div class="col-sm-8">
									<textarea name="description" class="form-control" id="edit-description" ></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label for="color" class="col-sm-4 control-label">Color </label>
							<div class="col-sm-8">
								<select name="color" class="form-control" id="edit-color">
									<option value="#364958" style="color:#364958;">Black</option>
									<option value="#DD6B55" style="color:#DD6B55;">Red</option>
									<option value="#539987" style="color:#539987;">Green</option>
									<option value="#3A87AD" style="color:#3A87AD;">Blue</option>
								</select>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
							<button class="btn btn-warning"><a href="javascript:void(0);" class="hrefCompareDelete" style="color:#fff;">Delete</a></button>
						</div>
					</form>
				</div>
			</div>
		</div>

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
	
	<script src="<?php echo base_url('assets/js/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/export/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/fullcalendar.min.js'); ?>"></script>
	 <script>
	 	$('.datepicker').datepicker({

	 	});
	 </script>
	<style>
		.tooltip {
			font-size: 12px;
			z-index: 1000;
			position: relative;
		}
	</style>
	<script>
	    var base_url = "<?php echo base_url();?>";
	</script>
	
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(document).ready(function() {	
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next,today',
					center: 'title',
					right: 'month,basicWeek,list'
				},
				navLinks: true, // can click day/week names to navigate views
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				selectable: true,
				selectHelper: true,
				select: function(start, end) {
					$('#ModalAdd #start').val(moment(start).format('D-M-Y'));
			        $('#ModalAdd #end').val(moment(end).subtract(1,'days').format('D-M-Y'));
			        $('#ModalAdd').modal('show');
				},
				eventRender: function(event, element) {
					if(event.description) {
						element.find('.fc-title').append( "<br> <i class='fa fa-sticky-note'>&nbsp;</i>  " +event.description);
			        }
			        element.bind('dblclick', function() {
						$('#ModalEdit #id').val(event.id);
						$('#ModalEdit #edit-start').val(event.startformet);
						$('#ModalEdit #edit-end').val(event.endformet);
						$('#ModalEdit #edit-title').val(event.title);
						$('#ModalEdit #edit-description').val(event.description);
						$('#ModalEdit #edit-color').val(event.color);
						$('.hrefCompareDelete').prop('href', base_url+'user/eventDelete/'+event.id);
						$('#ModalEdit').modal('show');
					});
				},
				eventMouseover: function(event, element) {
				    var tooltip = '<div class="tooltipevent"><div class="tooltipevent_title">' + event.title + '</div><div class="tooltipevent_description"> '+ 
                                          '<span>Description: </span>' + event.description 
                                        + '<br><span>Start Time : </span>' +  event.startformet
                                        + '<br><span>End Time : </span>' +  event.endformet 
                                        + '</div></div>';
    				
    				$('body').append(tooltip);

				    $(this).mouseover(function(e) {
				        $(this).css('z-index', 1000);
				        $('.tooltipevent').fadeIn('500');
        				$('.tooltipevent').fadeTo('10', 1.9);
				    }).mousemove(function(e) {
				        $('.tooltipevent').css('top', e.pageY + 10);
				        $('.tooltipevent').css('left', e.pageX + 20);
				    });
				}, 
				eventMouseout: function(event, element) {
				    $(this).css('z-index', 8);
				    $('.tooltipevent').remove();
				},
				eventDrop: function(event, delta, revertFunc) { // si changement de position
			       	swal({
		                title: "Are you sure?",
		                text: "Do you really want to edit event?",
		                type: "info",
		                showCancelButton: true,
		                confirmButtonColor: "#DD6B55",
		                confirmButtonText: "Yes",
		                cancelButtonText: "No",
		                closeOnConfirm: true
		            },
		            function(isConfirm){
		                if (isConfirm) {
		                	edit(event);
		                } else {
		            		revertFunc();
		        		}
		            });
		       	},
		       	<?php if(isset($events)) : ?>
		       	events: [
					<?php foreach($events as $event): 

						$start = explode(" ", $event->start);
						$end = explode(" ", $event->end);
						if($start[1] == '00:00:00'){
							$start = $start[0];
						}else{
							$start = $event->start;
						}

						if($end[1] == '00:00:00'){
							$original_end=$end[0];
							$end = date("Y-m-d",strtotime("$end[0]+1 day"));
						} else {  
							$original_end=$event->end;
							$end = date("Y-m-d",strtotime("$event->end+1 day"));
						}

						$starts = date( 'Y-m-d', strtotime($event->start));
						$ends = date( 'Y-m-d', strtotime($original_end));

						?>
						{
							id: '<?php echo $event->id; ?>',
							startformet: '<?php echo $starts; ?>',
							endformet: '<?php echo $ends; ?>',
							start: '<?php echo $start; ?>',
							end: '<?php echo $end; ?>',
							title: '<?php echo $event->title; ?>',
							description: '<?php echo $event->description; ?>',
							color: '<?php echo $event->color; ?>',
							BASE_URL2:'<?php echo base_url(); ?>'
					},
					<?php endforeach; ?>
					]
				<?php endif; ?>
			});

			function edit(event){
				start = event.start.format('D-M-Y');
				if(event.end){
					end = event.end.format('D-M-Y');
				}else{
					end = start;
				}
				id =  event.id;
				Event = [];
				Event[0] = id;
				Event[1] = start;
				Event[2] = end;

				$.ajax({
				url : base_url + 'user/editEventDate',
				type: "POST",
				data: {event : Event},
					success: function() {
						swal({
                            title: "The event has been edited successfully",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false,
                            html: true
                        });
					}
				});
			}
		});
	</script>
	
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
		$("input[type='email']").emailautocomplete({
	        domains: ["flickmax.net"] //add your own domains
      	});
	</script>

</body>
</html>