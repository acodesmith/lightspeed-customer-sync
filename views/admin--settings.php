<?php

$client_id = ! empty( $client_id ) ? ( '*****************************' . substr($client_id, -4) ) : '';
$client_secret = ! empty( $client_secret ) ? ( '*****************************' . substr($client_secret, -4) ) : '';

?>
<div class="wrap">
	<h1>Lightspeed Customer Sync</h1>
	<form method="post">
		<input type="hidden" name="lightspeed_customer_sync_nonce" value="<?= wp_create_nonce('lightspeed_customer_sync_nonce'); ?>" />
		<table class="form-table">
			<tr>
				<th>Client ID</th>
				<td>
					<input name="lightspeed_customer_sync_client_id"
					       type="text"
					       id="lightspeed_customer_sync_client_id"
					       value="<?= $client_id; ?>"
					       class="regular-text">
				</td>
			</tr>
			<tr>
				<th>Client Secret</th>
				<td>
					<input name="lightspeed_customer_sync_client_secret"
					       type="text"
					       id="lightspeed_customer_sync_client_secret"
					       value="<?= $client_secret; ?>"
					       class="regular-text">
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
</div>