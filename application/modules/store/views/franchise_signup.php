<link rel="stylesheet" href="<?php echo base_url();?>application/views/front_end/css/validationEngine.jquery.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine.js" charset="utf-8"></script>
<form action="" method="post" id="signup-form">
	<div class="login">
		<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/front_end/images/logo.jpg" class="mb-20"/></a>
		<br/>
		<a href="<?php echo base_url();?>"><img class="mb-60" src="<?php echo base_url();?>application/views/front_end/images/namebadge.png"></a>
		<div class="fc-signup">
			<label>
				<span class="required">Centre Number:</span>
				<input type="text" name="number" id="number" class="validate[required, ajax[ajaxCheckAccountNumber]]"/>
			</label>
			<label>
				<span class="required">Password:</span>
				<input type="password" name="password" id="password" class="validate[required]"/>
			</label>
			<label>
				<span class="required">Confirm Password:</span>
				<input type="password" name="" id="confirm_password" class="validate[required, equals[password]]"/>
			</label>
			<label>
				<span>Name:</span>
				<input type="text" name="name" id=""/>
			</label>
			<label>
				<span class="required">Email:</span>
				<input type="text" name="email" id="email" class="validate[required, custom[email], ajax[ajaxCheckEmailExists]]"/>
			</label>
			<label>
				<span>Phone:</span>
				<input type="text" name="phone" id=""/>
			</label>
			<label>
				<span class="required">Mailing Address:</span>
				<input type="text" name="mailing_address" id="mailing_address" class="validate[required]"/>
			</label>
			<label>
				<span>Address Line 2:</span>
				<input type="text" name="line2" id=""/>
			</label>
			<label>
				<span class="required">City:</span>
				<input type="text" name="city" id="city" class="validate[required]"/>
			</label>
			<label>
				<span class="required">State:</span>
				<input type="text" name="state" id="state" class="validate[required]"/>
			</label>
			<label>
				<span class="required">Zip:</span>
				<input type="text" name="zip" id="zip" class="validate[required]"/>
			</label>
			<label><span>&nbsp;</span><input type="submit" name="submit" value="Submit" id=""/></label>
		</div>
	</div>
</form>
<script>
	$("#signup-form").validationEngine({
		promptPosition : "topRight", 
		ajaxFormValidationMethod: 'post',
		autoHidePrompt: true,
		autoHideDelay: 3000
	});
</script>
