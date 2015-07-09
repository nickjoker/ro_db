<?php
session_start();

if (empty($_SESSION['account_id']) && !empty($_COOKIE['remember'])) {
    list($selector, $authenticator) = explode(':', $_COOKIE['remember']);

	require_once '../config.php';
	require_once '../CMySql.php';

	$cmysql = new CMySql($host, $user, $pass);
	$cmysql->delete($db_web, "auth_tokens"," expires < '".date('Y-m-d\TH:i:s', time())."'");
	
	$row = $cmysql->selectRow($db_web, "auth_tokens",'*', "selector = '".$selector."'");
	$cmysql->disconnect();
	
    if ( $row['token'] == hash('sha256', base64_decode($authenticator))) {
        $_SESSION['account_id'] = $row['account_id'];
        // Then regenerate login token as above
    }
}
if ( !empty($_SESSION['account_id']) ) header("location: main.php");
?>
<!doctype html>
<html lang='en'>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Member Login</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css">
<!-- Optional theme >
<link rel="stylesheet" href="css/bootstrap-theme.min.css"-->

<link rel="stylesheet" type="text/css" href="../css/nprogress.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../js/jquery-latest.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/nprogress.js"></script>
<script src="../js/common_script.js" type="text/javascript"></script>
<script src="js/login_script.js" type="text/javascript"></script>
</head>
<body>
    	<div class="container">
		<div class="row" style="margin-top: 200px">
        	<div class="col-md-3"></div>
            <div class="col-md-6">

            	<div id="dv_msg"></div>

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <form >
                            <div class="form-group">
                                <label for="t_user">เกมส์ไอดี</label>
                                <input type="text" class="form-control" id="t_user" placeholder="User ID">
                            </div>
                            <div class="form-group">
                                <label for="t_pass">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="t_pass" placeholder="Password">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="rememberMe"> จดจำฉันไว้
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn_submit">เข้าสู่ระบบ</button>
                            <button type="button" class="btn btn-default" id="btn_forget">ลืมรหัสผ่าน</button>
                            <button type="button" class="btn btn-default" id="btn_regis">สมัครไอดี</button>
                        </form>
                    </div>
                </div>

            </div>
		</div>
 	</div>
</body>
</html>
