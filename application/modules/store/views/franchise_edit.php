<link rel="stylesheet" href="<?php echo base_url();?>application/views/front_end/css/validationEngine.jquery.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine.js" charset="utf-8"></script>
<div class="main clb">
	<div class="main-left-no-border fll" id="main-left">
		<div class="fc-signup" style="margin-top:30px">
			<form action="" method="post" id="edit-account" >
				<label>
					<span class="required">Email:</span>
					<?php echo $store->store_email;?>
				</label>
				<label>
					<span>Name:</span>
					<input type="text" name="name" id="" value="<?php echo $store->store_location_name;?>"/>
				</label>
				<label>
					<span>Phone:</span>
					<input type="text" name="phone" id=""/>
				</label>
				<label>
					<span class="required">Mailing Address:</span>
					<input type="text" name="mailing_address" id="mailing_address" class="validate[required]" value="<?php echo $store->store_address;?>"/>
				</label>
				<label>
					<span>Address Line 2:</span>
					<input type="text" name="line2" id="" value="<?php echo $store->store_address_2;?>"/>
				</label>
				<label>
					<span class="required">City:</span>
					<input type="text" name="city" id="city" class="validate[required]" value="<?php echo $store->store_city;?>"/>
				</label>
				<label>
					<span class="required">State:</span>
					<input type="text" name="state" id="state" class="validate[required]" value="<?php echo $store->store_state;?>"/>
				</label>
				<label>
					<span class="required">Zip:</span>
					<input type="text" name="zip" id="zip" class="validate[required]" value="<?php echo $store->store_zip;?>"/>
				</label>
				<input type="hidden" id="store_id" value="<?php echo $store->store_id;?>" />
				<label><span>&nbsp;</span><input type="submit" name="submit" value="Submit" id=""/></label>
			</form>
		</div>
	</div>
</div>
<script>
	$("#edit-account").validationEngine({
		promptPosition : "topRight", 
		ajaxFormValidationMethod: 'post',
		autoHidePrompt: true,
		autoHideDelay: 3000
	});
</script>