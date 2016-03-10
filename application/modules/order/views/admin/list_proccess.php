<script type="text/javascript" src="<?php echo base_url();?>application/views/back_end/js/date.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/back_end/js/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application/views/back_end/css/datePicker.css" />
<script type="text/javascript">
	$(function(){
		$('.date-picker').datePicker(
				{
					startDate:	'01/01/1970'
				}
		);
	});	
</script>
<div style="min-height: 300px; padding-bottom:20px" class="portlet x12">
	<div class="portlet-header">
		<h4>Process Order List</h4>
	</div> <!-- .portlet-header -->
	<div class="portlet-content">
		<div style="margin-bottom:10px">
			<div class="portlet-content form">
				<div class="field">
					<label style="width:94px;padding:0">Order Date</label>
					<label style="width:40px;">From</label>
					<input type="text" class="medium date-picker" size="12" id="from_date" value="<?php echo ($from_date!="")?date('m/d/Y',$from_date):"";?>">
					<label style="width:40px;padding:0;">To</label>
					<input type="text" class="medium date-picker" size="12" id="to_date" value="<?php echo ($to_date!="")?date('m/d/Y',$to_date):"";?>">
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
				<div class="buttonrow">
					<input type="button" value="filter" id="submit_orer_list" class="btn btn-small" >
				</div>
			</div>
		</div>	
		<table cellpadding="10" cellspacing="0" align="center">
			<thead>
				<tr>
					<th id ="test">Order Date</th>
					<th class="sortable <?php echo ($sort_order_id!="")?"sorting_".$sort_order_id:"sorting";?>" value="order_id">Order #</th>
					<th class="sortable <?php echo ($sort_unit!="")?"sorting_".$sort_unit:"sorting";?>" value="store_number">Unit #</th>
					<th class="sortable <?php echo ($order_shipdate!="")?"sorting_".$order_shipdate:"sorting";?>" value="order_shipdate">Ship Date</th>
					<th>Item</th>
					<th>Badge Quantity</th>
					<th>Tenured Quantity</th>
					<th>5-Pack Magnets</th>
					<th>5-Pack Pins</th>
					<th style="text-align:right">Processed By</th>
				</tr>
			</thead>
			<?php if(count($orders)>0) {?>
				<?php $i=0;foreach($orders as $order) {?>
					<tr>
						<td>
							<?php echo date('m/d/Y',$order->order_date);?>
						</td>
						<td>
							<a href="<?php echo base_url();?>admin/process/detail/<?php echo $order->order_id;?>"><?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?></a>							
						</td>
						<td>
							<?php echo $order->store_number;?>
						</td>
						<td>
							<?php echo ($order->order_shipdate==0)?'pending':date('m/d/Y',$order->order_shipdate);?>
						</td>
						<td>Name Badges</td>
						<td>
							<?php echo $order->order_total;?>
						</td>
						<td>
							<?php echo $order->order_tenured_qty;?>
						</td>
						<td>
							<?php echo $order->order_mf_qty;?>
						</td>
						<td>
							<?php echo $order->order_pf_qty?>
						</td>
						<td align="right">
							<?php echo $order->order_process;?>
						</td>
					</tr>
				<?php $i++;}?>
			<?php } else {?>
				<tr class="fontGL row0">
					<td colspan="3">No order</td>
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
	<form action="<?php echo base_url();?>admin/process/listprocess" method="post" id="list_orders_form">
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
		var search_order_id 			= $('#search_order_id').val();
		var search_store_number 		= $('#search_store_number').val();
		var search_order_total 			= $('#search_order_total').val();		
		var input_search_order_id 		= "<input type='hidden' name='search_order_id' value='"+search_order_id+"' />";	
		var input_search_store_numberd	= "<input type='hidden' name='search_store_number' value='"+search_store_number+"' />";	
		var input_search_order_total	= "<input type='hidden' name='search_order_total' value='"+search_order_total+"' />";		
		var input_from_date 			= "<input type='hidden' name='from_date' value='"+from_date+"' />";		
		var input_to_date				= "<input type='hidden' name='to_date' value='"+to_date+"' />";
		var input_s_from_date 			= "<input type='hidden' name='s_from_date' value='"+s_from_date+"' />";
		var input_s_to_date 			= "<input type='hidden' name='s_to_date' value='"+s_to_date+"' />";
		$('#list_orders_form').append(input_search_order_id);
		$('#list_orders_form').append(input_search_store_numberd);
		$('#list_orders_form').append(input_search_order_total);	
		$('#list_orders_form').append(input_from_date);
		$('#list_orders_form').append(input_to_date);
		$('#list_orders_form').append(input_s_from_date);
		$('#list_orders_form').append(input_s_to_date);
		$('#list_orders_form').submit();
	});
	
	$('#select_perpage_list_order').bind('change', function(event){
		var perpage = $(this).val();	 		
		var select_perpage		= "<input type='hidden' name='perpage' value='"+perpage+"' />";
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
	
});


</script>

