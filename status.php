<?php
if(isset($_GET['txref'])){
	$ref=$_GET['txref'];

	$currency = "NGN"; // correct currency from the server
	require_once("includes/db_cons.php");
	$db = mysqli_connect($servername, $db_user, $db_password, $database);
	$post_query_result = mysqli_query($db, "SELECT * FROM users WHERE txref='$ref' LIMIT 1");
 	$post = mysqli_fetch_assoc($post_query_result);
	$amount= $post['amount'];//get the correctamount of your product
	$query = array(
		"SECKEY" => "FLWSECK-9e4b4b74136818679e53f9950a46a6c7-X",
		"TXREF" => $ref
	);
	$data_string = json_encode($query);
	$ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

	$response = curl_exec($ch);

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);

	curl_close($ch);

	$resp = json_decode($response, true);

	$paymentStatus = $resp['data']['status'];
	$chargeResponsecode = $resp['data']['chargecode'];
	$chargeAmount = $resp['data']['amount'];
	$chargeCurrency = $resp['data']['currency'];

	if(($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount) && ($chargeCurrency == $currency)){
		// transaction was successful...
		 // please check other things like whether you already gave value for this ref
		 // change transaction status in database
		 $status = 1;
		 $query= "UPDATE users SET status='$status' WHERE txref='$ref'";
		 mysqli_query($db, $query);
		 header('Location: success.php');

	}else{
		$query= "DELETE FROM users WHERE txref='$ref'";
		mysqli_query($db, $query);

		header('Location: error.php');
		}
	}
?>
