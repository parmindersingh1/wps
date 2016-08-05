<?php
class GCM {

    // constructor
    function __construct() {
        
    }

    // sending push message to single user by gcm registration id
    public function send($to, $message, $headMessage) {
        $fields = array(
            'to' => $to,
            'data' => array( "message" => $message, "headMessage" => $headMessage),
        );
        return $this->sendPushNotification($fields);
    }

    // Sending message to a topic by topic id
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by gcm registration ids
    public function sendMultiple($registration_ids, $message, $headMessage) {
        
        $fields = array(
            'registration_ids' => $registration_ids,
            'priority' => 'high',
            'data' => array( "message" => $message, "headMessage" => $headMessage)
        );
        
        return $this->sendPushNotification($fields);
    }

    // function makes curl request to gcm servers
    private function sendPushNotification($fields) {

        // include config
        include_once __DIR__ . '/Config.php';
        // Set POST variables
        // $url = 'https://gcm-http.googleapis.com/gcm/send';
        $url = 'https://android.googleapis.com/gcm/send';
        // $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        
        // // Open connection
        // $ch = curl_init();
        // // Set the url, number of POST vars, POST data
        // curl_setopt($ch, CURLOPT_URL, $url);

        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // // Disabling SSL Certificate support temporarly
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        // // Execute post
        // $result = curl_exec($ch);
        // if ($result === FALSE) {
        //     die('Curl failed: ' . curl_error($ch));
        // }

        // // Close connection
        // curl_close($ch);
        // // file_put_contents( 'debug' . time() . '.log', var_export( $result, true));
        // return $result;


        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close( $ch );   

        // open file
         $fd = fopen('../mylog.log', "a");
         // append date/time to message
         $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . (string)$result; 
         // write string
         fwrite($fd, $str . "\n");
         // close file
         fclose($fd);
   
        

        $flag = json_decode($result)->success;
        if($flag >= 1){
            return true;
        }else{
            return false;
        }
    }

}

?>

