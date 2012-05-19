<?php

//
session_start();


header("Content-Type:text/html;charset=UTF-8");
echo 'CURL中文';
echo '<hr>';

//phpinfo();

$email = "zj.aken@gmail.com";
$password = "zjbb760612";

$data = array(    
    'accountType' => 'GOOGLE',    
    'Email' => $email,    
    'Passwd' => $password,    
    'service' => 'cl',  //google 一系列api 的简写，在google 上能找到，可以换成你想要的服务简写  
    'source' => 'ZCalendar',  //给你自己的应用程序命名  
);   






$loginInfo = array( 
"Authorization: GoogleLogin auth=DQAAALkAAAA4t5vC2kElTAq09a8AmtlmwJWWTpAfm0xGPaPn4GgWNJ5VY_2nqfUoGkGNXjeiEdW6gMm0QP8qw73nhYja1KIXmmiEL1uFvscBNeMv3L9OyB2L2ugyXShQSO0wQxFNmHVEWpD-jjlg_ep45y-LOC2L-7ec7JLUmHbhRIqPzTfz4SaQ_BP52unhLftSr22GR6XWPRfpsGyDChMZrNkBU139_8OhyJeqPHKJC93elIt_qj5lSPLBJDaMdWleUusNXBI",
"GData-Version: 2" 
); 






$VERSION = "GData-Version: 3";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/calendar/feeds/default/allcalendars/full?alt=jsonc");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array($_SESSION['googleAuth'],$VERSION));
curl_setopt($ch, CURLOPT_HTTPHEADER, $loginInfo);

$output = curl_exec($ch);

echo "<hr>";
echo $output;

curl_close($ch);



?>

