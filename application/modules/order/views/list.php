<style>
.order{cursor:pointer;}
</style>
<div class="main clb">
	<div class="txtC shipping mb-40">
		<table cellpadding="10" cellspacing="0" align="center">
			<tr>
				<th>Order #</th>
				<th>Date</th>
				<th>Standard Badge Qty</th>
				<th>Tenured Badge Qty</th>
				<th>5-Pack Magnets</th>
				<th>5-Pack Pins</th>
				<th>Ship Date</th>
			</tr>
			<?php if(count($orders)>0) {?>
				<?php $i=0;foreach($orders as $order) {?>
					<tr class="fontGL <?php echo ($i%2==0)?'row0':'row1';?> order" value="<?php echo $order->order_id;?>">
						<td>
							<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
						</td>
						<td align="center"><?php echo date('n/j/Y',$order->order_date);?></td>
						<td align="center"><?php echo $order->order_total?></td>
						<td align="center"><?php echo $order->order_tenured_qty;?></td>
						<td align="center"><?php echo $order->order_mf_qty?></td>
						<td align="center"><?php echo $order->order_pf_qty?></td>
						<td align="center"><?php echo ($order->order_shipdate==0)?'pending':date('n/j/Y',$order->order_shipdate);?></td>
					</tr>
				<?php $i++;}?>
			<?php } else {?>
				<tr class="fontGL row0">
					<td colspan="6">No order</td>
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