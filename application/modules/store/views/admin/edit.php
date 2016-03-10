<div style="min-height: 300px;" class="portlet x12">
	<div class="portlet-header"><h4>Edit Account</h4></div>			
		<div class="portlet-content" >		
			<form class="form label-inline" id="form_store_edit" method="post" action="<?php echo base_url();?>admin/store/edit/<?echo $store->store_id; ?>">
				<div class="field">
					<label>Type </label> 
					<b><?php echo ($store->store_role==1)?"Store":($store->store_role==2)?"Market Director":"Franchise";?></b>
				</div>
				<div class="field">
					<label>Unit</label> 
					<b><?php echo $store->store_number;?></b>
				</div>
				<div class="field">
					<label>Express Account</label> 
					<input type="text" class="medium" size="50" name="store_express" id="store_express" value="<?php echo (isset($store->store_express))?$store->store_express:"";?>">
				</div>	
				<div class="field">
					<label>Ground Account # </label> 
					<input type="text" class="medium" size="50" name="store_ground" id="store_ground" value="<?php echo (isset($store->store_ground))?$store->store_ground:"";?>">
				</div>	
				<div class="field">
					<label>Location name</label> 
					<input type="text" class="medium" size="50" name="store_location_name" id="store_location_name" value="<?php echo (isset($store->store_location_name))?$store->store_location_name:"";?>">
				</div>				
				<div class="field">
					<label class="required">Address 1</label> 
					<input type="text" class="medium validate[required]" size="50" name="store_address" id="store_address" value="<?php echo (isset($store->store_address))?$store->store_address:"";?>">
				</div>
				<div class="field">
					<label>Address 2</label> 
					<input type="text" class="medium" size="50" name="store_address_2" id="store_address_2" value="<?php echo (isset($store->store_address_2))?$store->store_address_2:"";?>">
				</div>
				<div class="field">
					<label  class="required">City </label> 
					<input type="text" class="medium validate[required]" size="50" name="store_city" id="store_city" value="<?php echo (isset($store->store_city))?$store->store_city:"";?>">
				</div>					
				<div class="field">
					<label  class="required">State </label> 
					<input type="text" class="large validate[required]" size="50" name="store_state" id="store_state" value="<?php echo (isset($store->store_state))?$store->store_state:"";?>">
				</div>
				<div class="field">
					<label  class="required">Zip </label> 
					<input type="text" class="large validate[required]" size="50" name="store_zip" id="store_zip" value="<?php echo (isset($store->store_zip))?$store->store_zip:"";?>">
				</div>				
				<div class="field">
					<label for="address2">Contact </label> 
					<input type="text" class="large" size="50" name="store_contact" id="store_contact" value="<?php echo (isset($store->store_contact))?$store->store_contact:"";?>">
				</div>				
				<div class="field">
					<label for="address2">Phone </label> 
					<?php						 
						$data = array(
								'name'	=> "store_phone",
								'id'	=> "store_phone",
								'value'	=> (isset($store->store_phone))?$store->store_phone:"",
								'class' => 'medium',
								'size'	=> '50'
							);
						echo form_input($data);						
						echo ($error_phone!="")?"<p>".$error_phone."</p>":"";
					?>
				</div>
				<?php if($store->store_role != 1) {?>				
					<div class="field">
						<label  class="required">Email </label> 
						<?php						 
							$data = array(
									'name'	=> "store_email",
									'id'	=> "store_email",
									'value'	=>  (isset($store->store_email))?$store->store_email:"",
									'class' => 'medium validate[required, custom[email], ajax[ajaxCheckEmailExists]]',
									'size'	=> '50'
								);
							echo form_input($data);						
							echo ($error_email!="")?"<p>".$error_email."</p>":"";
						?>
					</div>
				<?php }?>
				<?php if($store->store_role != 1) {?>				
					<div class="field">
						<label>Password</label> 
						<?php						 
							$data = array(
									'name'	=> "store_password",
									'id'	=> "store_password",
									'class' => 'medium',
									'size'	=> '50'
								);
							echo form_input($data);						
						?>
					</div>
				<?php }?>
				<?php if($store->store_role==1) {?>
					<div class="field">
						<label>Assigned To</label>
						<select name="assigned_to">
							<option value=""></option>
							<?php foreach($market_directories as $md) {?>
								<option value="<?php echo $md->store_id;?>" <?php echo ($store->store_assigned==$md->store_id)?"selected":"";?>><?php echo $md->store_number;?></option>
							<?php }?>
						</select>
					</div>
				<?php }?>
				<div class="field"><?php echo ($error_full!="")?"<p>".$error_full."</p>":"";?></div>
				<input type="hidden" name="store_role" id="store_role" value="<?php echo (isset($store->store_role))?$store->store_role:"";?>">
				<input type="hidden" name="store_id" id="store_id" value="<?php echo (isset($store->store_id))?$store->store_id:"";?>">
				<div class="buttonrow" align="center">
					<input type="submit" class="btn btn-apply" value="Apply" name="submit"/>
					<input type="submit" class="btn btn-apply" value="Save" name="submit"/>
					<input type="button" class="btn btn-grey" id="Cancel" value="Cancel">					
				</div>
		</form>
		<br><br>		
	</div>
</div>
<script>
$(document).ready(function(){
	$('.btn-grey').live('click',function(){				
		 parent.history.back();
	     return false;
	})
	jQuery("#form_store_edit").validationEngine({promptPosition : "topRight", scroll: true, ajaxFormValidationMethod: 'post'});
});
</script>