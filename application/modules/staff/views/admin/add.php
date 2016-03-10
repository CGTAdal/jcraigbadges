<div style="min-height: 300px;" class="portlet x12">
	<div class="portlet-header"><h4>Add a new Staff</h4></div>			
		<div class="portlet-content" >		
			<form class="form label-inline" id="form_staff_add" method="post" action="<?php echo base_url();?>admin/staff/add">								 
				<div class="field">				
					<label for="fname" ><span>Login</span></label>				
					<?php 
						$data = array(
								'name'	=> "admin_login",
								'id'	=> "admin_login",
								'value'	=> $this->input->post('admin_login'),
								'class' => 'medium',
								'size'	=> '50'
							);
						echo form_input($data);
						echo form_error('admin_login');
						echo ($error_login!="")?"<p>".$error_login."</p>":"";
					?>
				</div>					
				<div class="field">
					<label for="fname" >PassWord</label>
					<?php
						$data = array(
								'name'	=> "admin_password",
								'id'	=> "admin_password",
								'value'	=> $this->input->post('admin_password'),
								'class' => 'medium',
								'size'	=> '50',
								'type'	=>'password',
							);
						echo form_input($data);
					?>
				</div>	
				<div class="field">
					<label for="fname" ><span>Confirm PassWord</span></label> 
					
					<?php
						$data = array(
								'name'	=> "confirm_password",
								'id'	=> "confirm_password",
								'value'	=> $this->input->post('confirm_password'),
								'class' => 'medium',
								'size'	=> '50',
								'type'	=>'password',
							);
						echo form_input($data);
						echo ($error_confirm_password!="")?"<p>".$error_confirm_password."</p>":"";						 
					?>
				</div>	
				<br>
				<div class="field"><?php echo ($error_full!="")?"<p>".$error_full."</p>":"";?></div>				
				<input type="hidden" name="store_id" id="admin_id" value="<?php echo (isset($staff->admin_id))?$staff->admin_id:"";?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>">
				<div class="buttonrow" style="margin-left:165px">					
					<button class="btn btn-orange" id ="button" value="Save" >Save</button>
					<input type="button" class="btn btn-grey" id="Cancel" value="Cancel" >					
				</div>
		</form>
		<br><br>		
	</div>
	
</div>
<script>
$(document).ready(function(){
	$('#Cancel').live('click',function(){				
		 parent.history.back();
	     return false;
	})
	
	$('#button').live('click',function(){
		var button_type 		= $(this).attr('value');		
		var admin_login 		= $('#admin_login').val();
		var admin_password 		= $('#admin_password').val();
		var confirm_password 	= $('#confirm_password').val();		
		/*if(admin_password != confirm_password){
			alert("Confirm password Wrong! Pleased enter again!");
			$('#admin_password').focus();
			return false;
		}*/
		var input_button_type 	= "<input type='hidden' name='button_edit' value='"+button_type+"' />";
		var input_admin_login 	= "<input type='hidden' name='admin_login' value='"+admin_login+"' />";
		var input_admin_password 	= "<input type='hidden' name='admin_password' value='"+admin_password+"' />";
		var input_confirm_password 	= "<input type='hidden' name='confirm_password' value='"+confirm_password+"' />";				
		$('#form_staff_add').append(input_confirm_password);
		$('#form_staff_add').append(input_admin_password);
		$('#form_staff_add').append(input_admin_login);
		$('#form_staff_add').append(input_button_type);
		$('#form_staff_add').submit();		
	});	
});

</script>