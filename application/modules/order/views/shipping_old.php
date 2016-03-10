<div style="width:60%;border:solid 1px black;float:left">
	<div>
		<label>Shipping Address:</label>
		<div>
			TCP Store <?php echo $store->store_number;?>
			<br/>
			ATTN: <?php echo $store->store_attn;?>
			<br/>
			<?php echo $store->store_address;?>
			<br/>
			<?php echo $store->store_city.', '.$store->store_state.' '.$store->store_zip;?>
		</div>
	</div>
	<div>
		<label>Order Total: 
			<?php 
				echo $order_total;
				if($order_total>1) echo ' Badges';
				else echo 'Badge';
			?>
		</label>
	</div>
	<div>
		<a href="<?php echo base_url();?>order/add">Place Order</a>
	</div>
</div>
<div style="width:35%;border:solid 1px black;float:left">
	Your Order
	<div id="cart_list">
		<?php $i=1;foreach($cart as $c) {?>
			<div>
				<?php echo $i;?>
				<br/>
				Style: <?php echo $c['style'];?><br/>
				<?php echo (isset($c['name']))?'Name: '.$c['name'].'<br/>':'';?>
				<?php echo (isset($c['title']))?'Title: '.$c['title'].'<br/>':'';?>
				Fastener:
				<?php echo ($c['fastener']==1)?'Magnetic':'Pin';?>
			</div>
		<?php $i++;}?>
	</div>
</div>