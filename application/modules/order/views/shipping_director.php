<div class="main clb">
	<div class="main-left fll">
		<div class="clb shipping">
			<h3 class="title">Shipping Address:</h3>
			<div class="pl-20 fontGL mb-30">
				<div style="margin-bottom:10px">Jenny Craig Centre
					<select name="" id="select_store">
						<option value="">select</option>
						<?php foreach($sub_stores as $s) {?>
							<option value="<?php echo $s->store_id;?>"><?php echo $s->store_number;?></option>
						<?php }?>
					</select>
				</div>
				<div id="shipping_address">
				</div>
			</div>
			<div class="txtC fontGL mb-20">Please Check Your Order One Last Time!</div>
			<div class="txtC mb-20">I authorize this order (please enter your <font color="red">FULL</font> name):</div>
			<div class="txtC mb-20"><input class ="order_customer" type="text" style="font-size:16px"/></div>
			<div class="txtC">
				<input type="button" id="place_order" value="Place Order" />
			</div>
			<form action="<?php echo base_url();?>order/add" method="post" id="form_order_customer">
			</form>
		</div>
	</div>
	<!--END main left-->
	<?php
		$order_box = Modules::run('order/detailOrderBox');
		echo $order_box;
	?>
	
	<!--END main right-->
	<input type="hidden" id="store_id" value="<?php echo $store->store_id;?>" />
</div>
<!--END main-->
<script>
	$(document).ready(function(){
		$('#place_order').click(function(){
			var selected_store = $('#select_store');
			if(selected_store.val() == '') {
				alert('Please select store');
				select_store.focus();
				return false;
			}
				
			var order_customer = $('.order_customer').val();			
			if(order_customer == ''){
				alert('You must enter your name into the authorization box to continue','');				
			}else{
				var input_order_customer = "<input type='hidden' name='order_customer' value='"+order_customer+"' />";
				$('#form_order_customer').append(input_order_customer);
				var input_selected_store = "<input type='hidden' name='selected_store' value='"+selected_store.val()+"' />";
				$('#form_order_customer').append(input_selected_store);
				$('#form_order_customer').submit();
			}	
		});

		$('#select_store').change(function(){
			var selected_store = $(this).val();
			$.post(
				'<?php echo base_url();?>order/ajax/changeStoreShippingAddress',
				{store_id: selected_store},					
				function(data){
					$('#shipping_address').html(data);	
				}
			);		
		});
	});
	// Remove cart Item in function Shipping
	$('.remove_cart_item_shipping').live('click', function (){
		var size = $('#shipping_list li').size();
		var parent = $(this).parent();
		var item_id = $('#shipping_list li').index(parent);
		$.post(
			'<?php echo base_url();?>order/ajax/deleteBadge',
			{item_id: item_id},					
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

	$('.remove_cart_extras').live('click',function(){
		var type = $(this).attr('value');
		$.post(
			"<?php echo base_url();?>order/ajax/deleteExtras",
			{type: type},
			function(data){
				// code here
				if(data.total_extras=='0') {
					$('#extras-title').remove();
					$('#extras_list').remove();
				}
				$('#total-order-price').html(data.total_order_price);
			},
			'json'
		);
		$(this).parent().remove();
		if(type=='magnetic fastener') $('#total-magnetics').remove();
		else if(type=='pin fastener') $('#total-pins').remove();
		return;			
	});
	
</script>