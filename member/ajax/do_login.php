<?php
session_start();

require_once '../../config.php';
require_once '../../CMySql.php';

$cmysql = new CMySql($host, $user, $pass);
$row = $cmysql->selectRow($db_game, 'login', '`account_id`', "`userid` = '".
		$cmysql->escape_string($_POST['user'])."' AND `user_pass` = '".
		$cmysql->escape_string($_POST['pass'])."'");

$login_success = false;
if( $cmysql->num_rows() == 1){
	$login->userId = $row['account_id'];
	$login_success = true;

	$login->rememberMe = $_POST['rememberMe'];
	
	if ($login_success && $_POST['rememberMe']) { // However you implement it
		$selector = base64_encode(openssl_random_pseudo_bytes(9));
		$authenticator = openssl_random_pseudo_bytes(33);
	
		setcookie('remember',
			 $selector.':'.base64_encode($authenticator),
			 time() + 864000,
			 '/ro_db/member/login.php');/*,
			 'localhost',
			 false, // TLS-only
			 false  // http-only
		);*/
	
		$cmysql->insert($db_web,"auth_tokens",
				array($selector,
					hash('sha256', $authenticator),
					$login->userId,
					date('Y-m-d\TH:i:s', time() + 864000)
				),
				"selector, token, account_id, expires");
	}
	$res_data[0] = 1;
	$res_data[1] = '<div class="alert alert-success" role="alert"><strong>Success!</strong> เข้าสู่ระบบเรียบร้อย กรุณารอสักครู่...</div>';
}
else{
	$res_data[0] = 0;
	$res_data[1] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> ไอดี หรือ รหัสผ่านไม่ถูกต้อง</div>';
}
$cmysql->disconnect();
echo json_encode($res_data);
?>