<?php
	$current_method = $this->uri->segment(2);
?>
<div style="min-height: 300px;" class="portlet x12">		
	<div class="portlet-header">
		<h4><?php if($current_method=='order'){?>Order Detail<?php }else{?>Process Order Detail<?php }?></h4>
	</div> <!-- .portlet-header -->
	<div class="portlet-content">
		<?php if(count($order)>0){?>
			<?php if($current_method=='process'){?>	
				<div class="buttonrow" align="center">					
					<input type="button" class="btn <?php echo ($order->order_shipdate > 0)?"btn-green no-pointer":"btn-grey process-order"; ?>" value="<?php echo ($order->order_shipdate>0)?"Order Processed":"Process Order"?>" >
					<br><br>
					<?php if($order->order_shipdate > 0){?>
						<label style="font-size:16px">Order Processed by: <?php echo $order->order_process;?></label>
					<?php }?>					
				</div>			
			<?php }?>
			<h2 class="title">Shipping Address:</h2>
			<div class="pl-20 fontGL mb-30">
				<div>Jenny Craig Centre <?php echo $shipping['selected_store']?></div>
				<div>ATTN:  <?php echo ($shipping['attn']!='')?$shipping['attn']:'';?></div>
				<div><?php echo $shipping['address'];?></div>
				<div><?php echo isset($shipping['address_2']) ? $shipping['address_2'] : "";?></div>
				<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
			</div>
			<br>
			<?php if($order->store_role!=3) {?>
				<h3 class="title">Order Placed By: <?php echo ($order->order_customer!='')?$order->order_customer:'';?></h3>
				<br>
			<?php }  ?>
			<?php if($order->store_role==3) {?>
				<h2 class="title">Billing Address:</h2>
				<div class="pl-20 fontGL mb-30">
					<div><?php echo $billing['fname'].' '.$billing['lname'];?></div>
					<div><?php echo $billing['phone'];?></div>
					<div><?php echo $billing['address'];?></div>
					<div><?php echo $billing['city'].', '.$billing['state'].' '.$billing['zip'];?></div>
				</div>
				<br>
			<?php }  ?>					
			<h2 class="title">Order Total:</h2>
			<div class="pl-20 fontGL mb-30">
				<?php if($order->order_total>0) {?>
					<div><?php echo $order->order_total; echo ($order->order_total>1)?' Badges':' Badge';?></div>
				<?php }?>
				<?php if($order->order_tenured_qty > 0) {?>
					<div><?php echo $order->order_tenured_qty; echo ($order->order_tenured_qty>1)?' Tenured Badges':' Tenured Badge';?></div>
				<?php }?>
				<?php if($order->order_mf_qty>0) {?>
					<div><?php echo $order->order_mf_qty; echo ($order->order_mf_qty>1)?' Magnet Packs of 5':' Magnet Pack of 5';?></div>
				<?php }?>
				<?php if($order->order_pf_qty>0) {?>
					<div><?php echo $order->order_pf_qty; echo ($order->order_pf_qty>1)?' Pin Packs of 5':' Pin Pack of 5';?></div>
				<?php }?>
			</div><br><br>
			
			<?php if($current_method=='process'){?>
				<div class="buttonrow" align="center" style="float:right;margin-right:30px">
					<a href="<?php echo base_url();?>admin/process/exportTotext/<?php echo $order->order_id;?>"><input type="button" class="btn btn-grey" value="Export to text"></a>
				</div>
			<?php }?>
		<?php }?>
		<h2 class="title"><?php echo ($current_method=='process')?'Ordered Badges:':'Ordered Badges:'?></h2>
		<table cellspacing="0" cellpadding="0" border="0">	
			<thead>
				<tr>
					<th>Style</th>
					<th>Name</th>
					<th>Fastener</th>
					<th>Years Of Service</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($badges)&& ($badges)>0) {?>							
					<?php $i=0; foreach($badges as $badge){?>
						<tr>						
							<td><?php if(isset($badge['style'])) {echo $badge['style'];}else{}?></td>			
							<td><?php if(isset($badge['name'])){echo $badge['name'];}else{}?></td>
							<td><?php if(isset($badge['fastener'])){echo $badge['fastener'];}else{}?></td>
							<td>
								<?php 
									if(isset($badge['service_year'])) {
										echo $badge['service_year'] . " years";
									}
								?>
							</td>
						</tr>
					<?php $i++;}?>
				<?php } else {?>
					<tr>
						<td colspan="3" align="center">No badge</td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div> <!-- .portlet-content -->	
	<?php if($current_method=='order'&& count($order)>0){?>	
		<div class="portlet-content">
			<form action="<?php echo base_url();?>admin/order/detail/<?php echo $order->order_id;?>" method="post" id="order_detail_form">
				<select name="status" style="margin-bottom:5px">
					<option value="1" <?php echo ($order->order_status==1)?"selected":"";?>>Pending</option>
					<option value="2" <?php echo ($order->order_status==2)?"selected":"";?>>Approved</option>
					<option value="3" <?php echo ($order->order_status==3)?"selected":"";?>>Denied</option>
				</select>
				<div class="buttonrow">					
					<input type="submit" class="btn btn-grey process-order" value="Update" name="submit">
				</div>		 
			</form>
		</div>
	<?php }?>
	<?php if($current_method=='process'&& count($order)>0){?>
		<form action="<?php echo base_url();?>admin/process/detail/<?php echo $order->order_id;?>" method="post" id="process_detail_form">
		</form>
	<?php }?>
	
</div>
<script>
	$(document).ready(function(){
		$('.process-order').click(function(){
			var check_process = $(this).attr('value');			
			var input_process = "<input type='hidden' name='process' value='1'/>"; 		
			$('#process_detail_form').append(input_process);
			$('#process_detail_form').submit();
		});
	});
</script>