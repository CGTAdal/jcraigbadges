<?php if(count($badges) > 0) { ?> 
	<?php foreach($badges as $badge) {?>
		<li>
			<p><strong>Style:</strong><span><?php echo $badge['style'];?></span></p>
			<?php if(isset($badge['name'])) {?>
				<p><strong>Name:</strong><span><?php echo $badge['name'];?></span></p>
			<?php }?>
			<?php if(isset($badge['license'])) {?>
				<p><strong>License #:</strong><span><?php echo $badge['license'];?></span></p>
			<?php }?>
			<?php if(isset($badge['title'])) {?>
				<p><strong>Title:</strong><span><?php echo $badge['title'];?></span></p>
			<?php }?>
			<p><strong>Fastener:</strong><span><?php echo $badge['fastener'];?></span></p>
			<?php if(isset($badge['spk_spanish'])) {?>
				<p><strong>Hablo Español:</strong><span><?php echo $badge['spk_spanish'];?></span></p>
			<?php }?>
			<?php if(isset($badge['service_year'])) {?>
				<p><strong>Years Of Service</strong><span><?php echo $badge['service_year'];?> years</span></p>
			<?php }?>
			<a href="javascript:void(0);" class="remove_cart_badge">Remove</a>
		</li>
	<?php }?>
<?php }?>	


