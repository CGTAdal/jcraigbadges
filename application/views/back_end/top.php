<?php if(isset($this->session->userdata['admin'])) {?>
	<div id="top">
		<div id="header">
			<h2 style="padding:20px;color:#fff">Name Badge Ordering Admin</h2>
			<div id="info">
				<h4>Welcome <?php echo $this->session->userdata['admin']->admin_login;?></h4>
				<p><a href="<?php echo base_url();?>admin/logout">Log out</a></p>
			</div>
		</div>
		<?php 
			$current_method = $this->uri->segment(2);	
			$role = $this->session->userdata('role');
		?>
		<div id="nav">				
			<ul class="mega-container mega-grey">
				<li class="mega <?php echo ($current_method=="order")?"mega-current":"";?>">
					<a href="<?php echo base_url();?>admin/order/listorders" class="mega-link">Order</a>	
				</li>
			</ul>
			<ul class="mega-container mega-grey">
				<li class="mega <?php echo ($current_method=="store")?"mega-current":"";?>">
					<a href="<?php echo base_url();?>admin/store/liststores" class="mega-link">Account</a>	
				</li>
			</ul>
			<?php if($role!=1){?>
			<ul class="mega-container mega-grey">
				<li class="mega <?php echo ($current_method=="process")?"mega-current":"";?>">
					<a href="<?php echo base_url();?>admin/process/listprocess" class="mega-link">Processing</a>	
				</li>
			</ul>
			<?php }?>
			<?php if($role==0){?>
			<ul class="mega-container mega-grey">
				<li class="mega <?php echo ($current_method=="staff")?"mega-current":"";?>">
					<a href="<?php echo base_url();?>admin/staff/listviews" class="mega-link">Manage Staff</a>	
				</li>
			</ul>
			<?php }?>
			<ul class="mega-container mega-grey">
				<li class="mega <?php echo ($current_method=="export")?"mega-current":"";?>">
					<a href="<?php echo base_url();?>admin/export/exportToExcel" class="mega-link">Store Manage</a>	
				</li>
			</ul>
		</div> <!-- #nav -->
	</div>
<?php }?>