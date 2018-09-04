<?php
/**
 * Created by PhpStorm.
 * User: Hassan Saeed
 * Date: 2/22/2018
 * Time: 4:18 PM
 */

namespace App\Libraries\FirebasePushNotifications;


class Firebase
{


    // sending push message to single user by firebase reg id
    public function send($to, $message, $pushData)
    {
        $fields = array(
            'to' => $to,
            'data' => $message,
//            'notification' => $message,
            'notification' => $pushData
        );
        return $this->sendPushNotification($fields);
    }

    // Sending message to a topic by topic name
    public function sendToTopic($to, $message)
    {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message)
    {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // function makes curl request to firebase servers
    private function sendPushNotification($fields)
    {

        //require_once __DIR__ . '/config.php';

        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
//            'Authorization: key=' . FIREBASE_API_KEY,
            'Authorization: key=AAAARjiKmhE:APA91bEK_5sSQjZe86ELZSlk3bFIqw7QzSf3nHYx-xT2wmSDbl9ojpwAajobZhbSLu_QG4DQT4Uh5cmC8H7YlScGqAo_BP4Bj78zYUb0IxJ4gy6s6Ojtyi3OpHmnMnZORx7m5TDi4ete',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }


}