<div class="main clb">
	<div class="main-left fll">
		<div class="badgeStyle overH mb-15">
			<h3 class="title">Select Badge Style</h3>
			<ul class="ul-main fontGL" id="badgeStyle">
				<?php $i=0;foreach($items as $item) {?>
					<li id="item_<?php echo $item->item_id;?>_<?php echo $item->item_type?>" class="items <?php echo ($i==0)?'badgeStyleActive':'';?>">
						<a href="javascript:void(0)">
							<span class="badgestyle-icon ">
								<img src="<?php echo base_url().$item->item_img;?>" />
							</span>
							<span id="name_item_<?php echo $item->item_id;?>"><?php echo $item->item_name;?></span>
						</a>
					</li>
				<?php $i=1;}?>
			</ul>
			<input type="hidden" id="selected_item_id" value="<?php echo $items[0]->item_id;?>"/>
			<input type="hidden" id="selected_item_type" value="<?php echo $items[0]->item_type;?>" />
		</div>
		<div class="overH clb" id="attributes_box" style="display:block">
			<h3 class="title">Enter Name:</h3>
			<div class="badgeOrder">
				<div id="generic_box" style="display:none">
					<div class="txtC mb-15">GENERIC BADGE</div>
					<div class="mb-15" style="padding-left:32px;">No Name or Title.<br />Will just say "customer service specialist"</div>
				</div>
				<label id="firstname_box">
					<span>First name:</span>
					<?php 
						$data = array(
							'name'	=> 'first_name',
							'size'	=> '50',
							'class'	=> 'first_name'			
						);
						echo form_input($data);
					?>
				</label>
				<label id="title_box" style="display:none">
					<span>Title:</span>
					<?php 
						$data = array(
					              'name'        => 'title',
					              'size'        => '50',
					            );
						echo form_input($data);
					?>
				</label>
				<label>
					<span>Fastener:</span>
					<label class="lblRadioCheckbox">
						<?php echo form_radio('fastener','1');?>Magnetic
					</label>
					<span class="split" style="width:auto;"></span>
					<label class="lblRadioCheckbox">
						<?php echo form_radio('fastener','2');?>Pin
					</label>
				</label>
				<label>
					<span class="mr-10">&nbsp;</span>
					<input type="button" id="add_name" value="Add to Order" />
				</label>
			</div>
		</div>
        <div class="order-new clb">
        	<h3 class="title">Enter Name:</h3>
            <div class="order-box clb">
            	<h3>Bagde 1</h3>
                <div style="padding-left:15px;">
                    <label id="firstname_box">
                        <span>First name:</span>
                        <input type="text" class="first_name" size="50" value="" name="first_name" id="acpro_inp2">				
                    </label>
                    <div>
                        <label class="lblRadioCheckbox">
                            <input type="radio" value="1" name="fastener">Magnetic
                        </label>
                        <span style="padding:0 25px;" class="split">&nbsp;</span>
                        <label class="lblRadioCheckbox">
                            <input type="radio" value="2" name="fastener">Pin
                        </label>
                        <span style="padding:0 10px;" class="split"></span>
                        <font color="#d6d6d6" size="+2">|</font>
                        <span style="padding:0 10px;" class="split"></span>
                        <strong>Speaks Spanish:</strong>
                        <span style="width:auto;" class="split"></span>
                        <label class="lblRadioCheckbox order-box-ss">
                            <input type="radio" value="2" name="ss">No
                        </label>
                        <span style="width:auto;" class="split"></span>
                        <label class="lblRadioCheckbox order-box-ss">
                            <input type="radio" value="2" name="ss">Yes
                        </label>
                    </div>
                </div>
            </div>
            <div class="order-box clb">
            	<h3>Bagde 1 <a href="#">(remove)</a></h3>
                <div style="padding-left:15px;">
                    <label id="firstname_box">
                        <span>First name:</span>
                        <input type="text" class="first_name" size="50" value="" name="first_name" id="acpro_inp2">				
                    </label>
                    <div>
                        <label class="lblRadioCheckbox">
                            <input type="radio" value="1" name="fastener">Magnetic
                        </label>
                        <span style="padding:0 25px;" class="split">&nbsp;</span>
                        <label class="lblRadioCheckbox">
                            <input type="radio" value="2" name="fastener">Pin
                        </label>
                        <span style="padding:0 10px;" class="split"></span>
                        <font color="#d6d6d6" size="+2">|</font>
                        <span style="padding:0 10px;" class="split"></span>
                        <strong>Speaks Spanish:</strong>
                        <span style="width:auto;" class="split"></span>
                        <label class="lblRadioCheckbox order-box-ss">
                            <input type="radio" value="2" name="ss">No
                        </label>
                        <span style="width:auto;" class="split"></span>
                        <label class="lblRadioCheckbox order-box-ss">
                            <input type="radio" value="2" name="ss">Yes
                        </label>
                    </div>
                </div>
            </div>
            <div class="clb txtC mb-5">&nbsp;</div>
            <div class="clb txtC mb-40"><a href="#" class="add-another">Add Another Name</a></div>
            <div class="clb txtC mb-15"><input type="button" value="Add Badges to Order" id="add_name"></div>
        </div>
	</div>
	<!--END main left-->
	<div class="main-right flr">
		<div class="yourOrder">
			<h3 class="title">Your Order:</h3>
			<ul class="ul-main mb-30" id="cart_list">
				<?php foreach($cart as $c) {?>
					<li>
						<p><strong>Style:</strong><?php echo $c['style'];?></p>
						<?php if(isset($c['name'])) {?>
							<p><strong>Name:</strong><?php echo $c['name'];?></p>
						<?php }?>
						<?php if(isset($c['title'])) {?>
							<p><strong>Title:</strong><?php echo $c['title'];?></p>
						<?php }?>
						<p><strong>Fastener:</strong><?php echo ($c['fastener']==1)?'Magnetic':'Pin';?></p>
					</li>
				<?php }?>
			</ul>
			<div class="txtC" id="continue_shipping" style="display:<?php echo (count($cart)<=0)?'none':'block';?>"><input type="button" name="" value="Continue to Shipping" /></div>
		</div>
	</div>
	<!--END main right-->
</div>
<script>
	$(document).ready(function(){
		$('.first_name').blur(function(){
			$(this).val($(this).val().toLowerCase());
		});
		
		$(".items").click(function(){
			$('.items').removeClass('badgeStyleActive');
			$(this).addClass('badgeStyleActive');
			$('#attributes_box').show();
			var item	= $(this).attr('id');
			item 		= item.split('_');
			var id		= item[1];
			var type 	= item[2];
			switch(type) {
				case '1':
					$("#firstname_box").show();
					$("#title_box").hide();
					$("#generic_box").hide();
					break;
				case '2':
					$("#firstname_box").show();
					$("#title_box").show();
					$("#generic_box").hide();
					break;
				case '3':
					$("#firstname_box").hide();
					$("#title_box").hide();
					$("#generic_box").show();
					break;
			}
			$("#selected_item_id").val(id);
			$("#selected_item_type").val(type); 
		})

		$('#add_name').click(function(){
			var itemId		= $("#selected_item_id").val();
			var type		= $("#selected_item_type").val();
			var style		= $('#name_item_'+itemId).html();
			var name		= $("input[name='first_name']").val().toLowerCase();
			var title		= $("input[name='title']").val();
			var fastener 	= $("input[name='fastener']:checked").val();
			if(fastener==undefined) {
				alert('Please select Fastener');
				return false;
			}
			
			//set popup values
			$('#confirm_style_value').html(style);			
			if(type!='3') {
				if(type=='2') {
					$("#confirm_name_value").html(name);
					$("#confirm_title_value").html(title);
					$("#confirm_name").show();
					$("#confirm_title").show();
				} else {
					$("#confirm_name_value").html(name);
					$("#confirm_name").show();
					$("#confirm_title").hide();
				}
			} else {
				$("#confirm_name").hide();
				$("#confirm_title").hide();
			}
			if(fastener==1) {
				$("#confirm_fastener_value").html('Magnetic');
			} else {
				$("#confirm_fastener_value").html('Pin');
			}
			$('#popup').show();

			$("#confirm_cancel").click(function(){
				$('#popup').hide();
			});

			$("#proceed").click(function(){
				$.post(
					'<?php echo base_url();?>order/orderajax/addItem',
					{itemId: itemId, name: name, title: title, fastener: fastener},
					function(data){
						var objdata	 = data;
						var new_item = "<li>";
						new_item += "<p><strong>Style:</strong>"+objdata.item['style']+"</p>";
						if(objdata.item['name']!==undefined) {
							new_item += "<p><strong>Name:</strong>"+objdata.item['name']+"</p>";
						}
						if(objdata.item['title']!==undefined) {
							new_item += "<p><strong>Title:</strong>"+objdata.item['title']+"</p>";
						}
						switch(objdata.item['fastener']) {
							case 1: new_item += "<p><strong>Fastener:</strong>Magnetic</p>";
							break;
							case 2: new_item += "<p><strong>Fastener:</strong>Pin</p>";
							break;
						}
						new_item += "</li>";
						$('#cart_list').append(new_item);
						$('#continue_shipping').show();
						$('#popup').hide();
					},
					'json'
				);
			});

		});

		$('#continue_shipping').click(function(){
			window.location="<?php echo base_url();?>order/shipping";
		});
	});
</script>