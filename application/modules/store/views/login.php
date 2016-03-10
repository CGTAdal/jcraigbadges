<form action="" method="post" id="login-form">
	<div class="login">
		<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/front_end/images/logo.jpg" class="mb-20"/></a>
		<br/>
		<a href="<?php echo base_url();?>"><img class="mb-60" src="<?php echo base_url();?>application/views/front_end/images/namebadge.png"></a>
		<div class="login-c">
			<label>
				<span>Centre Number:</span>
				<?php 
					$data = array(
								'name'	=> "store_number",
								'value'	=> $this->input->post('store_number'),
								'id'	=> "store_number"
							);
					echo form_input($data);
					echo form_error('store_number');
					echo ($error_messages!="")?"<p>".$error_messages."</p>":"";
				?>
			</label>
			<p id="login-message"></p>
			<label><span>&nbsp;</span><input type="submit" name="submit" value="Submit" id=""/></label>
			<label style="padding-left:10px;font-size:14px">Market Directors: <a href="<?php echo base_url();?>store/market_login">Click Here To Login</a></label>
			<label style="padding-left:10px;font-size:14px">Franchises: <a href="<?php echo base_url();?>store/franchise_login">Click Here To Login</a></label>
		</div>
	</div>
</form>
