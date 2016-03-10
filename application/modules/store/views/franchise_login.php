<form action="" method="post" id="login-form">
	<div class="login">
		<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/front_end/images/logo.jpg" class="mb-20"/></a>
		<br/>
		<a href="<?php echo base_url();?>"><img class="mb-60" src="<?php echo base_url();?>application/views/front_end/images/namebadge.png"></a>
		<div class="login-c">
			<label>
				<span>Franchise Centre Number:</span>
				<?php 
					$data = array(
								'name'	=> "franchise_number",
								'value'	=> $this->input->post('franchise_number'),
								'id'	=> "franchise_number",
								'style'	=> ""
							);
					echo form_input($data);
					echo form_error('franchise_number');
				?>
			</label>
			<label>
				<span>Password:</span>
				<input type="password" name="password">
			</label>
			<?php echo ($error_messages!="")?"<p>".$error_messages."</p>":"";?>
			<label><span>&nbsp;</span><input type="submit" name="submit" value="Submit" id=""/></label>
			<label style="padding-left:10px;font-size:14px"><a href="<?php echo base_url();?>store/franchise_signup">Create New Account</a></label>
			<label style="padding-left:10px;font-size:14px">
				<a href="javascript: void(0);" id="request_lost_pw">Request Lost Password</a>
				<br/>
				<font style="color:red;" id="reset_message"></font>
			</label>
			<label style="padding-left:10px;font-size:14px"><a href="<?php echo base_url();?>store/franchise_change_password">Change Password</a></label>
		</div>
	</div>
</form>
<script>
	$(document).ready(function(){
		$('#request_lost_pw').click(function(){
			var fc_number = $('#franchise_number');
			if(fc_number.val() == "") {
				alert('Please enter Franchise Center Number');
				fc_number.focus();
				return false;
			}

			$.post("<?php echo base_url();?>store/storeajax/resetPassword",
				{store_number: fc_number.val(), store_role: 3},
				function(data){
					$('#reset_message').html(data);
				}
			);
		});
	});
</script>