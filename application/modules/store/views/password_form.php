<a href="javascript:void(0);" id="close_popup" style="float:right">Close</a>
<div id="enter-pw-box">
	<h3 class="title txtC mb-30">Please enter your password</h3>
	<input type="password" value="" id="md_password" /><br/>
	<p id="error-login-message"></p>
	<input type="button" value="Submit" id="md_submit" style="margin:10px 0px;"/><br/>
</div>
<div id="change-pw-box" style="display:none">
	<h3 class="title txtC mb-30">Reset password</h3>
	Old Password<br/><input type="password" value="" id="old_pw" /><br/><br/>
	New password<br/><input type="password" value="" id="new_pw" /><br/><br/>
	Confirm new password<br/><input type="password" value="" id="confirm_new_pw"/><br/><br/>
	<p id="change-pw-message"></p>
	<input type="button" value="Submit" id="cpw_submit" style="padding:4px;margin:10px 0px;"/><br/>
</div>
<div id="action-links">
	<div>
		<a href="javascript: void(0);" id="request_pw">Request Lost Password</a>
		<p id="request-message"></p>		
	</div>
	<div><a href="javascript: void(0);" id="change-pw">Change Password</a></div>
</div>
<input type="hidden" value="<?php echo $store_number;?>" id="store_number" />
<script>
	$('#md_submit').click(function(){
		var store_number = $('#store_number').val();
		var password 	 = $('#md_password').val();

		if(password=="") {
			$('#error-login-message').html('Please enter password');
			return;
		}
		$.post("<?php echo base_url();?>store/storeajax/checkDirectorLogin",
				{store_number: store_number, password: password},
				function(data){
					if(data=='1') {
						window.location="<?php echo base_url();?>order/select";
						$('#popup5').hide();
					} else {
						$('#error-login-message').html('The password is incorrect.');
					}
				}
		);
	});

	$('#request_pw').click(function(){
		$.post("<?php echo base_url();?>store/storeajax/resetPassword",
			{store_number: "<?php echo $store_number;?>"},
			function(data){
				if(data=='1') {
					$('#request-message').html('A new password was send to your email. Please check it.');
				} else {
					$('#request-message').html("This function does not work now. Please try again later.");
				}
			}
		);
	});

	$('#change-pw').click(function(){
		$('#enter-pw-box').hide();
		$('#action-links').hide();
		$('#change-pw-box').show();
	});

	$('#cpw_submit').click(function(){
		var old_pw = $('#old_pw').val();
		if(old_pw=="") {
			$('#change-pw-message').html('Please enter old password');
			$('#old_pw').focus();
			return;
		}

		var new_pw = $('#new_pw').val();
		if(new_pw=="") {
			$('#change-pw-message').html('Please enter new password');
			$('#new_pw').focus();
			return;
		}
		
		var confirm_new_pw = $('#confirm_new_pw').val();

		if(new_pw!=confirm_new_pw) {
			$('#change-pw-message').html('New password and confirm password don’t match');
			return;
		}

		$.post("<?php echo base_url();?>store/storeajax/changePassword",
			{store_number: "<?php echo $store_number;?>", old_pw: old_pw, new_pw: new_pw},
			function(data){
				if(data=='1') {
					new_html = '<h3 class="title txtC mb-30">Reset password</h3>';
					new_html += '<p style="font-weight:bold">Password was updated successfully</p>';
					$('#change-pw-box').html(new_html);
				} else {
					$('#change-pw-message').html('The password is incorrect.');
				}
			}	
		);
		
	});
</script>