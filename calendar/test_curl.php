<?php
//echo "test curl ...begin";
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, "http://www.baidu.com");
//$output = curl_exec($ch);
//echo "<hr>";
//echo $output;
//echo "test curl ...end";



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
	curl_setopt($ch, CURLOPT_URL, "https://203.208.46.180/accounts/ClientLogin");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	//针对网站有重定向的设置
	if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off'))
	{
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	}


	$output = curl_exec($ch);

	echo $output;

	curl_close($ch);

}

echo "test curl ...begin";
loginGoogleAccount();
echo "test curl ...end";

echo "+++++++++++++++++++++++++++++++++++++++++";

?>