<?php
// Include Database file & User Class
require_once 'db.php';
require_once 'include/facebook.php';

// Facebook App Config
$FacebookAppId = ''; // Facebook App ID
$FacebookAppSecret = ''; // Facebook App Secret
$RedirectLink = 'http://social-brothers-php-supenogaming450820.codeanyapp.com/'; // Callback URL
$FacebookPerms = 'email';  // Required facebook permissions

//Call Facebook API
$FacebookApi = new Facebook(array(
  'appId'  => $FacebookAppId,
  'secret' => $FacebookAppSecret
));
$CurrentUser = $FacebookApi->getUser();

if(!$CurrentUser){
	$CurrentUser = NULL;
	$LoginLink = $FacebookApi->getLoginUrl(array('redirect_uri'=>$RedirectLink,'scope'=>$FacebookPerms));
	$output = '<a href="'.$LoginLink.'"><img src="media/fb-login-btn.png"></a>'; 	
}else{
	//Get user profile data from facebook
	$FacebookUserProfile = $FacebookApi->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');
	
	//Initialize User class
	$user = new User();
	
	//Insert or update user data to the database
	$FacebookUserData = array(
		'first_name' 	=> $FacebookUserProfile['first_name'],
		'last_name' 	=> $FacebookUserProfile['last_name'],
		'picture' 		=> $FacebookUserProfile['picture']['data']['url'],
	);
	$userData = $user->checkUser($FacebookUserData);
	
	//Put user data into session
	$_SESSION['userData'] = $userData;
	
	// Get ip address from client
	$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
	
	// Put ip address into session
	$_SESSION['ipaddress'] = $ip;
	
	// Display user data
	if(!empty($userData)){
		$output = '<h2>Your Details:</h2>';
		$output .= '<img src="'.$userData['picture'].'">';
        $output .= '<p><br/>Name : ' . $userData['first_name'].' '.$userData['last_name'].'</p>';
				$output .= '<p><br/>Ip Address :'.$ip.'</p>';
        $output .= '<p><br/>Click <a href="logout.php">here</a> to logout.</p>'; 
	}else{
		$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
}
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Jasper Facebook Login</title>
	<link rel="icon" href="media/fb-icon.png">
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>

<body>
	<h1>Jasper Facebook Login</h1>
	<div>
		<?php echo $output; ?>
	</div>
</body>

</html>