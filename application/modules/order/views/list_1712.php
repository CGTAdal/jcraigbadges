<style>
.order{cursor:pointer;}
</style>
<div class="main clb">
	<div class="txtC shipping mb-40">
		<table cellpadding="10" cellspacing="0" align="center">
			<tr>
				<th>Order #</th>
				<?php if($this->session->userdata['store']->store_role!=1) {?><th>Store</th><?php }?>
				<th>Date</th>
				<th>Badge Quantity</th>
				<th>5-Pack Magnets</th>
				<th>5-Pack Pins</th>
				<?php if($this->session->userdata['store']->store_role!=1) {?>
					<th>Status</th>
				<?php } else {?>
					<th>Ship Date</th>
				<?php }?>
			</tr>
			<?php if(count($orders)>0) {?>
				<?php $i=0;foreach($orders as $order) {?>
					<tr class="fontGL <?php echo ($i%2==0)?'row0':'row1';?> order" value="<?php echo $order->order_id;?>">
						<td>
							<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
						</td>
						
						<?php if($this->session->userdata['store']->store_role!=1) {?>
							<td>
								<?php echo $order->store_number;?>
							</td>
						<?php }?>
						<td align="center"><?php echo date('n/j/Y',$order->order_date);?></td>
						<td align="center"><?php echo $order->order_total?></td>
						<td align="center"><?php echo $order->order_mf_qty?></td>
						<td align="center"><?php echo $order->order_pf_qty?></td>
						<?php if($this->session->userdata['store']->store_role!=1) {?>
							<td>
								<?php 
									switch($order->order_status) {
										case '1': echo 'Pending';
										break;
										case '2': echo 'Approved';
										break;
										case '3': echo 'Denied';
										break;
									};
								?>
							</td>
						<?php } else {?>
							<td align="center"><?php echo ($order->order_shipdate==0)?'pending':date('n/j/Y',$order->order_shipdate);?></td>
						<?php }?>
					</tr>
				<?php $i++;}?>
			<?php } else {?>
				<tr class="fontGL row0">
					<td colspan="7">No order</td>
				</tr>
			<?php }?>
		</table>
	</div>
	<div class="mb-40">&nbsp;</div>
</div>
<!--END main-->
<script>
	$(document).ready(function(){
		$('.order').click(function(){
			var order_id = $(this).attr('value');
			window.location="<?php echo base_url();?>order/detail/"+order_id;
		});
	});
</script>