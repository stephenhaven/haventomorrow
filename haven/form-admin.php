<?php 

$results = $wpdb->get_results( 'SELECT * FROM wp_ht_recurring WHERE postid = ' . $id . ' LIMIT 1', OBJECT );

$encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
$encryptionKey = "2thlsa2345c6c324sakdhu123kljfg312s";

$decrypt_finance_cc = openssl_decrypt($results[0]->finance_cc, $encryptionMethod, $encryptionKey);
$decrypt_finance_cc_cvc = openssl_decrypt($results[0]->finance_cc_cvc, $encryptionMethod, $encryptionKey);
$decrypt_finance_routing = openssl_decrypt($results[0]->finance_routing, $encryptionMethod, $encryptionKey);
$decrypt_finance_account = openssl_decrypt($results[0]->finance_account, $encryptionMethod, $encryptionKey);

?>
<style>
.recurring tbody>:nth-child(odd) {background-color:#f9f9f9;}
</style>

<div style="height:30px; display:block;">
<a href="javascript:window.print()" style="float:right; margin:20px 0 0;" class="button-secondary">Print Page</a>
</div>

<div class="recurring">
	<h1>Personal Info</h1>
	<table class="widefat">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
	   <tr>
		 <td>First Name</td>
		 <td><?php echo $results[0]->pi_firstname; ?></td>
	   </tr>
	   <tr>
		 <td>Last Name</td>
		 <td><?php echo $results[0]->pi_lastname; ?></td>
	   </tr>
	   <tr>
		 <td>Email</td>
		 <td><?php echo $results[0]->pi_email; ?></td>
	   </tr>
	   <tr>
		 <td>Phone</td>
		 <td><?php echo $results[0]->pi_phone; ?></td>
	   </tr>
	   <tr>
		 <td>Questions & Comments</td>
		 <td><?php echo $results[0]->pi_questions; ?></td>
	   </tr>
	</tbody>
	</table>
	<br /><br />

	<h1>Billing Address</h1>
	<table class="widefat">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
	   <tr>
		 <td>Address</td>
		 <td><?php echo $results[0]->ba_street; ?></td>
	   </tr>
	   <tr>
		 <td>Address Additional</td>
		 <td><?php echo $results[0]->ba_streetadditional; ?></td>
	   </tr>
	   <tr>
		 <td>City</td>
		 <td><?php echo $results[0]->ba_city; ?></td>
	   </tr>
	   <tr>
		 <td>State</td>
		 <td><?php echo $results[0]->ba_state; ?></td>
	   </tr>
	   <tr>
		 <td>Zip</td>
		 <td><?php echo $results[0]->ba_zip; ?></td>
	   </tr>
	   <tr>
		 <td>Country</td>
		 <td><?php echo $results[0]->ba_country; ?></td>
	   </tr>
	</tbody>
	</table>
	<br /><br />

	<h1>Shipping Address</h1>
	<table class="widefat">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
	   <tr>
		 <td>First Name</td>
		 <td><?php echo $results[0]->sa_firstname; ?></td>
	   </tr>
	   <tr>
		 <td>Last Name</td>
		 <td><?php echo $results[0]->sa_lastname; ?></td>
	   </tr>
	   <tr>
		 <td>Address</td>
		 <td><?php echo $results[0]->sa_street; ?></td>
	   </tr>
	   <tr>
		 <td>Address Additional</td>
		 <td><?php echo $results[0]->sa_streetadditional; ?></td>
	   </tr>
	   <tr>
		 <td>City</td>
		 <td><?php echo $results[0]->sa_city; ?></td>
	   </tr>
	   <tr>
		 <td>State</td>
		 <td><?php echo $results[0]->sa_state; ?></td>
	   </tr>
	   <tr>
		 <td>Zip</td>
		 <td><?php echo $results[0]->sa_zip; ?></td>
	   </tr>
	   <tr>
		 <td>Country</td>
		 <td><?php echo $results[0]->sa_country; ?></td>
	   </tr>
	</tbody>
	</table>
	<br /><br />

	<h1>Financial Info</h1>
	<table class="widefat">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
	   <tr>
		 <td>Donation Price</td>
		 <td><?php echo $results[0]->price; ?></td>
	   </tr>   
	   <tr>
		 <td>Bank Name</td>
		 <td><?php echo $results[0]->finance_bank; ?></td>
	   </tr>
	   <tr>
		 <td>Account Type</td>
		 <td><?php echo $results[0]->finance_accounttype; ?></td>
	   </tr>
	   <tr>
		 <td>Name on Account</td>
		 <td><?php echo $results[0]->finance_accountname; ?></td>
	   </tr>
	   <tr>
		 <td>Routing #</td>
		 <td><?php echo $decrypt_finance_routing; ?></td>
	   </tr>
	   <tr>
		 <td>Account #</td>
		 <td><?php echo $decrypt_finance_account; ?></td>
	   </tr>
	   <tr>
		 <td>Credit Card #</td>
		 <td><?php echo $decrypt_finance_cc; ?></td>
	   </tr>
	   <tr>
		 <td>Credit Card Month</td>
		 <td><?php echo $results[0]->finance_cc_month; ?></td>
	   </tr>
	   <tr>
		 <td>Credit Card Year</td>
		 <td><?php echo $results[0]->finance_cc_year; ?></td>
	   </tr>
	   <tr>
		 <td>Credit Card CVC</td>
		 <td><?php echo $decrypt_finance_cc_cvc; ?></td>
	   </tr>
	   <tr>
		 <td colspan="2">Process donation on the <b><?php echo $results[0]->finance_process; ?></b> of each month.</td>
	   </tr>
	   <tr>
		 <td>Security Question</td>
		 <td><?php echo $results[0]->finance_securityquestion; ?></td>
	   </tr>
	   <tr>
		 <td>Security Answer</td>
		 <td><?php echo $results[0]->finance_securityanswer; ?></td>
	   </tr>
	   <tr>
		 <td>Where do you primarily listen to Haven Today?</td>
		 <td><?php echo $results[0]->stations; ?></td>
	   </tr>
	   <tr>
		 <td>Benefits Preference</td>
		 <td><?php 
			if ($results[0]->optin == true){
				echo 'Yes, Please send monthly benefits and products automatically.';
			} else {
				echo 'No, Please do not send me any products automatically.';
			}?>
		 </td>
	   </tr>
	</tbody>
	</table>
	<br /><br />

	<h1>Linked Product</h1>
	<table class="widefat">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
	   <tr>
		 <td width="30%">ID</td>
		 <td width="70%"><?php echo $results[0]->lp_id; ?></td>
	   </tr>
	   <tr>
		 <td>Title</td>
		 <td><?php echo $results[0]->lp_title; ?></td>
	   </tr>
	   <tr>
		 <td>Link</td>
		 <td><a href="<?php echo $results[0]->lp_link; ?>" target="_blank"><?php echo $results[0]->lp_link; ?></a></td>
	   </tr>
	</tbody>
	</table>
	<br /><br />
</div>