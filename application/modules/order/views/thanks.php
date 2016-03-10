 <div class="main clb">
	<div class="mb-40">&nbsp;</div>
	<div class="mb-30 txtC shipping">Order Number: <span class="fontGL"><?php echo $orderId;?></span></div>
	<div class="mb-30 txtC shipping fontGL">Thank you for your order. All orders are shipped within 5 business days. Please allow an additional 1 - 3 days for delivery.</div>
	<?php if(isset($account_type) ) {?>
		<div class="mb-30 txtC mb-30">
			<?php if($total_badges>0) {?>
				<div align="center">Total Badges: <?php echo ($total_badges);?> x $4.75</div>
			<?php }?>
			<?php if($total_tenured>0) {?>
				<div align="center">Total Tenured Badges: <?php echo ($total_tenured);?> x $6.25</div>
			<?php }?>
			<?php if($total_mf > 0) {?>
				<div align="center">Total 5-Pack Magnets: <?php echo $total_mf.' x $6.25';?></div>
			<?php }?>
			<?php if($total_pf > 0) {?>
				<div align="center">Total 5-Pack Pins: <?php echo $total_pf.' x $3.5';?></div>
			<?php }?>
			<?php 
				$tmp 	= explode('.',number_format($total_badges * 4.75 + $total_tenured * 6.25 + $total_mf * 6.25 + $total_pf * 3.5,2));
				$first 	= $tmp[0];
				$last	= $tmp[1];
				if($last > 0){
					$last = trim($last,'0');
				}
				$total_price = $first.'.'.$last;					
			?>
			<div align="center">Total for order #<?php echo $orderId;?>: $<?php echo $total_price;?></div>
		</div>
	<?php }?>
	<div class="mb-40">&nbsp;</div>
</div>