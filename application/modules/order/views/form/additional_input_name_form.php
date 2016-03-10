<div class="order-box clb input_box" value="<?php echo $number;?>">
	<h3>Badge <?php echo $number;?> <a class="remove_input_box" href="javascript: void(0)">(remove)</a></h3>
	<div style="padding-left:5px;">
		<div style="padding-left:10px;">
				<label>
					<span>First name <font style="color:red">only</font>:</span>
					<input type="text" class="first_name" size="50" value="" name="first_name_<?php echo $number;?>" id="">				
				</label>
				<?php if(isset($license)) {?>
					<label>
						<span style="width:285px;margin:0px">License # (for required states only):</span>				
						<input type="text" class="license" value="" name="license_<?php echo $number;?>" style="width:150px">				
					</label>
				<?php }?>
				<?php if(isset($title_options)) {?>
					<label>
						<span>Title:</span>
						<?php							
							echo form_dropdown("title_$number", $title_options,"","id='title_$number'");
						?>
					</label>
				<?php }?>
				<?php if(isset($service_year)) {?>
					<label>
						<span>Years Of Service:</span>
						<?php
							echo form_dropdown("years_of_service_$number", $service_year,"","id='years_of_service_$number' style='width:200px;padding:4px'");
						?>
					</label>
				<?php }?>
				<div class="mag-pin">
					<label class="lblRadioCheckbox">
						<input type="radio" value="Magnetic" name="fastener_<?php echo $number;?>" checked="checked">Magnetic
					</label>
					<span class="split">&nbsp;</span>
					<label class="lblRadioCheckbox">
						<input type="radio" value="Pin" name="fastener_<?php echo $number;?>">Pin
					</label>
					<div class="order-des">pacemakers: caution with magnet</div>
				</div>
				<!-- 
				<div class="order-yesno fll">
					<strong>Hablo español:</strong>
					<span style="width:auto;" class="split"></span>
					<label class="lblRadioCheckbox order-box-ss">
						<input type="radio" value="No" name="speaks_spanish_<?php echo $number;?>" checked="checked">No
					</label>
					<span style="width:auto;" class="split"></span>
					<label class="lblRadioCheckbox order-box-ss">
						<input type="radio" value="Yes" name="speaks_spanish_<?php echo $number;?>">Yes
					</label>
					<div class="order-des">see restrictions / disclaimer below.</div>
				</div>
				-->
				<input type="hidden" id="style_<?php echo $number;?>" value="<?php echo $style;?>" />
				<?php if(isset($title)) {?><input type="hidden" id="title_<?php echo $number;?>" value="<?php echo $title;?>" /><?php }?>
			</div>
		</div>
</div>