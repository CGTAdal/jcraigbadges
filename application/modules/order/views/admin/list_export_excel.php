<table cellpadding="10" cellspacing="0" align="center">
	<thead>
		<tr>
			<th>Store ID</th>
			<th>Store Number</th>
			<th>Role</th>
			<th>Store Assigned</th>
		</tr>
	</thead>
	<?php if(count($results)>0) {?>
		<?php foreach($results as $val) {?>
			<tr>
				<td>
					<?php echo $val->store_id;?>
				</td>
				<td>
					<?php echo $val->store_number;?>
				</td>
				<td>
					<?php echo $val->store_role;?>
				</td>
				<td>
					<?php echo $val->store_assigned;?>
				</td>
			</tr>
		<?php }?>
	<?php } else {?>
		<tr class="fontGL row0">
			<td colspan="3">No store</td>
		</tr>				
	<?php }?>
</table>