<?php
//process form and authorize
error_reporting(E_ALL);

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';

global $wpdb;
global $wp_query;

$encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
$encryptionKey = "2thlsa2345c6c324sakdhu123kljfg312s";

$current_date = date('m/d/Y');
$recurring_title = 'Recurring Giving - ' . $current_date;

$referer = $_SERVER['HTTP_REFERER'];

//setup and gather all variables
$price = $_POST['price'];
$stations = $_POST['stations'];
$option_shipping = $_POST['option_shipping'];
$pi_firstname = $_POST['pi_firstname'];
$pi_lastname = $_POST['pi_lastname'];
$pi_email = $_POST['pi_email'];
$pi_phone = $_POST['pi_phone'];
$ba_street = $_POST['ba_street'];
$ba_streetadditional = $_POST['ba_streetadditional'];
$ba_city = $_POST['ba_city'];
$ba_state = $_POST['ba_state'];
$ba_zip = $_POST['ba_zip'];
$ba_country = $_POST['ba_country'];
$sa_firstname = $_POST['sa_firstname'];
$sa_lastname = $_POST['sa_lastname'];
$sa_street = $_POST['sa_street'];
$sa_streetadditional = $_POST['sa_streetadditional'];
$sa_city = $_POST['sa_city'];
$sa_state = $_POST['sa_state'];
$sa_zip = $_POST['sa_zip'];
$sa_country = $_POST['sa_country'];
$pi_questions = $_POST['pi_questions'];
$finance_bank = $_POST['finance_bank'];
$finance_accounttype = $_POST['finance_accounttype'];
$finance_accountname = $_POST['finance_accountname'];
$finance_routing = $_POST['finance_routing'];
$finance_account = $_POST['finance_account'];
$finance_process = $_POST['finance_process'];
$finance_securityquestion = $_POST['finance_securityquestion'];
$finance_securityanswer = $_POST['finance_securityanswer'];
$finance_cc = $_POST['finance_cc'];
$finance_cc_month = $_POST['finance_cc_month'];
$finance_cc_year = $_POST['finance_cc_year'];
$finance_cc_cvc = $_POST['finance_cc_cvc'];
$lp_title = $_POST['linked_product_title'];
$lp_id = $_POST['linked_product_id'];
$lp_link = $_POST['linked_product_link'];
$optin = $_POST['optin'];

if($pi_firstname && $pi_email && $price){

	//create giving post

	$post = array(
	  'post_content'   => '', // The full text of the post.
	  'post_title'     => $recurring_title, // The title of your post.
	  'post_status'    => 'private', // Default 'draft'.
	  'post_type'      => 'giving', // Default 'post'.
	  'ping_status'    => 'closed', // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
	  'comment_status' => 'closed', // Default is the option 'default_comment_status', or 'closed'.
	);

	//insert post into database

	$new_postid = wp_insert_post( $post, $wp_error );

	//Test Credentials
	//$finance_cc = 4007000000027;
	//$finance_cc_month = 12;
	//$finance_cc_year = 20;
	//$finance_cc_cvc = 999;

	//authenticate with authorize.net

	require_once('ClsAuthorize.php');

	$aim=new AuthNetAim();
	//$aim->url="https://test.authorize.net/gateway/transact.dll";
	//$aim->x_login="7TfK8q98";
	//$aim->x_tran_key="28WT6BStd3yc9q5H";
	$aim->url="https://secure.authorize.net/gateway/transact.dll";
	$aim->x_login="haven462";
	$aim->x_tran_key="ODPiVqBukBN7NAPd";
	$aim->x_version="3.1";

	//$aim->x_type="AUTH_CAPTURE";
	//$aim->x_test_request="FALSE";
	$aim->x_type="AUTH_ONLY";
	$aim->x_test_request="TRUE";
	$aim->x_card_num=$finance_cc;
	$aim->x_exp_date=$finance_cc_month.$finance_cc_year;
	$aim->x_method="CC";
	$aim->x_amount=$price;
	$aim->x_first_name=$pi_firstname;
	$aim->x_last_name=$pi_lastname;
	$aim->x_ship_to_first_name=$sa_firstname;
	$aim->x_ship_to_last_name=$sa_lastname;
	$aim->x_address=$sa_street . ' ' . $sa_streetadditional;
	$aim->x_city=$sa_city;
	$aim->x_state=$sa_state;
	$aim->x_phone=$pi_phone;
	$aim->x_zip=$sa_zip;
	$aim->x_email=$pi_email;
	$aim->x_delim_char="|";
	$aim->x_delim_data="TRUE";
	$aim->x_url="FALSE";
	$aim->x_invoice_num=$new_postid;

	$error=$aim->process();
	// debug messages
	//'/haven/wp-content/themes/haven2015/woocommerce/haven/authorize.log'
	//$fp = fopen('C:\\websites\\haven\\wp-content\\themes\\haven2015\\woocommerce\\haven\\authorize.log', 'a');
	//$log = $aim->dump_fields();
	//$log = $aim->dump_response();
	//fwrite($fp, $error);
	//fclose($fp);

	if ($aim->errors['Response Code'] == "1") {

		//add encryption to credit card fields & routing/account

		//echo $new_postid;

		//insert the rest of the data into custom table
		if($new_postid > 0){

			//ENCRYPT
			$encrypt_finance_cc = openssl_encrypt($finance_cc, $encryptionMethod, $encryptionKey);
			$encrypt_finance_cc_cvc = openssl_encrypt($finance_cc_cvc, $encryptionMethod, $encryptionKey);
			$encrypt_finance_routing = openssl_encrypt($finance_routing, $encryptionMethod, $encryptionKey);
			$encrypt_finance_account = openssl_encrypt($finance_account, $encryptionMethod, $encryptionKey);

			//To Decrypt
			//$decrypt_finance_cc = openssl_decrypt($finance_cc, $encryptionMethod, $encryptionKey);
			//$decrypt_finance_cc_cvc = openssl_decrypt($finance_cc_cvc, $encryptionMethod, $encryptionKey);
			//$decrypt_finance_routing = openssl_decrypt($finance_routing, $encryptionMethod, $encryptionKey);
			//$decrypt_finance_account = openssl_decrypt($finance_account, $encryptionMethod, $encryptionKey);

			//Result
			//echo "Encrypted: $encrypt_finance_cc <br>Decrypted: $decrypt_finance_cc";

			$wpdb->insert('wp_ht_recurring',
				array(
					'postid' => $new_postid,
					'price' => $price,
					'stations' => $stations,
					'pi_firstname' => $pi_firstname,
					'pi_lastname' => $pi_lastname,
					'pi_email' => $pi_email,
					'pi_phone' => $pi_phone,
					'ba_street' => $ba_street,
					'ba_streetadditional' => $ba_streetadditional,
					'ba_city' => $ba_city,
					'ba_state' => $ba_state,
					'ba_zip' => $ba_zip,
					'ba_country' => $ba_country,
					'sa_firstname' => $sa_firstname,
					'sa_lastname' => $sa_lastname,
					'sa_street' => $sa_street,
					'sa_streetadditional' => $sa_streetadditional,
					'sa_city' => $sa_city,
					'sa_state' => $sa_state,
					'sa_zip' => $sa_zip,
					'sa_country' => $sa_country,
					'pi_questions' => $pi_questions,
					'finance_bank' => $finance_bank,
					'finance_accounttype' => $finance_accounttype,
					'finance_accountname' => $finance_accountname,
					'finance_routing' => $encrypt_finance_routing,
					'finance_account' => $encrypt_finance_account,
					'finance_process' => $finance_process,
					'finance_securityquestion' => $finance_securityquestion,
					'finance_securityanswer' => $finance_securityanswer,
					'finance_cc' => $encrypt_finance_cc,
					'finance_cc_month' => $finance_cc_month,
					'finance_cc_year' => $finance_cc_year,
					'finance_cc_cvc' => $finance_cc_cvc,
					'lp_id' => $lp_id,
					'lp_title' => $lp_title,
					'lp_link' => $lp_link,
					'optin' => $optin
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);

			//SEND NOTIFICATION EMAIL

			$group_emails = array('lahanna.lopez@haventoday.org');
			// $group_emails = array('stephen.mccaskell@haventoday.org');
			$to = $group_emails;
			$subject = 'New Recurring Giving';
			$body = 'A new recurring giving order has taken place. View recurring donation here: https://www.haventoday.org/wp-admin/post.php?post=' . $new_postid;
			$headers = array('Content-Type: text/html; charset=UTF-8');

			wp_mail($to, $subject, $body);

			header('Location: /thank-you/');
		}
	} else {
		if ($aim->errors['Response Reason Text']) {
			print $aim->errors['Response Reason Text'];
		} else {
			print "Error code: " . $aim->errors['Response Code'];
		}
	}
} else {
	header('Location: /thank-you/');
}

?>
