<?php

define("API_KEY", "AIzaSyCLAwUH94XkrLdp_jFp7pPElA5qQJiHI5A");
define("ENDPOINT", "https://android.googleapis.com/gcm/send");
//define("SUBSCRIPTION_ID", "dKTRjJpi5Sg:APA91bHoInEJkj3bAwatU3optgPgBy-q5q4_ridqktAFszAK-fXbKodxd1xZovWXeD45lLPZBHMQlxcn2BBUUTmViAdgz6IW8Jfua6DaK1eAm6RKQZCrZRrFFpx2hbfmQvOPAKyxGbOw");
define("SUBSCRIPTION_ID", "cWqGxVjHwuw:APA91bH3tgNI-JL_Uz2gzcxMz3SMTFZtZTESnzCljxhu8myTkw3PJY-9cEnbh-EkAdRfh5KANA172tdtzgeO-Xz59blcIl4bPVylxfGrIV8n_4qkL5aX867ESehlw4VTWzzl3yyjt_FE");

//Subscription ID is tied to the user and needs to be saved against them. This is my chrome for macbook pro sub number
 
if(isset($_POST['title'])) {
	
	//Create the notification json file
	$file = fopen("msgs/" . SUBSCRIPTION_ID . ".json", "w") or die("Unable to open file!");
	$path = "http://" . $_SERVER['HTTP_HOST'] . "/" . "PushNotificationTest/";
	$txt = '{"title":"' . addslashes($_POST['title']) . '", "message":"' . addslashes($_POST['content']) . '", "actions":{"defaultAction":"' . addslashes($_POST['url']) . '","action1":"' . $path . 'action1.html","action2":"' . $path . 'action2.html"}, "image":"green.jpg"}';
	fwrite($file, $txt);
	fclose($file);

	//Display the message just created
	$msg = "<h2>Push message is on its way!</h2>";
	$msg .= "<p><strong>" . $_POST['title'] . ":</strong> " . $_POST['content'] . "</p>";
	
	
	//cURL the endpoint
	$data = '{"registration_ids":["' . SUBSCRIPTION_ID . '"]}';
	
	
	if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, ENDPOINT);
 
 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 		"Authorization: key=" . API_KEY,
 		"Content-Type: application/json"
 	));
 	
 	curl_setopt($ch, CURLOPT_POST, 1);
 	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    $output = curl_exec($ch);
    curl_close($ch);
	
} else {
	$msg = "";
}


?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Push notification generator</title>
		<link rel="stylesheet" href="styles.css" />
		<link rel="manifest" href="manifest.json">
	</head>
	<body>
		<article>
			<h1>Generate a Notification</h1>
			
			<?php echo $msg; ?>
			
			<form method="post" action="push_generator.php">
				<label>Title</label>
				<input type="text" name="title" value="" />
				
				<label>Url</label>
				<input type="text" name="url" value="" />
				
				<label>Content</label>
				<textarea name="content"></textarea>
				
				<input type="submit" value="Send Push!" />
			</form>
			
		</article>

	</body>
</html>