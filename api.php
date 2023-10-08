<?php
header("Access-Control-Allow-Origin: *"); // مجوز دسترسی به API از هر منبعی

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // دریافت مختصات کاربر از درخواست POST
  $userLat = $_POST["user_lat"];
  $userLon = $_POST["user_lon"];

  // مختصات فروشگاه‌ها
  $shops = array(
    array("name" => "فروشگاه 1", "lat" => 34.7862666945053, "lon" => 48.522416332552645),
    array("name" => "فروشگاه 2", "lat" => 34.78986168468382, "lon" => 48.51726649110268),
    array("name" => "فروشگاه 3", "lat" => 34.786407677464375, "lon" => 48.507610538383986),
    array("name" => "فروشگاه 4", "lat" => 34.79617016118829, "lon" => 48.50786803045648)
  );

  // محاسبه فاصله و پیدا کردن نزدیک‌ترین فروشگاه به کاربر
  $minDistance = PHP_FLOAT_MAX;
  $nearestShop = null;
  for ($i = 0; $i < count($shops); $i++) {
    $distance = calculateDistance($userLat, $userLon, $shops[$i]["lat"], $shops[$i]["lon"]);
    if ($distance < $minDistance) {
      $minDistance = $distance;
      $nearestShop = $shops[$i];
    }
  }

  // ارسال نام و فاصله نزدیک‌ترین فروشگاه به کاربر
  echo json_encode(array("name" => $nearestShop["name"], "distance" => round($minDistance, 2)));
} else {
  // درخواست نامعتبر
  http_response_code(400);
  echo json_encode(array("error" => "درخواست نامعتبر"));
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
  // شعاع کره زمین به کیلومتر
  $radius = 6371;

  // تبدیل مختصات به رادیان
  $lat1 = deg2rad($lat1);
  $lon1 = deg2rad($lon1);
  $lat2 = deg2rad($lat2);
  $lon2 = deg2rad($lon2);

  // محاسبه فاصله
  $distance = $radius * acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lon2 - $lon1));
  return $distance;
}
?>
