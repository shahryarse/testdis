$(document).ready(function() {
  // درخواست موقعیت کاربر
  navigator.geolocation.getCurrentPosition(function(position) {
    // ذخیره موقعیت کاربر
    var userLat = position.coords.latitude;
    var userLon = position.coords.longitude;

    // ارسال درخواست به API
    $.ajax({
      url: "https://cafehamedan.ir/a/api.php",
      type: "POST",
      data: {
        user_lat: userLat,
        user_lon: userLon
      },
      success: function(response) {
        // نمایش لیست فروشگاه ها
        var shops = JSON.parse(response);
        var list = "";
        for (var i = 0; i < shops.length; i++) {
          list += "<li>" + shops[i].name + " (فاصله: " + shops[i].distance + " کیلومتر)</li>";
        }
        $("#shops").html(list);
      },
      error: function(error) {
        // نمایش خطا
        alert(error.responseJSON.error);
      }
    });
  }, function(error) {
    alert(error.message);
  });
});
