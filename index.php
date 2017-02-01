<?php
//Include FB config file && User class
require_once 'config.php';
require_once 'db.php';

if(!$fbUser){
	$fbUser = NULL;
	$loginURL = $facebook->getLoginUrl(array('redirect_uri'=>$redirectURL,'scope'=>$fbPermissions));
	$output = '<a href="'.$loginURL.'"><img src="media/fb-login-btn.png"></a>'; 	
}else{
	//Get user profile data from facebook
	$fbUserProfile = $facebook->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');
	
	//Initialize User class
	$user = new User();
	
	//Insert or update user data to the database
	$fbUserData = array(
		'first_name' 	=> $fbUserProfile['first_name'],
		'last_name' 	=> $fbUserProfile['last_name'],
		'picture' 		=> $fbUserProfile['picture']['data']['url'],
	);
	$userData = $user->checkUser($fbUserData);
	
	//Put user data into session
	$_SESSION['userData'] = $userData;
	
	//Render facebook profile data
	if(!empty($userData)){
		$output = '<h2>Your Details:</h2>';
		$output .= '<img src="'.$userData['picture'].'">';
        $output .= '<p><br/>Name : ' . $userData['first_name'].' '.$userData['last_name'].'</p>';
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