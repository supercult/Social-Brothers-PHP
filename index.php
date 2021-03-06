<?php
// Include db.php + Facebook SDK
require_once 'db.php';
require_once 'include/facebook.php';

$FacebookAppId = ''; // Facebook App ID
$FacebookAppSecret = ''; // Facebook App Secret
$RedirectLink = 'http://social-brothers-php-supenogaming450820.codeanyapp.com/'; // Redirect Link
$FacebookPerms = 'email';

$FacebookApi = new Facebook(array(
  'appId'  => $FacebookAppId,
  'secret' => $FacebookAppSecret
));
$CurrentUser = $FacebookApi->getUser();

if(!$CurrentUser){
	$CurrentUser = NULL;
	$LoginLink = $FacebookApi->getLoginUrl(array('redirect_uri'=>$RedirectLink,'scope'=>$FacebookPerms));
	$output = '<a href="'.$LoginLink.'"><img src="media/fb-login-btn.png" style="margin-top: 40vh;"></a>'; 	
}else{
	$FacebookUserProfile = $FacebookApi->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');
	
	$user = new User();
	
	$FacebookUserData = array(
		'oauth_provider'	=> 'facebook',
		'oauth_uid' 			=> $FacebookUserProfile['id'],
		'first_name' 			=> $FacebookUserProfile['first_name'],
		'last_name' 			=> $FacebookUserProfile['last_name'],
		'picture' 				=> $FacebookUserProfile['picture']['data']['url'],
		'email' 					=> $FacebookUserProfile['email'],
		'gender' 					=> $FacebookUserProfile['gender'],
		'locale' 					=> $FacebookUserProfile['locale'],
		'link' 						=> $FacebookUserProfile['link']
	);
	$userData = $user->checkUser($FacebookUserData);
	$_SESSION['userData'] = $userData;
	
	// Get client ip address
	$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
	$_SESSION['ipaddress'] = $ip;
	
	// Display Facebook Details
	if(!empty($userData)){
		$output = '<div class="left-details"><h2>Personal Details</h2>';
		$output .= '<p style="float: left; margin-left:9vw;"><br/>Avatar : </p><img style="margin-right:7vw;"src="'.$userData['picture'].'">';
		$output .= '<p><br/>Name : ' . $userData['first_name'].' '.$userData['last_name'].'</p>';
		$output .= '<p><br/>Gender : ' . $userData['gender'].'</p>';
		$output .= '<p><br/>Email : ' . $userData['email'].'</p></div>';
		$output .= '<div class="right-details"><h2>Advanced Details</h2>';
		$output .= '<p><br/>Ingelogd met : ' . $userData['oauth_provider'].'</p>';
		$output .= '<p><br/>Facebook ID : ' . $userData['oauth_uid'].'</p>';
		$output .= '<p><br/>Ip Address :'.$ip.'</p>';
		$output .= '<p><br/>Location : ' . $userData['locale'].'</p></div>';
		$output .= '<a href="'.$userData['link'].'" target="_blank"><div class="left-btn"><h1>Facebook Profile</h1></div></a>';
		$output .= '<a href="logout.php"><div class="right-btn"><h1>Logout</h1></div></a>';
	}else{
		$output = '<p>Error, please try again.</p>';
	}
}
?>

<html>

<head>
	<meta charset="utf-8">
	<title>Jasper Facebook Login</title>
	<link rel="icon" href="media/fb-icon.png">
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>

<body>
	<div>
		<?php echo $output; ?>
	</div>
	<div class="background"></div>
</body>

</html>