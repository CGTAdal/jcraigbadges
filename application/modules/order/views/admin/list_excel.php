<table cellpadding="10" cellspacing="0" align="center">
	<thead>
		<tr>
			<th>Order Date</th>
			<th>Order #</th>
			<th >Unit #</th>
			<th>Ship Date</th>
			<th>Item</th>
			<th>State</th>
			<th>Market #</th>
			<th>Badge Quantity</th>
			<th>Badge Total</th>
			<th>Tenured Quantity</th>
			<th>Tenured Total</th>
			<th>5-Pack Magnets</th>
			<th>5-Pack Pins</th>
			<th>Order Cost</th>
			<th>Tax</th>
			<th >Total</th>
			<th >Approved Date</th>
		</tr>
	</thead>
	<?php if(count($orders)>0) {?>
		<?php $i=0;foreach($orders as $order) {?>
			<tr>
				<td>
					<?php echo date('m/d/Y',$order->order_date);?>
				</td>
				<td>
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</td>
				<td><?php echo $order->store_number;?></td>
				<td><?php echo ($order->order_shipdate==0)?'pending':date('m/d/Y',$order->order_shipdate);?></td>
				<td>Name Badges</td>
				<td><?php echo $order->store_state;?></td>
				<td><?php echo $order->director_number;?></td>
				<td><?php echo $order->order_total?></td>
				<td>
					<?php echo number_format($order->order_total * 4.75, 2);?>
				</td>
				<td><?php echo $order->order_tenured_qty;?></td>
				<td>
					<?php echo number_format($order->order_tenured_qty * 6.25, 2);?>
				</td>
				<td><?php echo $order->order_mf_qty?></td>
				<td><?php echo $order->order_pf_qty?></td>
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
					<?php echo number_format($order->order_tax,2);?>
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
				<td><?php echo ($order->order_status==2)?date('m/d/Y',$order->order_approve_dated):'--';?></td>
			</tr>
		<?php $i++;}?>
	<?php } else {?>
		<tr class="fontGL row0">
			<td colspan="3">No order</td>
		</tr>				
	<?php }?>
</table>