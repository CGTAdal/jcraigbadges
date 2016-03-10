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
					<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
				</div>
				<h3 class="title">Order Placed By: <?php echo ($order->order_customer!='')?$order->order_customer:'';?></h3>
				<form action="" method="post" name="order_form">
					<div style="margin-top:100px">
						<?php if($order->order_status!=2) {?>
							<?php if($order->order_status!=3) {?>
								<input type="submit" id="place_order" value="DENY" name="submit"/>
							<?php }?>
							<input type="submit" id="place_order" value="APPROVE" name="submit"/>
						<?php }?>
					</div>
				</form>
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
<script>
	$(document).ready(function(){
		// Remove cart Item in function Shipping
		$('.remove_approval_item').live('click', function (){
			var size = $('#shipping_list li').size();
			var parent = $(this).parent();
			var item_id = $('#shipping_list li').index(parent);
			$.post(
				'<?php echo base_url();?>order/ajax/deleteApprovalBadge',
				{item_id: item_id, order_id: <?php echo $this->uri->segment(3);?>},					
				function(data){
					var size = $('#shipping_list li').size();				
					if(size-1 > 0){
						$('#total-badges-number').html(data.total_badges);
						$('#total-order-price').html(data.total_order_price);	
					}else{
						$('#total-badges-number').parent().remove();
						$('#total-order-price').html(data.total_order_price);
						$('#badge-title').remove();
						$('#shipping_list').remove();			
					}
					parent.remove();
				},
				'json'
			);									
		});

		$('.remove_approval_extras').live('click',function(){
			var type = $(this).attr('value');
			$.post(
				"<?php echo base_url();?>order/ajax/deleteApprovalExtras",
				{type: type,order_id: <?php echo $this->uri->segment(3);?>},
				function(data){
					// code here
					if(data.total_extras=='0') {
						window.location.href = '<?php echo base_url();?>order/approvaldetail/<?php echo $order->order_id;?>';
					}
				},
				'json'
			);
			$(this).parent().remove();
			return;			
		});
	});
</script>
<!--END main-->
