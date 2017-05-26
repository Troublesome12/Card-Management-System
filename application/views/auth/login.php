<!DOCTYPE html>
<html>
<head>
	<title>Card | Login</title>
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- Raleway font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,800" rel="stylesheet">
	<!-- Open Sans font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800" rel="stylesheet">
	<!-- Great Vibes font -->
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body>
	
	<div class="logo">
		<img src="<?php echo base_url('assets/images/logo.png'); ?>" class="logo img-responsive">
	</div>
	<div class="login-block">
		<?php echo form_open('auth/login', ['class' => 'form-horizontal']); ?>
		    <h1>Login</h1>
		    <div class="form-custom">
		    	<?php echo form_input(['type'=>'email','name'=>'email','placeholder'=>'Email', 'value'=>set_value('email'), 'id'=>'email', 'required'=>'required']); ?>
				<?php echo form_error('email'); ?>
			</div>
			<div class="form-custom">
			<?php echo form_input(['type'=>'password','name'=>'password','placeholder'=>'Password', 'value'=>set_value('password'), 'id'=>'password' , 'required'=>'required']); ?>
			<?php echo form_error('password'); ?>
		    </div>
		    <?php echo form_submit(['value'=>'Submit', 'class' => 'btn btn-submit']); ?>
	    <?php echo form_close() ?>
		
		<div class="error-message">
			<?php if($this->session->flashdata('error')): ?>
				<span class="text-danger">
					<?php echo $this->session->flashdata('error'); ?>
				</span>
			<?php endif ?>
		</div>
	</div>
</body>
</html>