

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/component.css'); ?>">

<!-- remove this if you use Modernizr -->
		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

<div class="container">
	<center>
		<h5 style="margin-top: 50px;">Download sample CSV file</h5>
		<a href="<?php echo base_url('assets/files/sample/sampleCard.csv'); ?>" class="btn btn-success" style="text">Download</a>
		<?php echo form_open_multipart('card/import'); ?>
		
			<h5 style="margin-top: 50px;">Import CSV file</h5>
			<div class="content">
				<div class="box">
		            <?php echo form_upload(['name'=>'file','class'=>'inputfile inputfile-5', 'accept'=>'.csv', 'id'=>'file-6', 'data-multiple-caption'=>'{count} files selected']); ?>
					<label for="file-6"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span></span></label>
				</div>
				<input type="submit" class="btn btn-info" value="Upload">
	        </div>
	    <?php echo form_close(); ?>
	</center>
</div>

<script src="<?php echo base_url('assets/js/custom-file-input.js'); ?>"></script>
