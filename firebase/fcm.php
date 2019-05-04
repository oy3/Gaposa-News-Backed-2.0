<?php

require 'conn.php';

function send_notification($tokens)
{
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'to' => $tokens,
        'priority' => 'high',
        'content_available' => true,

        "notification" => array(
            "title" => 'From Oy3',
            "color" => '#0277BD',
            "body" => 'FCM PUSH NOTIFICATION TEST MESSAGE, Please Ignore!'
        ),


        'data' => array(
            'body' => 'FCM PUSH NOTIFICATION TEST MESSAGE, Please Ignore!',
            'title' => 'From Oy3',
        )

    );
    $headers = array(
        'Authorization:key=AAAAGO0JhO0:APA91bGt7u3w4KY37lLJMNkeFhM7J7mK4QiNBvWHkGaeTAToekngjiigGx_bVRfvH-sAkvRHj-IUc0RRWWSvZcVuepgYJxd8HVRzAtUSiWgIQTuRKPggIsE3j2fAr8rbbQiIPngTLwLr',
        'Content-Type:application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}


$sql = "SELECT token FROM users";

$result = mysqli_query($conn, $sql);
$tokens = array();


if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $tokens = $row["token"];
    }
}

mysqli_close($conn);

$message_status = send_notification($tokens);
echo $message_status;


?>
