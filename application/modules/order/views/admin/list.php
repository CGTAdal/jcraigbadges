<script type="text/javascript" src="<?php echo base_url();?>application/views/back_end/js/date.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/back_end/js/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application/views/back_end/css/datePicker.css" />
<script type="text/javascript">
	$(function(){
		$('.from-date-pick').datePicker(
			{
				startDate:	'01/01/1970'
			}
		);
		$('.to-date-pick').datePicker(
			{
				startDate:	'01/01/1970'
			}
		);
		$('.date-picker').datePicker(
			{
				startDate:	'01/01/1970'
			}
		);
	});	
</script>
<?php
	$current_method = $this->uri->segment(2);
?>
<div style="min-height: 300px; padding-bottom:20px" class="portlet x12">
	<div class="portlet-header">
		<h4>Order list</h4>
	</div> <!-- .portlet-header -->
	<div class="portlet-content">
		<div style="margin-bottom:10px">
			<div class="portlet-content form">
				<div class="field">
					<label style="width:94px;padding:0">Order Date</label>
					<label style="width:40px;">From</label>
					<input type="text" class="medium date-picker" size="12" name="fname" id="from_date" value="<?php echo ($from_date!="")?date('m/d/Y',$from_date):"";?>">
					<label style="width:40px;padding:0;">To </label>
					<input type="text" class="medium date-picker" size="12" name="fname" id="to_date" value="<?php echo ($to_date!="")?date('m/d/Y',$to_date):"";?>">
				</div>
				<div class="field">
					<label style="width:94px;padding:0">Ship Date</label>
					<label style="width:40px;">From</label>
					<input type="text" class="medium date-picker" size="12" id="shipped_from_date" value="<?php echo ($s_from_date!="")?date('m/d/Y',$s_from_date):"";?>">
					<label style="width:40px;padding:0">To</label>
					<input type="text" class="medium date-picker" size="12" id="shipped_to_date" value="<?php echo ($s_to_date!="")?date('m/d/Y',$s_to_date):"";?>">
				</div>
				<div class="field">
					<label>Order # </label>
					<input type="text" class="medium" size="12" name="fname" id="search_order_id" value="<?php echo ($search_order_id!="")?$search_order_id:"";?>">
				</div>
				<div class="field">
					<label>Unit #</label>
					<input type="text" class="medium" size="12" name="fname" id="search_store_number" value="<?php echo ($search_store_number!="")?$search_store_number:"";?>">
				</div>
				<div class="field">
					<label>Total</label>
					<input type="text" class="medium" size="12" name="fname" id="search_order_total" value="<?php echo ($search_order_total!="")?number_format($search_order_total,2):"";?>">
				</div>
				<div class="field">
					<label>Account Type</label>
					<select id="search_store_type">
						<option <?php echo ($search_store_type=="")?'selected':'';?> value="">All</option>
						<option <?php echo ($search_store_type==12)?'selected':'';?> value="12">Store & Market Director</option>
						<option <?php echo ($search_store_type==3)?'selected':'';?> value="3">Franchise</option>
					</select>
				</div>
				<div class="buttonrow">
					<input type="button" value="filter" id="submit_orer_list" class="btn btn-small" >
				</div>
			</div>
			<div style="float:right;margin-right:30px">
				<a href="<?php echo base_url();?>admin/order/exportToExcel" ><input type="button" class="btn btn-grey" value="Export to excel"></a>
			</div>
		</div>	
		<table cellpadding="10" cellspacing="0" align="center">
			<thead>
				<tr>
					<th id ="test">Order Date</th>
					<th class="sortable <?php echo ($sort_order_id!="")?"sorting_".$sort_order_id:"sorting";?>" value="order_id">Order #</th>
					<th class="sortable <?php echo ($sort_unit!="")?"sorting_".$sort_unit:"sorting";?>" value="store_number">Unit #</th>
					<th>Type</th>
					<th>State</th>
					<th>Market Director</th>
					<th>Ship Date</th>
					<th>Item</th>
					<th>Badge Qty</th>
					<th>Tenured Qty</th>
					<th>5-Pack Magnets</th>
					<th>5-Pack Pins</th>
					<th class="sortable <?php echo ($sort_cost!="")?"sorting_".$sort_cost:"sorting";?>" value="cost">Order Cost</th>
					<th>Tax</th>
					<th >Total</th>
					<th>Status</th>
					<th>Approved Date</th>
					<th>Approval Email</th>
					<th style="text-align:center">Action</th>
				</tr>
			</thead>
			<?php if(count($orders)>0) {?>
				<?php $i=0;foreach($orders as $order) {?>
					<tr>
						<td>
							<?php echo date('m/d/Y',$order->order_date);?>
						</td>
						<td>
							<a href="<?php echo base_url();?>admin/order/detail/<?php echo $order->order_id;?>"><?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?></a>							
						</td>
						<td>
							<a href="<?php echo base_url();?>admin/store/detail/<?php echo $order->store_id;?>"><?php echo $order->store_number;?></a>
						</td>
						<td>
							<?php 
								echo ($order->store_type==1) ? "Store" : (($order->store_type==2)? "Market Director" : "Franchise");
							?>
						</td>
						<td>
							<?php echo $order->store_state;?>
						</td>
						<td>
							<a href="<?php echo base_url();?>admin/store/detail/<?php echo $order->director_id;?>"><?php echo $order->director_number;?></a>
						</td>
						<td><?php echo ($order->order_shipdate==0)?'&nbsp;':date('m/d/Y',$order->order_shipdate)?></td>
						<td>
							Name Badges
						</td>
						<td>
							<?php echo $order->order_total?>
						</td>
						<td>
							<?php echo $order->order_tenured_qty?>
						</td>
						<td>
							<?php echo $order->order_mf_qty?>
						</td>
						<td>
							<?php echo $order->order_pf_qty?>
						</td>
						<td>
							<?php
								if($order->order_cost==0) { 
									echo number_format($order->order_total * 4.75 + $order->order_mf_qty * 6.25 + $order->order_pf_qty * 3.5,2);
								} else {
									echo number_format($order->order_cost,2);									
								}
							?>
						</td>
						<td>
							<?php 
								echo number_format($order->order_tax,2);
							?>
						</td>
						<td>
							<?php
								if($order->order_cost==0) { 
									echo number_format($order->order_total * 4.75 + $order->order_mf_qty * 6.25 + $order->order_pf_qty * 3.5 + $order->order_tax,2);
								} else {
									echo number_format($order->order_cost + $order->order_tax,2);									
								}
							?>
						</td>
						<td value="<?php echo $order->order_id;?>">
							<select class="order-status">
								<option value="1" <?php echo ($order->order_status==1)?'selected':'';?>>Pending</option>
								<option value="2" <?php echo ($order->order_status==2)?'selected':'';?>>Approved</option>
								<option value="3" <?php echo ($order->order_status==3)?'selected':'';?>>Denied</option>
							</select>
						</td>
						<?php if($order->order_status==2) {?>
						<td><?php echo date('m/d/Y',$order->order_approve_dated);?></td>
						<?php } else {?>
						<td>&nbsp;</td>
						<?php }?>
						<td align="center">
							<?php if($order->director_id!="") {?>
								<a href="javascript: void(0);" class="resend_approval" value="<?php echo $order->order_id;?>">RESEND</a>
							<?php } else echo '&nbsp;'?>
						</td>
						<td align="center">
							<?php if($order->order_shipdate==0) {?><a href="javascript: void(0)" value="<?php echo $order->order_id;?>" class="delete-order">Delete</a><?php }?>
						</td>
					</tr>
				<?php $i++;}?>
			<?php } else {?>
				<tr class="fontGL row0">
					<td colspan="13" align="center">No order</td>
				</tr>
			<?php }?>
		</table>
		<div style="float:right">
			Number item on perpage
			<select id="select_perpage_list_order">
				<option value="12" <?php echo ($select_perpage==12)?'selected':'';?>>12</option>
				<option value="18" <?php echo ($select_perpage==18)?'selected':'';?>>18</option>
				<option value="24" <?php echo ($select_perpage==24)?'selected':'';?>>24</option>
				<option value="30" <?php echo ($select_perpage==30)?'selected':'';?>>30</option>
				<option value="all" <?php echo ($select_perpage=='all')?'selected':'';?>>All</option>
			</select>
			<?php echo $pagination;?>
		</div>	
	</div> <!-- .portlet-content -->	
	<form action="<?php echo base_url();?>admin/order/listorders" method="post" id="list_orders_form">
	</form>
</div>
<!--END main-->
<script>
$(document).ready(function(){
	$('#submit_orer_list').live('click',function(){
		var from_date 		= $('#from_date').val();
		var to_date 		= $('#to_date').val();
		var s_from_date		= $('#shipped_from_date').val();
		var s_to_date		= $('#shipped_to_date').val();
		var search_order_id 		= $('#search_order_id').val();
		var search_store_number 	= $('#search_store_number').val();
		var search_order_total 		= $('#search_order_total').val();
		var search_store_type		= $('#search_store_type').val();
				
		var input_search_order_id 		= "<input type='hidden' name='search_order_id' value='"+search_order_id+"' />";	
		var input_search_store_numberd	= "<input type='hidden' name='search_store_number' value='"+search_store_number+"' />";	
		var input_search_order_total	= "<input type='hidden' name='search_order_total' value='"+search_order_total+"' />";		
		var input_from_date = "<input type='hidden' name='from_date' value='"+from_date+"' />";		
		var input_to_date	= "<input type='hidden' name='to_date' value='"+to_date+"' />";
		var input_s_from_date 			= "<input type='hidden' name='s_from_date' value='"+s_from_date+"' />";
		var input_s_to_date 			= "<input type='hidden' name='s_to_date' value='"+s_to_date+"' />";
		var input_s_store_type 			= "<input type='hidden' name='search_store_type' value='"+search_store_type+"' />";
		
		$('#list_orders_form').append(input_search_order_id);
		$('#list_orders_form').append(input_search_store_numberd);
		$('#list_orders_form').append(input_search_order_total);	
		$('#list_orders_form').append(input_from_date);
		$('#list_orders_form').append(input_to_date);
		$('#list_orders_form').append(input_s_from_date);
		$('#list_orders_form').append(input_s_to_date);
		$('#list_orders_form').append(input_s_store_type);
		$('#list_orders_form').submit();
	});
	$('#select_perpage_list_order').bind('change', function(event){
	 	var perpage = $(this).val();	 		
		var select_perpage	= "<input type='hidden' name='perpage' value='"+perpage+"' />";
		$('#list_orders_form').append(select_perpage);
		$('#list_orders_form').submit();
	});	

	$('.sortable').click(function(){
		var sort_type 	= $(this).attr('value');
		var input		= "<input type='hidden' name='sort_type' value='"+sort_type+"' />";
		$('#list_orders_form').append(input);
		$('#list_orders_form').submit();
	});

	$('.delete-order').click(function(){
		var answer = confirm('Are you sure you wish to delete this order?');
		if(answer) {
			order_id = $(this).attr('value');
			window.location="<?php echo base_url();?>admin/order/delete/"+order_id;
		}
	});

	$('.order-status').change(function(){
		var order_id = $(this).parent().attr('value');
		var status	 = $(this).val();
		$.post(
			"<?php echo base_url();?>order/admin/ajax/updateOrderStatus",
			{order_id: order_id, status: status},
			function(data){
				if(data=='0') {
					alert('Error');
				} else {
					alert('Order was updated successfully');
					$('#list_orders_form').submit();
				}
			}
		);		
	});

	$('.resend_approval').click(function(){
		if(confirm("Are you sure?")) {
			var order_id = $(this).attr('value');
			$.post(
				"<?php echo base_url();?>/order/admin/ajax/resend_approval",
				{order_id: order_id},
				function(data){
					if(data=='1') {
						alert('Email was sent successfully.');
					} else {
						alert('Error.');
					}
				}
			);
		}
	});
	
});


</script>

