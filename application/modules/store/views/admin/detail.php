<script type="text/javascript" src="<?php echo base_url();?>application/views/back_end/js/date.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/back_end/js/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application/views/back_end/css/datePicker.css" />
<script type="text/javascript">
	$(function(){
		//var selectedDates 	= new Array();
		//selectedDates[0]	= '25/12/1986';
		$('.store-date-pick').datePicker(
				{
					startDate:	'01/01/1970'
				}
		);		
	});	
</script>
<div style="min-height: 300px;" class="portlet x12">		
	<div class="portlet-header">
		<h4>Store Detail</h4>
		</div> <!-- .portlet-header -->		
			<?php if(count($store)>0){?>	
			<div class="portlet-content">				
				<h1>Store Information:<?php echo $store->store_number;?><a style="float:right;font-size:13px;"href="<?php echo base_url();?>admin/store/edit/<?php echo $store->store_id;?>">edit</a></h1>						
					<div class="pl-20 fontGL mb-30" style="font-size:14px; margin-left:180px">
						<div>Jenny Craig Centre: <?php echo $store->store_number;?></div>						
						<div>Address: <?php echo $store->store_address.', '.$store->store_city.', '.$store->store_state.', '.$store->store_zip;?></div>					
						<div>Contact: <?php echo $store->store_contact;?></div>
						<div>Phone: <?php echo $store->store_phone;?></div>
						<div>Email: <?php echo $store->store_email;?></div>
					</div><br><br>					
				<h1>Store Orders:</h1>
				<div style="margin-bottom:10px">
					<div class="portlet-content form">
						<div class="field">
							<label for="fname">Date </label>
							<input type="text" class="medium store-date-pick" size="12" name="fname" id="store_date" value="<?php echo ($store_date!="")?date('m/d/Y',$store_date):"";?>">
						</div>						
						<div class="field">
							<label for="fname">Order # </label>
							<input type="text" class="medium" size="12" name="fname" id="search_store_order_id" value="<?php echo ($search_store_order_id!="")?$search_store_order_id:"";?>">
						</div>						
						<div class="field">
							<label for="fname">Total</label>
							<input type="text" class="medium" size="12" name="fname" id="search_store_order_total" value="<?php  echo ($search_store_order_total!="")?(number_format($search_store_order_total*2.75,2)+4.25):"";?>">
						</div>
						<div class="buttonrow">
							<input type="button" value="filter" id="submit_store_detail" class="btn btn-small" >
						</div>
					</div>
				</div>
				<?php }?>
				<table cellspacing="0" cellpadding="0" border="0">			
						<thead>
							<tr>
								<th class="sort <?php echo ($sort_store_date!="")?"sorting_".$sort_store_date:"sorting";?>" value="store_date">Order Date</th>
								<th class="sort <?php echo ($sort_store_order!="")?"sorting_".$sort_store_order:"sorting";?>" value="store_order">Order #</th>
								<th>Ship Date</th>								
								<th>Item</th>
								<th>Badge Quantity</th>
								<th >Badge Cost</th>
								<th >Handling</th>								
								<th >Total</th>
								<th style="text-align:right">Cost Total</th>
							</tr>
						</thead>
						<?php if(count($orders)>0) {?>
							<?php $i=0;foreach($orders as $order) {?>
								<tr>
									<td>
										<?php echo date('m/d/Y',$order->order_date);?>
									</td>		
									<td><a href="<?php echo base_url();?>admin/order/detail/<?php echo $order->order_id;?>"><?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?></a></td>																
									<td><?php echo ($order->order_shipdate==0)?'pending':date('m/d/Y',$order->order_shipdate)?></td>
									<td>Name Badges</td>
									<td ><?php echo $order->order_total?></td>							          
									<td ><?php echo number_format($order->order_total * 2.75,2);?></td>
									<td >4.25</td>									
									<td ><?php echo number_format(number_format($order->order_total * 2.75,2)+4.25,2);?></td>
									<td align="right"><?php echo number_format(number_format($order->order_total * 1.96,2)+3.00,2);?></td>
								</tr>
							<?php $i++;}?>
						<?php } else {?>
							<tr class="fontGL row0">
								<td colspan="3">No Order</td>
							</tr>				
						<?php }?>
					
				</table>				
	</div> <!-- .portlet-content -->
	<?php if(count($store)>0){?>
	<form action="<?php echo base_url();?>admin/store/detail/<?php echo $store->store_id;?>" method="post" id="detail_store_form">
	</form>	
	<?php }?>
</div>
<script>
$(document).ready(function(){
	$('#submit_store_detail').click(function(){
		var store_date 	=  $('#store_date').val();
		var search_store_order_id 		=  $('#search_store_order_id').val();
		var search_store_order_total 	=  $('#search_store_order_total').val();		
		var input_store_date 			= "<input type='hidden' name='store_date' value='"+store_date+"' />";
		var input_search_store_order_id = "<input type='hidden' name='search_store_order_id' value='"+search_store_order_id+"' />";
		var input_search_store_order_total = "<input type='hidden' name='search_store_order_total' value='"+search_store_order_total+"' />";
		$('#detail_store_form').append(input_store_date);
		$('#detail_store_form').append(input_search_store_order_id);
		$('#detail_store_form').append(input_search_store_order_total);
		$('#detail_store_form').submit();
	});
	$('.sort').click(function(){
		var sort_type 	= $(this).attr('value');		
		var input		= "<input type='hidden' name='sort_type' value='"+sort_type+"' />";
		$('#detail_store_form').append(input);
		$('#detail_store_form').submit();
	});
});
</script>