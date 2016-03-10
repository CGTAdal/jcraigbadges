
<div style="min-height: 300px;" class="portlet x12">
	<div class="portlet-header"><h4>Edit Staff</h4></div>			
		<div class="portlet-content" >		
			<form class="form label-inline" id="form_staff_edit" method="post" action="<?php echo base_url();?>admin/staff/edit/<?php echo $staff->admin_id;?>">
				<div class="field">
					<label for="fname" >Login</label> 
					<input type="text" class="medium" size="50" name="fname" id="admin_login" value="<?php echo (isset($staff->admin_login))?$staff->admin_login:"";?>">
				</div>
				<div class="field">				
					<label for="fname" ><span>PassWord old</span></label>				
					<?php 
						$data = array(
								'name'	=> "admin_password_old",
								'id'	=> "admin_password_old",
								'value'	=> $this->input->post('admin_password_old'),
								'class' => 'medium',
								'size'	=> '50',
								'type'	=> 'password',
							);
						echo form_input($data);
						echo form_error('admin_password_old');
						echo ($error_old!="")?"<p>".$error_old."</p>":"";
					?>
				</div>				
				<div class="field">
					<label for="fname" >PassWord new</label>
					<?php 
						$data = array(
								'name'	=> "new_password",
								'id'	=> "new_password",
								'value'	=> $this->input->post('new_password'),
								'class' => 'medium',
								'size'	=> '50',
								'type'	=> 'password',
							);
						echo form_input($data);
					?>
				</div>	
				<div class="field">
					<label for="fname" >Confirm new PassWord</label>
					<?php 
						$data = array(
								'name'	=> "confirm_new_password",
								'id'	=> "confirm_new_password",
								'value'	=> $this->input->post('confirm_new_password'),
								'class' => 'medium',
								'size'	=> '50',
								'type'	=> 'password',
							);
						echo form_input($data);						
						echo ($error_confirm_password!="")?"<p>".$error_confirm_password."</p>":"";
					?>
				</div>					
				<br>	
				<div class="field"><?php echo ($error_full!="")?"<p>".$error_full."</p>":"";?></div>			
				<input type="hidden" name="admin_id" id="admin_id" value="<?php echo (isset($staff->admin_id))?$staff->admin_id:"";?>">				
				<div class="buttonrow" align="center" style="margin-left:165px">
					<button class="btn btn-apply"  id ="btn_edit" value="applly">Apply</button>
					<button class="btn btn-orange" id ="btn_edit" value="Save">Save</button>
					<input type="button" class="btn btn-grey" id="Cancel" value="Cancel">					
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
	$('#btn_edit').live('click',function(){
		var button_type 			= $(this).attr('value');
		var admin_login 			= $('#admin_login').val();
		var admin_password_old 		= $('#admin_password_old').val();	
		var new_password 			= $('#new_password').val();
		var confirm_new_password 	= $('#confirm_new_password').val();		
		var input_button_type 		= "<input type='hidden' name='button_edit' value='"+button_type+"' />";
		var input_admin_login 		= "<input type='hidden' name='admin_login' value='"+admin_login+"' />";
		var input_admin_password 	= "<input type='hidden' name='admin_password_old' value='"+admin_password_old+"' />";
		var input_new_password		= "<input type='hidden' name='new_password' value='"+new_password+"' />";
		var input_confirm_new_password	= "<input type='hidden' name='confirm_new_password' value='"+confirm_new_password+"' />";
		$('#form_staff_edit').append(input_confirm_new_password);
		$('#form_staff_edit').append(input_new_password);
		$('#form_staff_edit').append(input_admin_password);
		$('#form_staff_edit').append(input_admin_login);
		$('#form_staff_edit').append(input_button_type);
		$('#form_staff_edit').submit();		
	});	
});

</script>