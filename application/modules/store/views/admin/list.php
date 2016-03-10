<div style="min-height: 300px; padding-bottom:20px" class="portlet x12">
	<div class="portlet-header">
		<h4>Account list
			<div class="buttonrow" style="float:right; margin-right:20px;">
				<a href="<?php echo base_url();?>admin/store/add"><input type="button" value="Add a new Account"  class="btn btn-orange" ></a>
			</div>
		</h4>
	</div> <!-- .portlet-header -->
	<div class="portlet-content">	
	<div style="margin-bottom:10px">
			<div class="portlet-content form">							
				<div class="field">
					<label>Unit # </label>
					<input type="text" class="medium" size="12" name="fname" id="search_store_unit_number" value="<?php echo ($search_store_unit_number!="")?$search_store_unit_number:"";?>">
				</div>
				<div class="field">
					<label>Type </label>
					<select name="" id="search_store_type">
						<option value="all" <?php echo ($search_store_type=="all")?"selected":"";?>>All</option>
						<option value="1" <?php echo ($search_store_type=="1")?"selected":"";?>>Store</option>
						<option value="2" <?php echo ($search_store_type=="2")?"selected":"";?>>Market Director</option>
						<option value="3" <?php echo ($search_store_type=="3")?"selected":"";?>>Franchise</option>
					</select>
				</div>
				<?php if(count($market_directors) > 0) {?>
					<div class="field">
						<label>Assigned to</label>
						<select name="" id="search_assigned_to">
							<option value="" <?php echo ($search_store_assigned=="")?"selected":"" ?>;></option>
							<?php foreach($market_directors as $md) {?>
								<option value="<?php echo $md->store_id;?>" <?php echo ($search_store_assigned==$md->store_id)?"selected":"" ?>><?php echo $md->store_number;?></option>
							<?php }?>	
						</select>
					</div>
				<?php }?>
				<?php if(1==0) {?>
					<div class="field">
						<label>abc</label>
						<select name="" id="search_directors_of_store">
							<option value="" <?php //echo ($search_store_assigned=="")?"selected":"" ?>;></option>
							<?php foreach($store_list as $sl) {?>
								<option value="<?php echo $sl->store_id;?>" <?php //echo ($search_store_assigned==$md->store_id)?"selected":"" ?>><?php echo $sl->store_number;?></option>
							<?php }?>	
						</select>
					</div>
				<?php }?>
				<div class="field">
					<label>&nbsp;</label>
					<input type="button" value="filter" id="submit_store_list" class="btn btn-small" >
				</div>
			</div>
			<div style="float:right;margin-bottom:10px">
				Number item on perpage
				<select class="select_perpage_list_store">
					<option value="12" <?php echo ($select_perpage==12)?'selected':'';?>>12</option>
					<option value="18" <?php echo ($select_perpage==18)?'selected':'';?>>18</option>
					<option value="24" <?php echo ($select_perpage==24)?'selected':'';?>>24</option>
					<option value="30" <?php echo ($select_perpage==30)?'selected':'';?>>30</option>
					<option value="36" <?php echo ($select_perpage==36)?'selected':'';?>>36</option>
					<option value="42" <?php echo ($select_perpage==42)?'selected':'';?>>42</option>
					<option value="48" <?php echo ($select_perpage==48)?'selected':'';?>>48</option>
					<option value="all" <?php echo ($select_perpage=='all')?'selected':'';?>>All</option>
				</select>
				<?php echo $pagination;?>
			</div>
		</div>		
		<table cellpadding="0" cellspacing="0" align="center">
			<thead>
				<tr>
					<th>Type</th>
					<th >Unit #</th>
					<th >Express Account #</th>
					<th >Ground Account #</th>
					<th >Location name</th>
					<th >Address</th>
					<th >City</th>
					<th >State</th>
					<th >Zip</th>
					<th >Contact</th>
					<th >Phone</th>
					<th >Email</th>
					<th style="text-align:right" >Action</th>
				</tr>
			</thead>	
			<?php if(count($stores)>0){?>	
				<?php foreach($stores as $store){?>	
					<tr>
						<td>
							<?php 
								switch ($store->store_role) {
									case '1': echo 'Store';
									break;
									case '2': echo 'Market Director';
									break;
									case '3': echo 'Franchise';
								}
							?>
						<td >
							<a href="<?php echo base_url();?>admin/store/detail/<?php echo $store->store_id;?>"><?php echo $store->store_number;?></a>
						</td>
						<td ><?php echo $store->store_express;?></td>
						<td ><?php echo $store->store_ground;?></td>
						<td><?php echo $store->store_location_name;?></td>
						<td style="width:76px"><?php echo $store->store_address;?></td>
						<td ><?php echo $store->store_city;?></td>
						<td ><?php echo $store->store_state;?></td>
						<td ><?php echo $store->store_zip;?></td>
						<td ><?php echo $store->store_contact;?></td>
						<td ><?php echo $store->store_phone;?></td>
						<td ><?php echo $store->store_email;?></td>
						<td align="right" style="width:60px">
							<a href="<?php echo base_url();?>admin/store/edit/<?php echo $store->store_id;?>">edit</a>
							<a href="javascript: void(0);" onclick="del_store(<?php echo $store->store_id?>)">delete</a>
						</td>
					</tr>	
				<?php }?>
			<?php }else{?>			
				<tr class="fontGL row0">
					<td colspan="3">No result</td>
				</tr>
				<?php }?>
		</table>
		<div style="float:right;">
			Number item on perpage
			<select class="select_perpage_list_store">
				<option value="12" <?php echo ($select_perpage==12)?'selected':'';?>>12</option>
				<option value="18" <?php echo ($select_perpage==18)?'selected':'';?>>18</option>
				<option value="24" <?php echo ($select_perpage==24)?'selected':'';?>>24</option>
				<option value="30" <?php echo ($select_perpage==30)?'selected':'';?>>30</option>
				<option value="36" <?php echo ($select_perpage==36)?'selected':'';?>>36</option>
				<option value="42" <?php echo ($select_perpage==42)?'selected':'';?>>42</option>
				<option value="48" <?php echo ($select_perpage==48)?'selected':'';?>>48</option>
				<option value="all" <?php echo ($select_perpage=='all')?'selected':'';?>>All</option>
			</select>
			<?php echo $pagination;?>
		</div>		
	</div> <!-- .portlet-content -->
	<form action="<?php echo base_url();?>admin/store/liststores" method="post" id="list_stores_form">
	</form>
</div>
<!--END main-->
<script>
$(document).ready(function(){
	$('#submit_store_list').click(function(){
		var search_store_unit_number 	= $('#search_store_unit_number').val();		
		var input_search_store_number 	= "<input type='hidden' name='search_store_unit_number' value='"+search_store_unit_number+"'/>";
		var search_store_type			= $('#search_store_type').val();		
		var input_search_store_type 	= "<input type='hidden' name='search_store_type' value='"+search_store_type+"'/>";
		var search_assigned_store		= $('#search_assigned_to').val();
		var input_search_assigned_store	= "<input type='hidden' name='search_assigned_store' value='"+search_assigned_store+"'/>";
		//var search_director_of_store	= ('').val();
		
		
			
		$('#list_stores_form').append(input_search_store_number);
		$('#list_stores_form').append(input_search_store_type);
		$('#list_stores_form').append(input_search_assigned_store);
		$('#list_stores_form').submit();		
	});
	$('.select_perpage_list_store').bind('change', function(event){
	 	var perpage = $(this).val();
		var select_perpage	= "<input type='hidden' name='perpage' value='"+perpage+"' />";				
		$('#list_stores_form').append(select_perpage);
		$('#list_stores_form').submit();
	});
});
function del_store(id){
	var store_del = confirm("Are you sure to delete this account?");	
	if(store_del==true){
		window.location="<?php echo base_url();?>admin/store/del/"+id;
	}else{
		return false;
	}		
}
</script>