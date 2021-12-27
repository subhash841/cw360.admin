<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Notification {

    function __construct() {
        $path = dirname( __DIR__ ) . '/third_party/ApnsPHP/';
        $this -> apnsDir = $path;

        $this -> _apns_req();

        return;
    }

    public function get_ids_and_fields(  $fields, $userid = 0 ) {

        $android_target = array ();
        $ios_target = array ();
        $notification_array = array ();

        $CI = & get_instance();

        $resultset = get_device_token( $userid );

        if ( ! empty( $resultset ) ) {
            foreach ( $resultset as $devices ) {
                if ( $devices[ 'device_type' ] == "Android" ) {
                    $android_target[] = $devices[ 'device_token' ];
                }
                
            }

            if ( ! empty( $android_target ) ) {
                $this -> send_android_notif( $android_target, $fields );
            }
           

        }
    }

    public function send_android_notif( $target, $fields ) {

        if ( is_array( $target ) && count( $target ) > 1 ) {
            $notif[ 'registration_ids' ] = $target;
        } else if ( count( $target ) == 0 ) {
            return; //send back
        } else {
            $notif[ 'to' ] = $target[ 0 ];
        }

        $notif[ 'data' ] = $fields;

        $apiKey = 'AAAA6Y25d-0:APA91bEEi4zvHsMbeNsxcSv2mIPgs4d3nfZA6jrKYcx-Akpi6M9gkyDBf9JjgXztqqmfurQSjv4ujYeBa0vheJU5t5gkeluxI9gupTlyA9w9mjeWX9oAFvDTeuv5XNatc2ZxeFmXcS8F';
        // $apiKey = 'AIzaSyCJnziR-Wq8qTb1vprntASq_hWdk6zFmQ4';
        $headers = array ( "Content-Type:" . "application/json", "Authorization:key=" . $apiKey );

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send" );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $notif ) );
        $result = curl_exec( $ch );
        // var_dump($result);die;
    }

   

    private function _apns_req() {

        require_once $this -> apnsDir . 'Abstract.php';
        require_once $this -> apnsDir . 'Exception.php';
        require_once $this -> apnsDir . 'Feedback.php';
        require_once $this -> apnsDir . 'Message.php';
        require_once $this -> apnsDir . 'Log/Interface.php';
        require_once $this -> apnsDir . 'Log/Embedded.php';
        require_once $this -> apnsDir . 'Message/Custom.php';
        require_once $this -> apnsDir . 'Message/Exception.php';
        require_once $this -> apnsDir . 'Push.php';
        require_once $this -> apnsDir . 'Push/Exception.php';
        require_once $this -> apnsDir . 'Push/Server.php';
        require_once $this -> apnsDir . 'Push/Server/Exception.php';

        return;
    }

}
