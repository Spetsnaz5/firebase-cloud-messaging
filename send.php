<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\MessagingException;

try {

    $token = $_GET['token'] ?? null;

    if (is_null($token))
        throw new Exception('無定義 token');

    $factory = (new Factory)->withServiceAccount('my-firebase-adminsdk.json');

    $messaging = $factory->createMessaging();

    $message = CloudMessage::new()
        ->withNotification(Notification::create('Title', 'Body'))
        ->withData(['key' => 'value', 'key2' => 'value', 'key3' => 'value'])
        ->toToken($token);

    $result = $messaging->send($message);

    dd($result);
} catch (MessagingException $e) {
    dd($e);
} catch (Exception $e) {
    dd($e);
}
