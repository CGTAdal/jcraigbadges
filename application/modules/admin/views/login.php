<link rel="stylesheet" href="<?php echo base_url();?>application/views/back_end/css/login.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<div id="login">
<?php /*	<h1 id="title"><a href="">Name Badges Admin</a></h1> */ ?>
	<h1 id="title_admin_login">Name Badges Admin</h1>
	<div id="login-body" class="clearfix"> 
		<?php echo form_open('admin/login'); ?>
			<div class="content_front">
				<div class="pad">
					<div class="field">
						<label>Username:</label>
						<div class="">
							<span class="input">
								<?php 
									$data = array(
										'name'	=> "username",
										'value'	=> $this->input->post('username'),
										'class'	=> 'text'	
									);
									echo form_input($data);
								?>
							</span>
						</div>
					</div> <!-- .field -->
					<div class="field">
						<label>Password:</label>
						<div class="">
							<span class="input">
								<?php
									$data = array(
										'name'	=> "password",
										'class'	=> 'text'
									);
									echo form_password($data);
									//echo form_error('username');
								?>
							</span>
						</div>
					</div> <!-- .field -->
					<div class="field">
						<span class="label">&nbsp;</span>
						<div class=""><button type="submit" class="btn">Login</button></div>
					</div> <!-- .field -->
	        	</div>
	    	</div>
		<?php echo form_close();?>
	</div>
</div>
