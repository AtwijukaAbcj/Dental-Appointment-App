<?php
$url = "https://fcm.googleapis.com/fcm/send";
$token = "duV5yVq0lUE:APA91bHEuAR0cN_cS99-MhQMW90H87P0OgzS_hGcmsr4FNv1YibCO5tIzzLGlL78KbOS_CWOCOO-jne9bLjoH8SgMjLRSJlhk2Gtgbr6wijiVDrltbHmTDHMbwy6ltEantmLQxUaa9bF";
$serverKey = 'AAAAuXYAtQ8:APA91bGCOCqS7LwALKKJsPorRwN7sbbx8mSkepr4YgD4VuYl_zA4LyUcg0qZiwfrWMgINHskD8WiDAhtgRrfcG44HQNW11bEUveqprg7FynPBau82WhRb6NX5V_J8NOl80Mbq90l4sV-';
$title = "Title";
$body = "Body of the message";
$notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
$json = json_encode($arrayToSend);
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: key='. $serverKey;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST,

"POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
//Send the request
$response = curl_exec($ch);
//Close request
if ($response === FALSE) {
die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
?>