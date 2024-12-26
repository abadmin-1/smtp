<?php
$botToken = "6584007114:AAGVUSI13Mgy2M5MeTXIkyCv0WLlLE2cTms"; // توکن ربات تلگرام خود را جایگزین کنید
$chatId = "-1001683620220"; // شناسه گروه یا چت
$userId = 618480216; // شناسه کاربری شما
$hashtag = "#tp"; // هشتگ مورد نظر

// API URL برای دریافت آپدیت‌ها
$apiUrl = "https://api.telegram.org/bot$botToken/getUpdates";

// پروکسی که شما اعلام کردید
$proxy = "";  // آدرس پروکسی

// ارسال درخواست به API تلگرام با استفاده از cURL و پروکسی
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROXY, $proxy);  // تنظیم پروکسی

$response = curl_exec($ch);
curl_close($ch);

// تبدیل پاسخ به آرایه
$data = json_decode($response, true);

// بررسی و فیلتر کردن پیام‌ها
if (isset($data['result'])) {
    foreach (array_reverse($data['result']) as $message) {
        // بررسی اینکه آیا پیام از شما آمده و شامل #tp است
        if (isset($message['message']['from']['id']) && $message['message']['from']['id'] == $userId) {
            $text = $message['message']['text'] ?? ''; // متن پیام
            $chatIdFromMessage = $message['message']['chat']['id']; // شناسه چت

            // اگر پیام از همان گروه و هشتگ #tp دارد
            if ($chatIdFromMessage == $chatId && strpos($text, $hashtag) !== false) {
                // حذف هشتگ #tp از پیام
                $cleanText = str_replace($hashtag, '', $text);

                // نمایش پیام
                echo " " . $cleanText . "<br>";
                break; // بعد از پیدا کردن اولین پیام، از حلقه خارج می‌شود
            }
        }
    }
} else {
    echo "هیچ پیامی یافت نشد!";
}
?>
