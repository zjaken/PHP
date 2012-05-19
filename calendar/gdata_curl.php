<?php
//
session_start();


header("Content-Type:text/html;charset=UTF-8");
//echo 'CURL中文';
//echo '<hr>';

//phpinfo();




 $google_token = "Authorization: GoogleLogin auth=DQAAALgAAADZAB3-WSCW7ZJkhLzUCUJf5262fL32j8Oo4B-XTqYs3KKzjgDrlSM3rYLfnluSFQjy4fyWitcw-X_Kw_4Nwksn_rN3UYoVpAgxjwR_7mhSIYGKYWcQwscMQnLDVM3gOpCEfB22eUTU28OH_9JiD4kwd3MEsJ6fMrjh25DY_9moFxln8LTftIlKaESikoUe_SO0uUAirk3G3_Er-vn3wXAGrnbWlc7au9W1KtZP-e0kqNlCxPyitMQFd52loW2dFyk";
 $Authorization = "";


function loginGoogleAccount(){

	$email = "zj.aken@gmail.com";
	$password = "zjbb760612";

	$data = array(    
	    'accountType' => 'GOOGLE',    
	    'Email' => $email,    
	    'Passwd' => $password,    
	    'service' => 'cl',  //google 一系列api 的简写，在google 上能找到，可以换成你想要的服务简写  
	    'source' => 'ZCalendar',  //给你自己的应用程序命名  
	);  

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	$output = curl_exec($ch);



	$info = curl_getinfo($ch);
	preg_match('/Auth=.+/',$output,$tempArray);
	if($info['http_code']!=200 or empty($tempArray)){
	    return false;
	}
	$auth = 'Authorization: GoogleLogin auth='.substr($tempArray[0],5);


	//
	$Authorization = 'GoogleLogin auth='.substr($tempArray[0],5);

	//$_SESSION['googleAuth'] = $auth;
	$_SESSION['googleAuth'] = $Authorization;


	echo $auth;


	curl_close($ch);
	//
	//echo ' '.$output;

	echo "<hr>";
	echo $info;

	echo "<hr>";
	echo $output;
	echo "<br>";
	echo strlen($output);


}



function getAllCalendars(){

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/calendar/feeds/default/allcalendars/full?alt=jsonc");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	//针对网站有重定向的设置
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	

	//第一次需要如下执行
	//$VERSION = "GData-Version: 2";
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array($_SESSION['googleAuth'],$VERSION));

	//以后就无需每次登陆google了，记住token即可
	$loginInfo = array(
		"Authorization: ".$_SESSION['googleAuth'],
		"GData-Version: 2" 
	);


	//echo (print_r($loginInfo));
	//echo "<br>";
	//echo ($loginInfo[0]);
	//echo "<br>";
	//echo ($loginInfo[1]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $loginInfo);




	$output = curl_exec($ch);
	curl_close($ch);
	
	echo $output;

	

}

//首次执行
function getAllCalendarsForBegin(){

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/calendar/feeds/default/allcalendars/full?alt=jsonc");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	

	//第一次需要如下执行
	$VERSION = "GData-Version: 2";
	curl_setopt($ch, CURLOPT_HTTPHEADER, array($_SESSION['googleAuth'],$VERSION));


	$output = curl_exec($ch);

	//echo "<hr>";
	echo $output;

	curl_close($ch);

}


function createNewCalendar(){
	$data = array( 
	"title"=>"test calendar",
    "details"=>"This calendar contains the practice schedule and game times.",
    "timeZone"=>"America",
    "hidden"=>false,
    "color"=>"#2952A3",
    "location"=>"Oakland"
	);

	$newcalendar = array("data"=>$data);

	$data_string = json_encode($newcalendar);
	//$data_string = urlencode(($newcalendar));
	//$data_string = $newcalendar;

	//$newcalendar = http_build_query($newcalendar);


	//文件路径，前面要加@，表明是文件上传. 
	$file = array("aken"=>"@D:/wamp/www/calendar/cl.json");


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/calendar/feeds/default/owncalendars/full?alt=jsonc");
	//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, array('json'=>json_encode($newcalendar)));
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $newcalendar);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $file);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	//curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

	//curl_setopt($ch, CURLOPT_PUT, true);
	
	//header
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data;boundary=ABCD','Content-Length: '.strlen($newcalendar))); 
//	curl_setopt($ch, CURLOPT_HTTPHEADER, "User-Agent: Aken+GDoc+Google-API-Java/2.2.1-alpha(gzip)");   
//'User-Agent: Aken GDoc Google-API-Java/2.2.1-alpha(gzip)',            


	//第一次需要如下执行
	$loginInfo = array(
		"Authorization: ".$_SESSION['googleAuth'],
		"GData-Version: 2"
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $loginInfo);

	//针对网站有重定向的设置
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);


	//echo "aken";


	$output = curl_exec($ch);
	curl_close($ch);
	echo $output;
	//echo "<br>aken<br>";
	//echo $data_string;

	//echo $newcalendar;
	//echo "<br>";
	//echo json_encode($newcalendar);

}



function test(){

	echo $_SESSION['googleAuth'];
}





$method = $_GET['method'];

if($method == '0'){
	//echo "0";
	test();
}elseif($method == '1'){
	//echo "1";
	loginGoogleAccount();
}elseif($method == '2'){
	//echo "2";
	getAllCalendars();
	//getAllCalendarsForBegin();
}elseif($method == '3'){
	//echo "3";
	createNewCalendar();
}




//
//session_destroy(); 
?>


