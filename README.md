## 需求
php version 8.3

## 流程
使用者 → [允許推播] → 前端拿 token → 傳給後端 → 後端存 token 並推播 Firebase 

→ 傳送給對應設備 → 前端 onMessage / firebase-messaging-sw.js 處理顯示  

## 設置
- firebase console 產生密鑰 adminsdk json 修改名稱 => my-firebase-adminsdk.json 放置根目錄
- firebase.js 修改 firebaseConfig、vapidKey，參數由 firebase console 取得
- firebase-messaging-sw.js 修改 firebaseConfig，參數由 firebase console 取得
- token 由 receive.html 取得 firebase.js token 傳至後端

## Curl 推播訊息
```
curl --location 'https://fcm.googleapis.com/v1/projects/<YOUR-PROJECT-ID>/messages:send' \
--header 'Content-Type: application/json' \
--header 'Authorization: <YOUR-ACCESS-TOKEN>' \
--data '{
    "message": {
        "token": "<CLIENT_TOKEN>",
        "notification": {
            "title": "Background Message Title",
            "body": "Background message body"
        },
        "webpush": {
            "fcm_options": {
                "link": "https://dummypage.com"
            }
        }
    }
}'
```
```
接收訊息 http://127.0.0.1/receive.html ，使用 localhost 會收不到訊息

<YOUR-PROJECT-ID> firebase console 取得

<YOUR-ACCESS-TOKEN> POSTMAN 登入 Google 授權 firebase

<CLIENT_TOKEN> 由 receive.html 取得 firebase.js token
```

## send.php 推播訊息(單個設備)
```
curl --location 'http://127.0.0.1/send.php?token=token' \
--header 'Content-Type: application/json' \
--data '{
    "title": "麵包超人",
    "body": "你好!",
    "attributes": {
        "attributes1": "土司", 
        "attributes2": "咖哩", 
        "attributes3": "炸蝦"
    }
}'
```
## subscribeToTopic.php 訂閱主題
```
curl --location 'http://127.0.0.1/subscribeToTopic.php?token=token' \
--header 'Content-Type: application/json' \
--data '{
    "topic": "matchday"
}'
```
## sendToTopic.php 推播訊息至主題(需先訂閱)
```
curl --location --request GET 'http://127.0.0.1/sendToTopic.php?token=token' \
--header 'Content-Type: application/json' \
--data '{
    "topic": "matchday",
    "title": "麵包超人!",
    "body": "你好!",
    "attributes": {
        "attributes1": "土司", 
        "attributes2": "咖哩", 
        "attributes3": "炸蝦"
    }
}'
```
## unSubscribeFromTopic.php 取消訂閱主題
```
curl --location --request GET 'http://127.0.0.1/unSubscribeFromTopic.php?token=token' \
--header 'Content-Type: application/json' \
--data '{
    "topic": "matchday"
}'
```
## unSubscribeFromAllTopics.php 取消訂閱所有主題
```
curl --location 'http://127.0.0.1/unSubscribeFromAllTopics.php?token=token'
```




