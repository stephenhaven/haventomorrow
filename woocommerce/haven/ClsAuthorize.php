<?php
/**
 ** @author Njau Ndirangu (njau_ndirangu(at)yahoo.com)
 * @copyright copyright @ 2008, Njau Ndirangu, released under the GPL.
 * @license 
 * @version 1.1.0
 * @package cURL
 *  PHP class for interaction with Authorize.net Advanced Integration Method (AIM)
 * 
 * Reading the AIM guide (PDF) for instructions on usage is suggested: 
 * http://developer.authorize.net/guides/
 * http://www.authorize.net/support/CP_guide.pdf
 *
 * Developed using PHP 5 (http://www.php.net/) and cURL (http://www.php.net/curl)
 * i wrote this class after finding none sufficient enough for my needs
 * This classe include some tidbits from a collective of other Authorize examples
 * most notable HTTP Retriever from Steve Blinch http://code.blitzaffe.com
 * Also from Micah Carrick
 *      Email:      email@micahcarrick.com
 *      Website:    http://www.micahcarrick.com
 * License: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 *
 * Please keep this header information here
 *Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL I BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */




class AuthNetAim {
	public $url;
	public $x_version;
	public $x_type;
	public $x_method;
	public $x_recurring_billing;
	public $x_card_num;
	public $x_exp_date;
	public $x_card_code;
	public $x_reason_code;
	public $x_trans_id;
	public $x_auth_code;
	public $x_test_request;
	public $x_duplicate_window;
	public $x_login;
	public $x_market_type;
	public $x_device_type;
	public $x_delim_char;
	public $x_delim_data;
	public $x_encap_char;
	public $x_url;
	public $x_tran_key;
	public $x_description;
	public $x_invoice_num;
	public $x_line_item;
	public $x_amount;
	public $x_first_name;
	public $x_last_name;
	public $x_company;
	public $x_address;
	public $x_city;
	public $x_state;
	public $x_zip;
	public $x_country;
	public $x_phone;
	public $x_fax;
	public $x_cust_id;
	public $x_customer_ip;
	public $x_ship_to_first_name;
	public $x_ship_to_last_name;
	public $x_ship_to_company;
	public $x_ship_to_address;
	public $x_ship_to_city;
	public $x_ship_to_state;
	public $x_ship_to_zip;
	public $x_ship_to_country;
	public $x_tax;
	public $x_freight;
	public $x_duty;
	public $x_tax_exempt;
	public $x_po_num;
	public $x_email;
	public $x_email_customer;
	public $x_header_email_receipt;
	public $x_footer_email_receipt;
	public $errors=array();//array to hold the errors generated.
	public $theURL=null;
	public $postvals=array();
	public $method;//for post
	public $m_options ;// Current setting of the curl options.
	public $m_handle ;//The handle for the current curl session.
	public $headers;
	public $stats;//Get information regarding a specific transfer
	public $response;//curl response
	public $progress;
	public $fields;
	public $curl_errors;
	public $progress_callback;
	/**
	 * curl class constructor
	 *
	 * Initializes the curl class for it's default behavior:
	 *  o no HTTP headers.
	 *  o return the transfer as a string.
	 *  o URL to access.
	 * By default, the curl class will simply read the URL provided
	 * in the constructor.
	 *
	 * @link http://www.php.net/curl_init
	 * @param string $theURL [optional] the URL to be accessed by this instance of the class.
	 */
	public function __construct($theURL=null){
		// Normally, CURL is only used for HTTPS requests; setting this to
		// TRUE will force CURL for HTTP requests as well.  Not recommended.
		$this->force_curl = false;
		
		// If you don't want to use CURL at all, set this to TRUE.
		$this->disable_curl = false;
		
		
		// If HTTPS request return an error message about SSL certificates in
		// $this->error and you don't care about security, set this to TRUE
		$this->insecure_ssl = true;
		/*
		If you're making an HTTPS request to a host whose SSL certificate
		doesn't match its domain name, AND YOU FULLY UNDERSTAND THE
		SECURITY IMPLICATIONS OF IGNORING THIS PROBLEM, set this to TRUE.
		When negotiating an SSL connection, the server sends a certificate indicating its identity.
		When CURLOPT_SSL_VERIFYHOST is 2, that certificate must indicate that the server is the server
		to which you meant to connect, or the connection fails.Curl considers the server the intended
	    one when the Common Name field or a Subject Alternate Name field in the certificate matches the
	    host name in the URL to which you told Curl to connect.When the value is 1, the certificate must
	    contain a Common Name field, but it doesn't matter what name it says. 
	    (This is not ordinarily a useful setting).When the value is 0, the connection succeeds regardless of the names in the certificate.
		The default, since 7.10, is 2.
		*/ 
		$this->ignore_ssl_hostname = false;
		
		// Optionally set this to a valid callback method to have AuthNetAim
		// provide progress messages.  Your callback must accept 2 parameters:
		// an integer representing the severity (0=debug, 1=information, 2=error),
		// and a string representing the progress message
		$this->progress_callback = true;
		try {
		
		if (!function_exists('curl_init'))
		  {
			throw new AIMException(trigger_error('PHP was not built with --with-curl, rebuild PHP to use the curl class.',
						  E_USER_ERROR) );
		  }

		$this->m_handle = curl_init() ;
		$this->m_caseless = null ;
		$this->m_header = null ;
		$this->m_options = null ;
		$this->m_status = null ;
		$this->m_followed = null ;

		if (!empty($theURL))
		  {
			$this->setopt(CURLOPT_URL, $theURL) ;
		  }
		$this->setopt(CURLOPT_HEADER, false) ;
		$this->setopt(CURLOPT_RETURNTRANSFER, true) ;
		
		}
		catch (AIMException $e){
			$this->curl_errors=$e->message();//register errors
		}
	
		
	}
	public function process(){
		$url="http://".$_SERVER['SERVER_NAME'];//host address
		$parsed = parse_url($url);
		$host= $parsed['host'];
		$this->headers = array(
                        "Host"=>"$host",
			"User-Agent"=>"AuthNetAim_Send_it",
			"Connection"=>"close"
		);
		$postvals=$this->fetch();
		$request_result=$this->_send_request($this->url);
		
	return $this->curl_errors;	
	}
	public function _curl_request($url) {
		
		

		unset($this->headers["Content-Length"]);
		$headers = explode("\n",$this->build_headers());
		
		$fields=$this->postvals;
		$field_strings=$this->fields_construct($fields);

		$c = 0;
		while ($c < 10) {		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url); 
		curl_setopt($ch,CURLOPT_USERAGENT, $this->headers["User-Agent"]); 
		curl_setopt($ch,CURLOPT_HEADER, 0); 
		curl_setopt($ch,CURLOPT_ENCODING, "");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1); 
//		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1); // native method doesn't support this yet, so it's disabled for consistency
		curl_setopt($ch,CURLOPT_TIMEOUT, 30);
//		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		
		if ($this->method=="POST") {
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,rtrim($field_strings, "& " ));
		}
		if ($this->insecure_ssl) {
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		}
		if ($this->ignore_ssl_hostname) {
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);	
		}
		
		
		$this->response = urldecode(curl_exec ($ch));//ssl
		
		if (curl_errno($ch)!=0) {
			$this->errors['Response Reason Text'] = "CURL error #".curl_errno($ch).": ".curl_error($ch);
		}
		
		$this->stats = curl_getinfo($ch);
		
		curl_close($ch);
		if (preg_match("/Bad Request/", $this->response)) {

		$fp = fopen('/home/havenministries.com/logs/transactions.log', 'a');
		$printlog = date("Y-m-d H:i:s") . " Try $c failed\n";
                fwrite($fp, "$printlog");
                fclose($fp);

		if ($c == "9") {
		$emailheaders = "";
		foreach ($headers as $key => $value) {
		$emailheaders .= $key." - ".$value."\n";
		}

                $log = date("Y-m-d H:i:s") . " " . $_SERVER['REMOTE_ADDR'] . " " . $url . " POST: " . rtrim($field_strings, "& " ) . "RESULT: " . $this->response . "headers: " . $emailheaders . "\n";

                mail( "asnook@hostonfiber.com", "Haven giving page error","$log", "From: HostOnFiber <system@hostonfiber.com>\nX-Mailer: HostOnFiber\n");

                $fp = fopen('/home/havenministries.com/logs/transactions.log', 'a');
                fwrite($fp, $log);
                fclose($fp);

		}

//		sleep(1);
		$c++;
		}
		else {
		$c = "10";	
		}
}
		 // load a temporary array with the values returned from authorize.net
      $temp_values = explode('|', $this->response);
 
      // load a temporary array with the keys corresponding to the values 

      // returned from authorize.net (taken from AIM documentation)
      $temp_keys= array ( 
           "Response Code", "Response Subcode", "Response Reason Code", "Response Reason Text",
           "Approval Code", "AVS Result Code", "Transaction ID", "Invoice Number", "Description",
           "Amount", "Method", "Transaction Type", "Customer ID", "Cardholder First Name",
           "Cardholder Last Name", "Company", "Billing Address", "City", "State",
           "Zip", "Country", "Phone", "Fax", "Email", "Ship to First Name", "Ship to Last Name",
           "Ship to Company", "Ship to Address", "Ship to City", "Ship to State",
           "Ship to Zip", "Ship to Country", "Tax Amount", "Duty Amount", "Freight Amount",
           "Tax Exempt Flag", "PO Number", "MD5 Hash", "Card Code (CVV2/CVC2/CID) Response Code",
           "Cardholder Authentication Verification Value (CAVV) Response Code"
      );
 
      // add additional keys for reserved fields and merchant defined fields
      for ($i=0; $i<=27; $i++) {
         array_push($temp_keys, 'Reserved Field '.$i);
      }
      $i=0;
      while (sizeof($temp_keys) < sizeof($temp_values)) {
         array_push($temp_keys, 'Merchant Defined Field '.$i);
         $i++;
      }
 
      // combine the keys and values arrays into the $response array.  This
      // can be done with the array_combine() function instead if you are using
      // php 5.
      for ($i=0; $i<sizeof($temp_values);$i++) {
         $this->errors["$temp_keys[$i]"] = $temp_values[$i];
      }
      // $this->dump_response();
      // Return the response code.
      return $this->errors['Response Code'];
		
		//return ($this->errors === false);
	}
	// perform an HTTPS request using CURL
	public function _send_request($url) {
		$urldata = parse_url($url);
		$this->method="POST";
		if (!$urldata["port"]) $urldata["port"] = ($urldata["scheme"]=="https") ? 443 : 80;
		$this->progress(HRP_INFO,"Initiating {$this->method} request for $url");
	if ( !$this->disable_curl && ( ($urldata["scheme"]=="https") || ($this->force_curl) ) ) {
			$this->progress(HRP_INFO,'Passing HTTP request for $url to CURL');
			$curl_mode = true;
			if (!$this->_curl_request($url)) return false;
			
		// unknown protocol
		} else {
			$this->errors = "Unsupported protocol: ".$urldata["scheme"];
			$this->progress(HRP_ERROR,$this->errors);
			return false;
		}
	}
	public function fetch() {
		if (!empty($this->x_version)) {
            $this->postvals['x_version'] = $this->x_version;
        }
        if (!empty($this->x_type)) {
           $this->postvals['x_type'] = $this->x_type;
        }
        if (!empty($this->x_method)) {
           $this->postvals['x_method'] = $this->x_method;
        }
        if (!empty($this->x_recurring_billing)) {
           $this->postvals['x_recurring_billing'] = $this->x_recurring_billing;
        }
        if (!empty($this->x_card_num)) {
            $this->postvals['x_card_num'] = $this->x_card_num;
        }
        if (!empty($this->x_exp_date)) {
           $this->postvals['x_exp_date'] = $this->x_exp_date;
        }
        if (!empty($this->x_card_code)) {
            $this->postvals['x_card_code'] = $this->x_card_code;
        }
        if (!empty($this->x_trans_id)) {
            $this->postvals['x_trans_id'] = $this->x_trans_id;
        }
        if (!empty($this->x_auth_code)) {
            $this->postvals['x_auth_code'] = $this->x_auth_code;
        }
        if (!empty($this->x_test_request)) {
            $this->postvals['x_test_request'] = $this->x_test_request;
        }
        if (!empty($this->x_duplicate_window)) {
            $this->postvals['x_duplicate_window'] = $this->x_duplicate_window;
        }
        if (!empty($this->x_login)) {
            $this->postvals['x_login'] = $this->x_login;
        }
        if (!empty($this->x_delim_char)) {
            $this->postvals['x_delim_char'] = $this->x_delim_char;
        }
        if (!empty($this->x_delim_data)) {
            $this->postvals['x_delim_data'] = $this->x_delim_data;
        }
        if (!empty($this->x_encap_char)) {
           $this->postvals['x_encap_char'] = $this->x_encap_char;
        }
        if (!empty($this->x_tran_key)) {
            $this->postvals['x_tran_key'] = $this->x_tran_key;
        }
        if (!empty($this->x_description)) {
            $this->postvals['x_method'] = $this->x_method;
        }
        if (!empty($this->x_description)) {
            $this->postvals['x_description'] = $this->x_description;
        }
        if (!empty($this->x_invoice_num)) {
            $this->postvals['x_invoice_num'] = $this->x_invoice_num;
        }
        if (!empty($this->x_line_item)) {
            $this->postvals['x_line_item'] = $this->x_line_item;
        }
        if (!empty($this->x_amount)) {
            $this->postvals['x_amount'] = $this->x_amount;
        }
        if (!empty($this->x_first_name)) {
           $this->postvals['x_first_name'] = $this->x_first_name;
        }
        if (!empty($this->x_last_name)) {
           $this->postvals['x_last_name'] = $this->x_last_name;
        }
        if (!empty($this->x_company)) {
           $this->postvals['x_company'] = $this->x_company;
        }
        if (!empty($this->x_address)) {
           $this->postvals['x_address'] = $this->x_address;
        }
        if (!empty($this->x_city)) {
            $this->postvals['x_city'] = $this->x_city;
        }
         if (!empty($this->x_state)) {
            $this->postvals['x_state'] = $this->x_state;
        }
         if (!empty($this->x_zip)) {
            $this->postvals['x_zip'] = $this->x_zip;
        }
         if (!empty($this->x_country)) {
            $this->postvals['x_country'] = $this->x_country;
        }
         if (!empty($this->x_phone)) {
            $this->postvals['x_phone'] = $this->x_phone;
        }
         if (!empty($this->x_fax)) {
            $this->postvals['x_fax'] = $this->x_fax;
        }
         if (!empty($this->xx_cust_id)) {
            $this->postvals['x_cust_id'] = $this->x_cust_id;
        }
         if (!empty($this->x_customer_ip)) {
            $this->postvals['x_customer_ip'] = $this->x_customer_ip;
        }
         if (!empty($this->x_ship_to_first_name)) {
            $this->postvals['x_ship_to_first_name'] = $this->x_ship_to_first_name;
        }
        if (!empty($this->x_ship_to_last_name)) {
            $this->postvals['x_ship_to_last_name'] = $this->x_ship_to_last_name;
        }
        if (!empty($this->x_ship_to_company)) {
            $this->postvals['x_ship_to_company'] = $this->x_ship_to_company;
        }
        if (!empty($this->x_ship_to_address)) {
            $this->postvals['x_ship_to_address'] = $this->x_ship_to_address;
        }
        if (!empty($this->x_ship_to_city)) {
            $this->postvals['x_ship_to_city'] = $this->x_ship_to_city;
        }
        if (!empty($this->x_ship_to_state)) {
            $this->postvals['x_ship_to_state'] = $this->x_ship_to_state;
        }
        if (!empty($this->x_ship_to_zip)) {
           $this->postvals['x_ship_to_zip'] = $this->x_ship_to_zip;
        }
        if (!empty($this->x_ship_to_country)) {
            $this->postvals['x_ship_to_country'] = $this->x_ship_to_country;
        }
        if (!empty($this->x_tax)) {
           $this->postvals['x_tax'] = $this->x_tax;
        }
        if (!empty($this->x_freight)) {
            $this->postvals['x_freight'] =$this->x_freight;
        }
        if (!empty($this->x_duty)) {
           $this->postvals['x_duty'] = $this->x_duty;
        }
        if (!empty($this->x_tax_exempt)) {
            $this->postvals['x_tax_exempt'] = $this->x_tax_exempt;
        }
        if (!empty($this->x_tax_exempt)) {
            $this->postvals['x_method'] =$this->x_method;
        }
        if (!empty($this->x_po_num)) {
           $this->postvals['x_po_num'] = $this->x_po_num;
        }
        if (!empty($this->x_email)) {
           $this->postvals['x_email'] = $this->x_email;
        }
        if (!empty($this->x_email_customer)) {
            $this->postvals['x_email_customer'] = $this->x_email_customer;
        }
        if (!empty($this->x_header_email_receipt)) {
           $this->postvals['x_header_email_receipt'] = $this->x_header_email_receipt;
        }
        if (!empty($this->x_footer_email_receipt)) {
            $this->postvals['x_footer_email_receipt'] = $this->x_footer_email_receipt;
        }
        if (!empty($this->x_market_type)) {
            $this->postvals['x_market_type'] = $this->x_market_type;
        }
        if (!empty($this->x_device_type)) {
            $this->postvals['x_device_type'] = $this->x_device_type;
        }
        if (!empty($this->x_reason_code)) {
            $this->postvals['x_reason_code'] = $this->x_reason_code;
        }
       
	}
	
	
	public function progress($level,$msg) {
		if (is_callable($this->progress_callback)) call_user_func($this->progress_callback,$level,$msg);
	}
	/**
	 * Set a curl option.
	 *
	 * @link http://www.php.net/curl_setopt
	 * @param mixed $theOption One of the valid CURLOPT defines.
	 * @param mixed $theValue the value of the curl option.
	 */

	public function setopt($theOption, $theValue)
	  {
		curl_setopt($this->m_handle, $theOption, $theValue) ;
		$this->m_options[$theOption] = $theValue ;
	  }
	  
	  public function build_headers() {
		$headers = "";
		foreach ($this->headers as $name=>$value) {
			$value = trim($value);
			if (empty($value)) continue;
			$headers .= "{$name}: $value\r\n";
		}
		$headers .= "\r\n";
		
		return $headers;
	}
	// Gets any available AuthNetAim error message (including both internal
	// errors and HTTPs errors)
	public function get_error() {
		return $this->errors; 
	}
	public function fields_construct($field){
	// construct the fields string to pass to authorize.net
      foreach( $field as $key => $value ) 
         $field_string .= "$key=" . urlencode( $value ) . "&";
         return $field_string;
	}
	 function get_response_reason_text() {
      return $this->response['Response Reason Text'];
   }

   function dump_fields() {
 
      // Used for debugging, this function will output all the field/value pairs
      // that are currently defined in the instance of the class using the
      // add_field() function.
      
      echo "<h3>authorizenet_class->dump_fields() Output:</h3>";
      echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>"; 
            
      foreach ($this->postvals as $key => $value) {
         echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
      }
 
      echo "</table><br>"; 
   }

   function dump_response() {
 
      // Used for debuggin, this function will output all the response field
      // names and the values returned for the payment submission.  This should
      // be called AFTER the process() function has been called to view details
      // about authorize.net's response.
      
      echo "<h3>authorizenet_class->dump_response() Output:</h3>";
      echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Index&nbsp;</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>";
            
      $i = 0;
      foreach ($this->errors as $key => $value) {
         echo "<tr>
                  <td valign=\"top\" align=\"center\">$i</td>
                  <td valign=\"top\">$key</td>
                  <td valign=\"top\">$value&nbsp;</td>
               </tr>";
         $i++;
      } 
      echo "</table><br>";
   }    
      

	
	
}
/**
 * Handle the Exceptions trigered by errors within processing of the code.
 *
 */
class AIMException extends Exception{ 
	public $backtrace;
	public function __construct($message=false, $code=false){
		if (!$message) {
			return ($this->message());
		}
		if (!$code) {
			return ($this->code);
		}
		$this->backtrace=debug_backtrace();
	}
	public function message(){
		
		return "{$this->message}";
		
	}
	
}

?>
