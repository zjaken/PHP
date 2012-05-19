<?php
echo "test curl ...begin";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://203.208.46.180");
//
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($ch);
echo "<hr>";
echo $output;
echo "test curl ...end";

echo "+++++++++++++++++++++++++++++++++++++++++";

?>