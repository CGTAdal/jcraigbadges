<?php 
class Payment {
    public $cc_name;
    public $cc_number;
    public $cc_cvv;
    public $cc_type;
    public $merchant_ref;
    public $cc_month;
    public $cc_year;
    public $email;
    public $transaction_id;

    public function charge($paybilling) {
        //print_r($paybilling);
        //TESTING ACCOUNT
        //get from account API settings these are not valid keys, key_id, gateway_id or password
        $key = 'za4FB6RtBhtNdr0GC2O1NrGO3VDmLXAU';
        $key_id = 378650;
        $gateway_id = 'D45137-01';
        //$endpoint = 'https://api.demo.globalgatewaye4.firstdata.com/transaction/v14';
        $endpoint = 'https://api.globalgatewaye4.firstdata.com/transaction/v14';
        $password = 'bq2xm7vyi4w29a22wq967j9xwbc20s80';
        $myorder = array(
            'gateway_id' => $gateway_id,
            'password' => $password,
            'transaction_type' => '00',
			'merchant_ref' => $this->merchant_ref,
            'amount' => $this->amount,
            'cardholder_name' => $this->cc_name,
            'cc_number' => $this->cc_number,
            'cc_expiry' => str_pad(($this->cc_month),2,'0',STR_PAD_LEFT) . (intval($this->cc_year)), //format 0414
            'cc_verification_str2' => $this->cc_cvv,
            //'cc_cvv' => $this->cc_cvv,
            'cc_type' => $this->cc_type,
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'client_email' => $this->email,
            'zip_code' => $paybilling->zip,
            'address' => array(
                'address1' => $paybilling->address,
                //'address2' => $paybilling->address2,
                'city' => $paybilling->city,
                'state' => $paybilling->state,
                'zip' => $paybilling->zip
            ),
        );
        
        $data_string = json_encode($myorder);
        
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL,$endpoint);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_VERBOSE, 1);
        
        $content_digest = sha1($data_string);
        
        $current_time = gmdate('Y-m-dTH:i:s') . 'Z';
        $current_time = str_replace('GMT', 'T', $current_time);
        
        $code_string = "POST\napplication/json\n{$content_digest}\n{$current_time}\n/transaction/v14";
        $code = base64_encode(hash_hmac('sha1',$code_string,$key,true));
        
        $header_array = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
            'X-GGe4-Content-SHA1: '. $content_digest,
	    'X-GGe4-Date: ' . $current_time,
	    'Authorization: GGE4_API ' . $key_id . ':' . $code,
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
        $result1 = curl_exec ($ch);
        curl_close($ch);
        $result = json_decode($result1);

        if($result){
            if ($result->transaction_approved == '0') {
                return array('success'=>false,'error'=>$result->bank_message);
        	} else {
                    $this->transaction_id = $result->transaction_tag;
                    return array('success'=>true);
        	}
        }else{
            return array('success'=>false,'error'=>$result1);
        }

    }
}
?>