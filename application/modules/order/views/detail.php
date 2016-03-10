<?php if(count($order)>0) {?>
	<div class="main clb">
		<div class="txtC mb-30">
			<div class="view-order">
				Order #:
				<span class="fontGL">
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</span>
				<span class="split"> </span>
				Order Date: <span class="fontGL"><?php echo date('n/j/Y',$order->order_date);?></span>
			</div>
		</div>
		<div class="main-left fll">
			<div class="clb shipping">
				<h3 class="title">Shipping Address: </h3>
				<div class="pl-20 fontGL mb-30">					
					<div>Jenny Craig Centre <?php echo $shipping['selected_store'];?></div>
					<div>ATTN:  <?php echo $shipping['attn'];?></div>
					<div><?php echo $shipping['address'];?></div>
					<div><?php echo isset($shipping['address_2']) ? $shipping['address_2'] : "";?></div>
					<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
				</div>
				<?php if($order->store_role!=3) {?>
					<h3 class="title">Order Placed By: <?php echo ($order->order_customer!='')?$order->order_customer:'';?></h3>
				<?php } else {?>
					<h3 class="title">Billing Address: </h3>
					<div class="pl-20 fontGL mb-30">					
						<div><?php echo $billing['fname'].' '.$billing['lname'];?></div>
						<div><?php echo $billing['phone'];?></div>
						<div><?php echo $billing['address'];?></div>
						<div><?php echo $billing['city'].', '.$billing['state'].' '.$billing['zip'];?></div>
					</div>
					<h3 class="title">Order Total:</h3>
					<div class="pl-20 fontGL mb-30">
						<?php if($total_badges>0) {?>
							<div>Total Badges: <font id=""><?php echo ($total_badges);?></font> x $4.75</div>
						<?php }?>
						<?php if($total_tenured>0) {?>
							<div>Total Tenured Badges: <font id=""><?php echo ($total_tenured);?></font> x $6.25</div>
						<?php }?>
						<?php if($total_mf > 0) {?>
							<div id="total-magnetics">Total 5-Pack Magnets: <?php echo $total_mf.' x $6.25';?></div>
						<?php }?>
						<?php if($total_pf > 0) {?>
							<div id="total-pins">Total 5-Pack Pins: <?php echo $total_pf.' x $3.5';?></div>
						<?php }?>
						<?php 
							$tmp 	= explode('.',number_format($total_badges*4.75 + $total_tenured * 6.25 + $total_mf*6.25 + $total_pf*3.5,2));
							$first 	= $tmp[0];
							$last	= $tmp[1];
							if($last > 0){
								$last = trim($last,'0');
							}
							$total_price = $first.'.'.$last;					
						?>
						<div>Total: $<font id="total-order-price"><?php echo $total_price;?></font></div>
					</div>
				<?php }?>
			</div>
		</div>
		<!--END main left-->
		<?php
			$order_box = Modules::run('order/detailOrderBox');
			echo $order_box; 
		?>
		<!--END main right-->
	</div>
<?php } else {?>
	<div class="main clb"><div style="padding-left:400px">No order found.</div></div>
<?php }?>
<!--END main-->