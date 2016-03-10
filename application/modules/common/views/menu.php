<div class="header fontGL clb">
	<div class="clb mb-20 logo">
		<a href="<?php echo base_url();?>order/select"><img src="<?php echo base_url();?>application/views/front_end/images/logo.jpg" height="74" class="jcp fll" /></a>
		<a href="<?php echo base_url();?>order/select"><img src="<?php echo base_url();?>application/views/front_end/images/namebadge.png" class="namebadge" /></a>
	</div>
	<div class="clb">
		<div class="fll">
			Centre:
				<strong>
					<?php if($store->store_role==3) {?>
						<a href="<?php echo base_url();?>store/edit_account"><?php echo $store->store_number;?></a>
					<?php } else echo $store->store_number;?>
				</strong>
				<span class="split">&nbsp;</span>
			<a href="<?php echo base_url();?>order/listorders" class="txtB">View Previous Orders</a>
			<?php if($store->store_role==2) {?>
				<span class="split">&nbsp;</span>		
				<a href="<?php echo base_url();?>order/listapprovals" class="txtB">View Approvals <font <?php echo ($pending>0)?'style="color:red"':'';?>>(<?php echo $pending;?> pending)</font></a>
			<?php }?>
			<span class="split">&nbsp;</span>
			<a href="<?php echo base_url();?>order/select" class="txtB">Order Badges</a>
			<span class="split">&nbsp;</span>
			<?php if($store->store_role==3) {?>
				<a href="<?php echo base_url();?>store/edit_account" class="txtB">Change Address</a>
			<?php } ?>
		</div>
		<div class="flr">(<a href="<?php echo base_url();?>store/logout">Logout</a>)</div>
	</div>
</div>
