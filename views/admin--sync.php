<div class="wrap">
	<h1>Lightspeed Customer Sync</h1>
	<ul class="subsubsub">
		<li>
			<a href="<?= admin_url(); ?>tools.php?page=lightspeed-customer-sync&display=admin--settings">Change Auth Settings</a>
		</li>
	</ul>
	<div class="tablenav top">
		<div class="alignleft actions">
			<input type="submit" name="lightspeed_customer_sync_start_sync" id="lightspeed_customer_sync_start_sync" class="button" value="Start Sync">
		</div>
	</div>
	<table class="wp-list-table widefat fixed striped pages" id="lightspeed_customer_sync_table">
		<thead>
		<tr>
			<th class="manage-column column-title column-primary">
				Status
			</th>
			<th class="manage-column column-title column-primary">
				Date
			</th>
		</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>