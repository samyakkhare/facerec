<?php
function logout() {
	session_destroy();
	unset($_SESSION['student_delno']);
    unset($_SESSION['student_name']);
	unset($_SESSION['general_paid']);
	unset($_SESSION['gaming_paid']);
	unset($_SESSION['featured_paid']);
	unset($_SESSION['student_qr']);
	unset($_SESSION['student_phno']);
	unset($_SESSION['student_mail']);
}

function get_conn() {
	$host = 'localhost';
	$user = 'root';
	$password = 'root';
	$db_name = 'facerec';
	try {
		$conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    return $conn;
	} catch(PDOException $e) {
		echo "Could not connect to database";
	}
	return NULL;
}
function sec_session_start() {
	$session_name = 'my_session';
	$secure = FALSE;
	$httponly = true;
	
	if(ini_set('session.use_only_cookies',1)==FALSE){
		echo "Could not initiate a safe session";
		exit();
	}
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	session_name($session_name);
	session_start();

	if(isset($_SESSION['student_delno'])) {
		$conn = get_conn();
		$result = $conn->query("SELECT * FROM tblstudent WHERE student_delno = ".$_SESSION['student_delno'])->fetch();
		$_SESSION['general_paid'] = $result['general_paid'];
		$_SESSION['gaming_paid'] = $result['gaming_paid'];
		$_SESSION['featured_paid'] = $result['featured_paid'];
		$conn = NULL;
	}
}

function verifyCaptcha($response, $secret = "6LfKclgUAAAAAOgPtiv7lnEOvngl_iUp0fUUgMGs") {
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => $secret,
		'response' => $response
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);
	if(!$captcha_success->success) {
		$response = array('status' => 2, 'message' => 'Invalid Captcha');
		die(json_encode($response));
	}
}

function check_name($field){
	if(preg_match('/^[A-Za-z \'.,]+$/', $field)=='0'){
		$response = array('status' => 2, 'message' => 'Name not in correct format');
		die(json_encode($response));
	}
}

function check_regno($field){
	if(preg_match('/^[0-9A-Za-z]+$/', $field)=='0'){
		$response = array('status' => 2, 'message' => 'Registration number not in correct format');
		die(json_encode($response));
	}
}

function check_mail($field){
	if(!filter_var($field, FILTER_VALIDATE_EMAIL)){
		$response = array('status' => 2, 'message' => 'Email not in correct format');
		die(json_encode($response));
	}
}

function check_phone($field){
	if(preg_match('/^[0-9]{10}$/', $field)=='0'){
		$response = array('status' => 2, 'message' => 'Mobile number not in correct format');
		die(json_encode($response));
	}
}

function check_id($field){
	if(preg_match('/^[0-9]+$/', $field)=='0'){
		$response = array('status' => 2, 'message' => 'Id not in correct format');
		die(json_encode($response)); 
	}
}

function get_random_string($length = 8) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}

function encrypt($plaintext) {
	$password = 'sab_yahan_madarchod_hain';
	$method = 'aes-256-cbc';
	$password = substr(hash('sha256', $password, true), 0, 32);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
	$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
	return $encrypted;
}

function decrypt($encrypted) {
	$password = 'sab_yahan_madarchod_hain';
	$method = 'aes-256-cbc';
	$password = substr(hash('sha256', $password, true), 0, 32);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    $decrypted = openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);
    // die($decrypted);
	return $decrypted;
}

function check_student_for_event($event_id, $student_delno) {
	$gaming_catid = '44';
	$conn = get_conn();
	$event = $conn->query("SELECT * FROM events WHERE id=".$event_id)->fetch();
	if(!$event) {
		$res = array('status' => 1, 'message' => 'Event id is invalid');
		die(json_encode($res));
	}
	// echo "OK";
	// echo json_encode($event);
	$stud_details = $conn->query("SELECT * FROM tblstudent WHERE student_delno=".$student_delno)->fetch();
	if(!$stud_details) {
		$res = array('status' => 1, 'message' => 'Delegate id is invalid');
		die(json_encode($res));
	}
	// echo "OK";
	if($event['close_registration'] == '1') {
		$res = array('status' => 1, 'message' => 'Registrations for this event is over');
		die(json_encode($res));
	}
	// echo "OK";
	if(($event['category'] == $gaming_catid && $stud_details['gaming_paid']=='0')) {
		$res = array('status' => 1, 'message' => 'You need to buy gaming delegate card to participate in this event');
		die(json_encode($res));
	}
	if(($event['type'] == 'FEATURED' && $event['category'] != $gaming_catid && $stud_details['featured_paid']=='0')) {
		$res = array('status' => 1, 'message' => 'You need to buy featured delegate card to participate in this event');
		die(json_encode($res));
	}
	if(($event['type'] == 'NORMAL' || $event['type'] == 'ONLINE') && $stud_details['general_paid']=='0') {
		$res = array('status' => 1, 'message' => 'You need to buy general delegate card to participate in this event');
		die(json_encode($res));
	}
	$conn = NULL;
	$response = array('event_details' => $event, 'student_details' => $stud_details);
	return $response;
}

function get_teamid_for_del($delid,$eventid) {
	$conn = get_conn();
	$team_details = $conn->query('SELECT tbleventreg.team_id FROM tbleventreg INNER JOIN tblteams ON tbleventreg.team_id = tblteams.team_id WHERE tbleventreg.event_id = '.$eventid.' AND tblteams.del_card_no = '.$delid)->fetchAll();
	$conn = NULL;
	if(count($team_details) == 0)
		return NULL;
	return $team_details[0]['team_id'];
}
?>
