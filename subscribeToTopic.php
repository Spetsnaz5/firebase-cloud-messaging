<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\MessagingException;

try {

    $token = $_REQUEST['token'] ?? null;

    if (is_null($token))
        throw new Exception('無定義 token');

    $contents = file_get_contents('php://input');

    if (json_validate($contents))
        $contents = json_decode($contents, true);

    $topic = $contents['topic'] ?? 'matchday';

    $file = 'my-firebase-adminsdk.json';
    if (! file_exists($file))
        throw new Exception('無 Firebase 設定檔');

    $factory = (new Factory)->withServiceAccount($file);

    $messaging = $factory->createMessaging();

    $registrationTokens = [
        $token
    ];

    # https://github.com/kreait/firebase-php/blob/7.x/docs/cloud-messaging.rst
    // 訂閱主題
    $result = $messaging->subscribeToTopic($topic, $registrationTokens);

    dd($result);

} catch (MessagingException $e) {
    dd($e);
} catch (Exception $e) {
    dd($e);
}
