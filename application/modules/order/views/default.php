<div class="main clb">
	<div class="<?php echo (count($cart)>0)?"main-left":"main-left-no-border";?> fll" id="main-left">
		<div class="badgeStyle overH mb-15">
			<h3 class="title">Select Badge Style </h3>
			<ul class="ul-main fontGL" id="badgeStyle">
				<?php foreach($items as $item) {?>
					<?php if($item->item_minor_required && !$store_minor) continue;?>
					<?php if($item->item_id==12 && $store_role==1) continue;?>
					<li id="item_<?php echo $item->item_id;?>_<?php echo $item->item_type?>" class="items <?php //echo ($i==0)?'badgeStyleActive':'';?>">
						<a href="javascript:void(0)">
							<span class="badgestyle-icon ">
								<img src="<?php echo base_url().$item->item_img;?>" />
							</span>
							<span id="name_item_<?php echo $item->item_id;?>"><?php echo $item->item_name;?></span>
						</a>
					</li>
				<?php }?>
				<?php if($store_minor) {?>
					<li>
						<div style="font-size:13px;color:#888;margin-top:3px;margin-bottom:5px">
							Certain states require minors under the age of 18 years of age to wear a blue badge
						</div>
					</li>
				<?php }?>
			</ul>
			<input type="hidden" id="selected_item_id" value="<?php echo $items[0]->item_id;?>"/>
			<input type="hidden" id="selected_item_type" value="<?php echo $items[0]->item_type;?>" />
		</div>
		<div class="qty-top">
        	<a href="javascript: void(0);" class="qty-click" id="select-extras-link">Click Here To Order Additional Fasteners</a> <img src="<?php echo base_url()?>application/views/front_end/images/qty-magnet.jpg" width="60" /> <img src="<?php echo base_url()?>application/views/front_end/images/qty-pin.jpg" width="60" />
        </div>
        <div class="qty-add clb" id="extras-boxes" style="display:none">
        	<h3 class="title">Enter Fastener Quantities:</h3>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/qty-magnet.jpg" />
            	<label>
            		<input type="text" id="extras-magnet-qty" value=""/> Enter Quantity Magnet <div style="padding-left:120px">Pack of 5</div>
            	</label>
            </div>
            <div class="qty-item clb">
            	<img src="<?php echo base_url()?>application/views/front_end/images/qty-pin.jpg" />
            	<label>
            		<input type="text" id="extras-pin-qty" value=""/> Enter Quantity Pin <div style="padding-left:120px">Pack of 5</div>
            	</label>
            </div>
            <div class="clb">&nbsp;</div>
            <div class="txtC mb-15"><input type="button" id="add_fasteners" value="Add Fasteners to Order"></div>
        </div>
		<div id="enter-names-field">
		</div>
	</div>
	<!--END main left-->
	<div class="main-right flr" style="display:<?php echo (count($cart) + $mf_qty + $pf_qty >0)?"block":"none";?>">		
		<div class="yourOrder" id = "your_order">		
			<h3 class="title">Your Order: </h3>			
			<div class="txtC" id="continue_shipping" style="display:<?php echo (count($cart)<=0)?'none':'block';?>">
				<input type="button" name="" value="Continue to Shipping" />
			</div><br>
			<h3 class="title no-border" id="badge-title" style="display:<?php echo (isset($cart['badges']))?"block":"none"?>">Badges:</h3>
			<ul class="ul-main mb-30" id="badge_list">
				<?php if(isset($cart['badges'])) {?>
					<?php foreach($cart['badges'] as $badge) {?>
						<li>
							<p><strong>Style:</strong><span><?php echo $badge['style'];?></span></p>
							<?php if(isset($badge['name'])) {?>
								<p><strong >Name:</strong><span><?php echo $badge['name'];?></span></p>
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
								<p><strong>Years Of Service:</strong><span><?php echo $badge['service_year'];?> years</span></p>							
							<?php }?>
							<a href="javascript:void(0);" class="remove_cart_badge">Remove</a>
						</li>
					<?php }?>
				<?php }?>
			</ul>
			<h3 class="title no-border" id="extras-title" style="display:<?php echo ($mf_qty + $pf_qty > 0)?"block":"none";?>">Extras:</h3>		
			<ul class="ul-main mb-30" id="extras_list">
				<?php if($mf_qty > 0) {?>
					<li>
						<p><strong>Item:</strong><span>5-Pack Magnets</span></p>
						<p><strong>Quantity:</strong><span><?php echo $cart['order_mf_qty'];?></span></p>
						<a href="javascript:void(0);" class="remove_cart_extras" value="1">Remove</a>
					</li>
				<?php }?>
				<?php if($pf_qty > 0) {?>
					<li>
						<p><strong>Item:</strong><span>5-Pack Pins</span></p>
						<p><strong>Quantity:</strong><span><?php echo $cart['order_pf_qty'];?></span></p>
						<a href="javascript:void(0);" class="remove_cart_extras" value="2">Remove</a>
					</li>
				<?php }?>
			</ul>
			<div class ="txt_remove" >
				<a id="empty-cart" href="javascript:void(0);">Click Here To Clear Entire Order</a>
			</div>
			<div class="txtC" id="continue_shipping_two" style="display:<?php echo (count($cart)<=0)?'none':'block';?>"><input type="button" name="" value="Continue to Shipping" /></div>
		</div>
	</div>
	<!--END main right-->
</div>
<script>
	$(document).ready(function(){
		// add more name
		$('.add-another').live('click',function(){			
			var current_input_boxes_number = $('#current_input_boxes_number').val();			
			var type = $(this).attr('value');			
			$.post(
				'<?php echo base_url();?>order/ajax/addInputBox',
				{current_input_boxes_number: current_input_boxes_number, type: type},
				function(data) {
					$("#input_boxes").append(data);
					$("#current_input_boxes_number").val(parseInt(current_input_boxes_number) + 1);
				}
			);
		});
		
		// convert first name to lower case
		$('.first_name').live('blur',function(){
			$(this).val($(this).val().toUpperCase());
		});

		// change field input-names
		$(".items").click(function(){
			$('.items').removeClass('badgeStyleActive');
			$(this).addClass('badgeStyleActive');
			$('#extras-boxes').hide();
			var item	= $(this).attr('id');
			item 		= item.split('_');
			var id		= item[1];
			var type 	= item[2];
			$.post(
				"<?php echo base_url();?>order/ajax/showNamesField",
				{type: type},
				function(data) {
					$("#enter-names-field").html(data);
				}		
			);
			return;
		})

		// add badges to confirm box
		$('#add_names').live('click',function(){	
			var i = 0;
			var j = 0;
			var k = 0;
			$('.input_box').each(function(){
				var box_id		= $(this).attr('value');					
				var style		= $('#style_'+box_id).val();
				var name		= $('input[name=first_name_'+box_id+']').val();
				var license		= $('input[name=license_'+box_id+']').val();

				if(name != '' && box_id >= j){
					i=0;
					j=0;
					var title			= $('#title_'+box_id).val();
					var fastener 		= $("input[name=fastener_"+box_id+"]:checked").val();
					var spk_spanish		= $("input[name=speaks_spanish_"+box_id+"]:checked").val();
					var service_year	= $("#years_of_service_"+box_id).val();
						
					var new_value	= '<div class="orderConfirm mb-30">';
					new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span></p>';
					new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
					if(title!=undefined) {
						new_value		+= '<p><strong>Title:</strong><span class="badge_title">'+title+'</span></p>';
					}
					if(license!=undefined) {
						new_value		+= '<p><strong>License #:</strong><span class="badge_license">'+license+'</span></p>';
					}
					new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
					if(spk_spanish!=undefined) {
						new_value		+= '<p><strong>Hablo Español:</strong><span class="badge_spk_spanish">'+spk_spanish+'</span></p></div>';
					}
					if(service_year!=undefined) {
						new_value		+= '<p><strong>Years Of Service:</strong><span class="badge_service_year">'+service_year+' years</span></p></div>';
					}
					$('#popup_values').append(new_value);

					if(style=='optical' && license!="") {
						k++;
					}			
				}
				
				if(name == ''){
					i++;
					j=box_id;
					alert('Please enter first name only for badge: '+box_id);						
					$('input[name=first_name_'+box_id+']').focus();					
					return false;
				}
			});
			
			if(i==0){		
				$(".overlay").height($(document).height());
				$('#popup').show();
				$("#confirm_cancel").click(function(){
					$('.orderConfirm').remove();
					$('#popup').hide();
				});
			}
						
		});
		
		$('#add_generic_names').live('click',function(){
			var count_magnetic 	= 0;
			var count_pin		= 0;
			$('.generic_magnetic_quantity').each(function(){
				var style	 = "generic (no name)";
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Magnetic";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_magnetic += quantity;
				}
			});
			$('.generic_pin_quantity').each(function(){
				var style	 = "generic (no name)";
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Pin";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_pin += quantity;
				}
			});
			if(count_magnetic + count_pin > 0) {
				$(".overlay").height($(document).height());
				$('#popup').show();
				$("#confirm_cancel").click(function(){
					$('.orderConfirm').remove();
					$('#popup').hide();
				});
			} else {
				alert('Please enter numeric value');
			}
		});
		
		$('#add_minor_names').live('click',function(){
			var count_magnetic 	= 0;
			var count_pin		= 0;
			$('.minor_magnetic_quantity').each(function(){
				var style	 = "minor generic (no name)";
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Magnetic";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_magnetic += quantity;
				}
			});
			$('.minor_pin_quantity').each(function(){
				var style	 = "minor generic (no name)";
				var name	 = $('.badge_name',$(this).parent().parent()).val();
				var fastener = "Pin";
				var quantity = parseInt($(this).val());
				if(quantity>0) {
					for(i=0;i<quantity;i++) {
						var new_value	= '<div class="orderConfirm mb-30">';
						new_value		+= '<p><strong>Style:</strong><span class="badge_style">'+style+'</span></p>';
						new_value		+= '<p><strong>Name:</strong><span class="badge_name">'+name+'</span></p>';
						new_value		+= '<p><strong>Fastener:</strong><span class="badge_fastener">'+fastener+'</span></p>';
						$('#popup_values').append(new_value);
					}
					count_pin += quantity;
				}
			});
			if(count_magnetic + count_pin > 0) {
				$(".overlay").height($(document).height());
				$('#popup').show();
				$("#confirm_cancel").click(function(){
					$('.orderConfirm').remove();
					$('#popup').hide();
				});
			} else {
				alert('Please enter numeric value');
			}
		});
		
		$("#proceed").live('click',function(){
			var order_style 		= new Array();
			var order_name 			= new Array();
			var order_title			= new Array();
			var order_license		= new Array();
			var order_fastener 		= new Array();
			var order_spk_spanish 	= new Array();
			var order_service_year	= new Array();
			$('.orderConfirm').each(function(){
				var style			= $('.badge_style',$(this)).html();
				var name			= $('.badge_name',$(this)).html();
				var title			= $('.badge_title',$(this)).html();
				var license			= $('.badge_license',$(this)).html();
				var fastener		= $('.badge_fastener',$(this)).html();
				var spk_spanish		= $('.badge_spk_spanish',$(this)).html();
				var service_year	= $('.badge_service_year',$(this)).html();
				
				order_style.push(style);
				if(license!=null) {
					order_license.push(license);
				}
				order_name.push(name);
				if(title!=null) {
					order_title.push(title);
				}
				order_fastener.push(fastener);
				if(spk_spanish!=null) {
					order_spk_spanish.push(spk_spanish);
				}
				if(service_year!=null) {
					order_service_year.push(parseInt(service_year));
				}
			});
			$.post(
				"<?php echo base_url();?>order/ajax/addBadgesToCart",
				{styles:order_style, names: order_name,titles: order_title, licenses: order_license, fasteners: order_fastener, spk_spanish: order_spk_spanish, service_year: order_service_year},
				function(data) {
					$('#badge_list').append(data);
					$('#badge-title').show();
					$('#main-left').removeClass('main-left-no-border');
					$('#main-left').addClass('main-left');

					$('#your_order').show();
					$('#continue_shipping').show();
					$('#continue_shipping_two').show();
					$('.main-right').show();
					$('.orderConfirm').remove();
					$('#popup').hide();
				}
			);
			
		});
		
		$('#continue_shipping').click(function(){
			window.location="<?php echo base_url();?>order/shipping";
		});	

		$('#continue_shipping_two').click(function(){
			window.location="<?php echo base_url();?>order/shipping";
		});
		//reomove orders
		$('.remove_cart_badge').live('click', function (){
			var parent = $(this).parent();
			var item_id = $('#badge_list li').index(parent);
			$.post(
				'<?php echo base_url();?>order/ajax/deleteBadge',
				{item_id: item_id},					
				function(){
					var size = $('#badge_list li').size();
					if(size == 1){
						window.location.href = '<?php echo base_url();?>order/select';
					}
					parent.remove();
				}
			);									
		});
		$('.remove_input_box').live('click',function(){
			var current_input_boxes_number = $('#current_input_boxes_number').val();
			current_input_boxes_number = current_input_boxes_number-1;
			$('#current_input_boxes_number').val(current_input_boxes_number);
			$(this).parent().parent().remove();			
			var i = 1;
			$(".input_box").each(function(){
				if(i!=1) {
					var h3 = jQuery(this).find("h3");
					h3.html('Badge '+i+' <a href="javascript: void(0)" class="remove_input_box">(remove)</a>');
				}
				i++;
			});
		});
		
		// Clears all Orders 
		$('#empty-cart').live('click',function(){
			$(".overlay").height($(document).height());
			$('#popup2').show();
		});
		
		// Confirm Clears Orders
		$('#confirm_delete_cart').live('click',function(){	
			var parent = $('.remove_cart_item').parent();		
			$.post(
				"<?php echo base_url();?>order/ajax/deleteCart",
				"",
				function(data){
					window.location.href = '<?php echo base_url();?>order/select';
				}
			);
		});
		
		$('#cancel_delete_cart').live('click',function(){
			$('#popup2').hide();
		});

		$('#select-extras-link').click(function(){
			$('#extras-boxes').toggle();
			$('.items').removeClass('badgeStyleActive');
			$('#enter-names-field').html('');
		});

		$('#add_fasteners').click(function(){
			var extras_magnet_qty 	= ($('#extras-magnet-qty').val());
			var extras_pin_qty 		= ($('#extras-pin-qty').val());

			if(extras_magnet_qty == "" && extras_pin_qty == "") {
				alert('Please enter quantity magnet or quantity pin');
				return; 
			}
			if((extras_magnet_qty!="" && isNaN(parseInt(extras_magnet_qty))) || (extras_pin_qty!=""&&isNaN(parseInt(extras_pin_qty)))) {
				alert('Please enter numeric value');
				return;
			} 
			if((extras_pin_qty=="0" && isNaN(parseInt(extras_magnet_qty))) || (extras_magnet_qty=="0"&&isNaN(parseInt(extras_pin_qty))) || (extras_magnet_qty=="0"&&extras_pin_qty=="0")) {
				alert('Fastener quantity must greater than zero');
				return;
			}
			$.post(
				"<?php echo base_url();?>order/ajax/addExtrasToCart",
				{magnet_qty: extras_magnet_qty, pin_qty: extras_pin_qty},
				function(data) {
					$('#extras_list').html(data);
					$('#extras-title').show();
					$('#main-left').removeClass('main-left-no-border');
					$('#main-left').addClass('main-left');

					$('#your_order').show();
					$('#continue_shipping').show();
					$('#continue_shipping_two').show();
					$('.main-right').show();
				}
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
						window.location.href = '<?php echo base_url();?>order/select';
					}
				},
				'json'
			);
			$(this).parent().remove();
			return;			
		});
		
		$('.license-optical').live('keyup',function(){
			if($(this).val()!="") {
				$('.speaks_spanish_yes',$(this).parent().parent()).prop('checked',false); 
				$('.speaks_spanish_no',$(this).parent().parent()).prop('checked',true);
				$('.speaks_spanish_yes',$(this).parent().parent()).prop('disabled',true);
			} else {
				$('.speaks_spanish_yes',$(this).parent().parent()).prop('disabled',false);
			}
			
		});
	});
</script>