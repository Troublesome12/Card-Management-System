<!-- Sidebar Navigation Start -->
<!-- data-spy="affix" data-offset-bottom="445" -->

<div class="left-sidebar">
	<nav class="navbar navbar-default navbar-sidebar  bootsnav ">
		<div class="container">
			<!-- Start Header Navigation -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
				<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand"><img src="<?php echo base_url('assets/images/'.$settings->logo); ?>" class="logo img-responsive" alt=""></a>
			</div>
			<!-- End Header Navigation -->
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse " id="navbar-menu">
				<!-- Start Menu -->
				<ul class="nav navbar-nav " data-in="fadeInDown" data-out="fadeOutUp">
					<li <?php if($active == 'Home') echo "class=active"; ?>><a href="<?php echo base_url('user'); ?>">Home</a></li>
					<?php if($user->isAdmin) : ?>
						<li <?php if($active == 'Settings') echo "class=active"; ?>><a href="<?php echo base_url('user/settings'); ?>">Settings</a></li>
						<li <?php if($active == 'Log') echo "class=active"; ?>><a href="<?php echo base_url('user/log'); ?>">Log</a></li>
					<?php endif; ?>
					<hr>

					<li <?php if($active == 'Card List') echo "class=active"; ?>><a href="<?php echo base_url('card'); ?>">Card List</a></li>
					<?php if($user->isAdmin) : ?>
						<li <?php if($active == 'Add Card') echo "class=active"; ?>><a href="<?php echo base_url('card/create'); ?>">Add Card</a></li>
						<li <?php if($active == 'Import Card') echo "class=active"; ?>><a href="<?php echo base_url('card/upload'); ?>">Import Card</a></li>
					<?php endif; ?>
					<li <?php if($active == 'Card Template') echo "class=active"; ?>><a href="<?php echo base_url('card/template'); ?>">Template</a></li>
					<hr>

					<li <?php if($active == 'Send Email') echo "class=active"; ?>><a href="<?php echo base_url('email'); ?>">Send Email</a></li>
					<?php if($user->isAdmin) : ?>
						<li <?php if($active == 'Manage Email') echo "class=active"; ?>><a href="<?php echo base_url('email/manage'); ?>">Manage Email</a></li>
					<?php endif; ?>
					<li <?php if($active == 'Template') echo "class=active"; ?>><a href="<?php echo base_url('email/template'); ?>">Template</a></li>
					<li <?php if($active == 'Contacts') echo "class=active"; ?>><a href="<?php echo base_url('email/contact'); ?>">Contacts</a></li>
					<li <?php if($active == 'Groups') echo "class=active"; ?>><a href="<?php echo base_url('email/group'); ?>">Groups</a></li>	
				</ul>
				<!-- End Menu -->
				
				<!-- Start Share -->
				<div class="social">
					<ul>
						<li class="facebook"><a href="<?php echo $settings->facebook_link; ?>"><i class="fa fa-facebook"></i></a></li>
						<li class="twitter"><a href="<?php echo $settings->twitter_link; ?>"><i class="fa fa-twitter"></i></a></li>
						<li class="pinterest"><a href="<?php echo $settings->linkedin_link; ?>"><i class="fa fa-linkedin"></i></a></li>
						<li class="gplus"><a href="<?php echo $settings->google_plus_link; ?>"><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
				<!-- End Share -->
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
</div>

<!-- Sidebar Navigation End -->

<div class="main-body">
	<div class="top-nav">
		<div class="container">
			<div class="row">
				<div class="nav-contain">
					<div class="pull-right">
						<div class="top-right-menu">
							<ul class="right-topbar">
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<?php if($user->image != null) : ?>
										<img class="img-circle" src="<?php echo base_url('assets/images/'.$user->image); ?>">
									<?php else : ?>
										<img class="img-circle" src="<?php echo base_url('assets/images/default.jpg'); ?>">
									<?php endif; ?>
										<?php echo $user->name ?> &nbsp; <span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo base_url('user/accountSettings'); ?>"><i class="fa fa-cog"></i> Account Settings</a></li>
										<li><a href="<?php echo base_url('user/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
									</ul>
								</li>	
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>