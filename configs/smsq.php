<?php

/**
 * SmsQ Sms Gateway config file
 */

/**
 * Api credentials
 */
define("SMSQ_API_KEY", "YOUR API KEY");
define("SMSQ_CLIENT_ID", "YOUR CLIENT ID");
define("SMSQ_SENDER_ID", "YOUR SENDER ID");

/**
 * Send sms to the user
 */
function sendSms(string $to, string $message)
{

    /**
     * Add county code (+88) at the begining if not added by the user
     */
    if (!strpos($to, '88')) {

        $to = '88' . $to;
    }

    $data = [
        "ApiKey" => SMSQ_API_KEY,
        "ClientId" => SMSQ_CLIENT_ID,
        "senderId" => SMSQ_SENDER_ID,
        "MobileNumbers" => $to,
        "Message" => $message
    ];

    $headers = [
        'Content-Type: application/json',
        'Type: json',
    ];

    /**
     * Initialize a curl request to send sms request to the smsq api endpoint
     */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.smsq.global/api/v2/SendSMS");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($response);

    /**
     * If no error code returned from the gateway that means sms send successfully
     */
    if ($result->ErrorCode === 0) {

        return true;
    }

    return false;
}
