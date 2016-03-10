<div class="order-new clb" id="enter_names">
	<input type="hidden" value="1" id="current_input_boxes_number"/>
	<h3 class="title">Enter Name: <?php echo $description!=""?"($description)":$description;?></h3>
	<div id="input_boxes">
		<div class="order-box clb input_box" value="1">
			<h3>Badge 1</h3>
			<div style="padding-left:15px;">
				<label>
					<span >First name <font style="color:red">only</font>:</span>				
					<input type="text" class="first_name" size="50" value="" name="first_name_1" id="">				
				</label>
				<?php if(isset($license)) {?>
					<label>
						<span style="width:285px;margin:0px">License # (for required states only):</span>				
						<input type="text" class="license" value="" name="license_1" style="width:150px">				
					</label>
				<?php }?>
				<?php if(isset($title_options)) {?>
					<label>
						<span>Title:</span>
						<?php
							echo form_dropdown("title_1", $title_options,"","id='title_1' style='width:295px'");
						?>
					</label>
				<?php }?>
				<?php if(isset($service_year)) {?>
					<label>
						<span>Years Of Service:</span>
						<?php
							echo form_dropdown("years_of_service_1", $service_year,"","id='years_of_service_1' style='width:200px;padding:4px'");
						?>
					</label>
				<?php }?>
				<div class="mag-pin">
					<label class="lblRadioCheckbox">
						<input type="radio" value="Magnetic" name="fastener_1" checked="checked">Magnetic
					</label>
					<span class="split">&nbsp;</span>
					<label class="lblRadioCheckbox">
						<input type="radio" value="Pin" name="fastener_1">Pin
					</label>
					<div class="order-des">pacemakers: caution with magnet</div>
				</div>
				<!-- 
				<div class="order-yesno fll">
					<strong>Hablo español:</strong>
					<span style="width:auto;" class="split"></span>
					<label class="lblRadioCheckbox order-box-ss">
						<input type="radio" value="No" name="speaks_spanish_1" checked="checked">No
					</label>
					<span style="width:auto;" class="split"></span>
					<label class="lblRadioCheckbox order-box-ss">
						<input type="radio" value="Yes" name="speaks_spanish_1">Yes
					</label>
					<div class="order-des">see restrictions / disclaimer below.</div>
				</div>
				-->
				<input type="hidden" id="style_1" value="<?php echo $style;?>" />
				<?php if(isset($title)) {?><input type="hidden" id="title_1" value="<?php echo $title;?>" /><?php }?>
			</div>
		</div>
	</div>
	<div class="clb txtC mb-5">&nbsp;</div>
	<div class="clb txtC mb-40"><a href="javascript: void(0)" class="add-another" value="<?php echo $type;?>" id="add_more">Add Another Name</a></div>
	<div class="clb txtC mb-15"><input type="button" value="Add Badges to Order" id="add_names"></div>
</div>
<!-- 
<div class="mota clb">
	<h3 >For Team Members That Can Speak Spanish:</h3>
		<p style="font-size:12px; margin-top:10px;">
			An option is being provideded to allow a
			team member who is bilingual, able to speak both English and Spanish, to indicate this ability
			on their name badge. Utilizing the "hablo español" title is <strong><i>optional</i></strong> to the team member, and
			should be based on the team members' comfort level to speak and communicate in Spanish.
			<strong><i>There should be no pressure placed on the team member to have this option utilized.</i></strong>
		</p>
</div>
-->
