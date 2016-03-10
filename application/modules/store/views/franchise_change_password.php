<form action="" method="post" id="login-form">
	<div class="login">
		<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/front_end/images/logo.jpg" class="mb-20"/></a>
		<br/>
		<a href="<?php echo base_url();?>"><img class="mb-60" src="<?php echo base_url();?>application/views/front_end/images/namebadge.png"></a>
		<div class="login-c">
			<label>
				<span style="width:210px">Franchise Centre Number:</span>
				<input type="text" name="fc_number" value="<?php echo isset($fc_number)?$fc_number:"";?>" style="width:150px" id="fc_number" />
			</label>
			<label>
				<span style="width:210px">Old Password:</span>
				<input type="password" name="old_password" value="" style="width:150px" id="old_password"/>
			</label>
			<label>
				<span style="width:210px">New Password:</span>
				<input type="password" name="new_password" value="" style="width:150px" id="new_password"/>
			</label>
			<label>
				<span style="width:210px">Confirm New Password:</span>
				<input type="password" name="confirm_new_password" value="" style="width:150px" id="confirm_new_password"/>
			</label>
			<?php echo ($error_messages!="")?"<p style='padding-left:18px'>".$error_messages."</p>":"";?>
			<label><span style="width:210px">&nbsp;</span><input type="submit" name="submit" value="Submit" id="" style="margin-left:6px"/></label>
		</div>
	</div>
</form>
<script>
	$(document).ready(function(){
		$('#login-form').submit(function(){
			var number = $('#fc_number');
			if(number.val() == '') {
				alert('Please enter Franchise Centre Number');
				number.focus();
				return false;
			}
			
			var old_pw = $('#old_password');
			if(old_pw.val() == '') {
				alert('Please enter old password');
				old_pw.focus();
				return false;
			}

			var new_pw = $('#new_password');
			if(new_pw.val() == '') {
				alert('Please enter new password');
				new_pw.focus();
				return false;
			}

			var cf_pw = $('#confirm_new_password');
			if(cf_pw.val() != new_pw.val()) {
				alert('The confirmation is not match');
				cf_pw.focus();
				cf_pw.select();
				return false;
			}
		});
	});
</script>
