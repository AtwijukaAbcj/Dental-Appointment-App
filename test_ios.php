<?php
session_start();
include'application/config.php';

if($_POST['message1'])
{

// API access key from Google API's Console
$querya=mysqli_query($conn,"select * from clinic_notification");
$resa=mysqli_fetch_array($querya);
$google_api_key=$resa['apikey'];

// Notification Data
$query=mysqli_query($conn,"select * from clinic_tokendata");
$i=0;
$reg_id=array();
while ($res=mysqli_fetch_array($query))
{

$reg_id[$i]= $res['device_id'];
$i++;
}

$registrationIds = $reg_id;
// prep the bundle
$massage = $_POST['message1'];
$msg = array(
        'body'  => $massage,
        'title'     => "Notification",
        'vibrate'   => 1,
        'sound'     => 1,
    );
$fields = array(
            'registration_ids'  => $registrationIds,
            'notification'      => $msg
        );

$headers = array(
            'Authorization: key=' . $google_api_key,
            'Content-Type: application/json'
        );

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );

if ($result === FALSE){
        die('Curl failed: ' . curl_error($ch));
    }   

    curl_close($ch);
    $response=json_decode($result,true);
    //print_r($response); exit();
    if($response['success']>0)
    {
        //echo "insert into dr_notification values(NULL,'".$massage."')"; exit;
        $notification="insert into clinic_sendnotification values(NULL,'".$massage."')";
        $insertres = mysqli_query($conn,$notification);
        if($insertres)
        {
            echo 1;
        }
    }
    else
    {
       echo 0;
    }
}
?>