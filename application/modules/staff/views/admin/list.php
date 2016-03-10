<div style="min-height: 300px; padding-bottom:20px" class="portlet x12">
	<div class="portlet-header">
		<h4>Staff list
			<div class="buttonrow" style="float:right; margin-right:20px;">
				<a href="<?php echo base_url();?>admin/staff/add"><input type="button" value="Add a new Staff"  class="btn btn-orange" ></a>
			</div>
		</h4>
	</div> <!-- .portlet-header -->
	<div class="portlet-content">
		<table cellpadding="0" cellspacing="0" align="center">
			<thead>
				<tr>					
					<th >Login</th>					
					<th style="text-align:right" >Action</th>
				</tr>
			</thead>
			<?php if(count($staffs)>0){?>
				<?php foreach($staffs as $staff){?>	
					<tr>
						<td ><?php echo $staff->admin_login;?></td>						
						<td align="right" style="width:120px">
							<a href="<?php echo base_url();?>admin/staff/edit/<?php echo $staff->admin_id;?>">edit</a>
							<a href="javascript: void(0);" onclick = "del_staff(<?php echo $staff->admin_id;?>)">delete</a>
						</td>
					</tr>
				<?php }?>
			<?php }else{?>
				<tr class="fontGL row0">
					<td colspan="3">No Store</td>
				</tr>		
			<?php }?>	
		</table>	
	</div> <!-- .portlet-content -->	
</div>
<!--END main-->
<script>
function del_staff(id){	
	var staff_del = confirm("Are you ready delete?");	
	if(staff_del==true){		
		window.location="<?php echo base_url();?>admin/staff/del/"+id;
	}else{
		return false;
	}		
}
</script>