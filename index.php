<?php
$toilets = array();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/header.css">
	<title>washget</title>
	<link rel="stylesheet" href="css/index.css">
	<style>
		html, body, .map { width: 100%; height: 100%; }
		#map_canvas { width: 80%; height: 80%; }
	</style>
	<script src="./js/library/jquery-2.1.3.min.js"></script>
	<script>
	var rows = [];
	function link() {
		location.href = 'login';
	}
	var storage = localStorage;
	if ( storage.user_id != null ) {
		setTimeout("link()", 0);
	}
		$().ready(function(){
			initialize();
		});
	</script>
	</head>
	<body>
		<header class="header clearfix">
			<div class="header-left">washget</div>
			<div class="header-right">
				<ul>
					<li><a href="#map_canvas">Map</a></li>
					<li><a href="#list">List</a></li>
					<li><a href="">Acount</a></li>
				</ul>
			</div>
		</header>
		<div class="map">
			<div id="map_canvas"></div>
		</div>

		<div class="list">

		</div>
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script>
	function initialize(){
		if (typeof(navigator.geolocation) != 'undefined') {
			navigator.geolocation.watchPosition(success, error);
		}
	}
	function success(position){
		var lat = position.coords.latitude;
		var lng = position.coords.longitude;

		var latlng = new google.maps.LatLng(lat, lng);

		// // カスタム開始
		var washgetType = new google.maps.StyledMapType(styleOptions, {name: "Washget Map"});
		var styleOptions = [{"featureType":"water","elementType":"all","stylers":[{"hue":"#7fc8ed"},{"saturation":55},{"lightness":-6},{"visibility":"on"}]},{"featureType":"water","elementType":"labels","stylers":[{"hue":"#7fc8ed"},{"saturation":55},{"lightness":-6},{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"hue":"#83cead"},{"saturation":1},{"lightness":-15},{"visibility":"on"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#f3f4f4"},{"saturation":-84},{"lightness":59},{"visibility":"on"}]},{"featureType":"landscape","elementType":"labels","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbbbbb"},{"saturation":-100},{"lightness":26},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#ffcc00"},{"saturation":100},{"lightness":-35},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#ffcc00"},{"saturation":100},{"lightness":-22},{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"hue":"#d7e4e4"},{"saturation":-60},{"lightness":23},{"visibility":"on"}]}];

		var mapOptions = {
			zoom: 16,
			center: latlng,
			mapTypeControlOptions: {
				mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
			},
		};

		var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
		map.mapTypes.set('map_style', washgetType);
		map.setMapTypeId('map_style');

		// var icon = new google.maps.MarkerImage('icon_webkikaku.png',/*アイコンの場所*/
		// 	new google.maps.Size(53,64),/*アイコンのサイズ*/
		// 	new google.maps.Point(0,0)/*アイコンの位置*/
		// );

		dropPins(map);
	}
	function error(e){
			alert("エラーが発生しました - " + e.message);
	}

	function dropPins(map) {
		var url = 'http://localhost/washget/api/0.1.0/toilet/?type=all';
		$.getJSON(url, function (data) {
			for (var key in data) {
				var latlng = new google.maps.LatLng(data[key]['lati'], data[key]['long']);
				createMarker(latlng, data[key]['host_comment'], data[key]['user_id'], map);

				var sex;
				if (data[key]['sex'] === 0 ) {
					sex = '男';
				} else {
					sex = '女';
				}
				$('.list').append('<div class="toilet-item"><div class="toilet-img"><img src="http://www.takara-standard.co.jp/topicsnews/images/20090319timonil1.jpg"><div class="detail"><div class="location">現地から50m</div><div class="price">¥600</div></div></div><div class="profile"><div class="name"><p>' + data[key]['family_name'] + ' ' + data[key]['first_name'] + '<p>' + sex + '</p></div><div class="prof-img"><img src="https://scontent.xx.fbcdn.net/hphotos-xpt1/v/t34.0-12/11650730_391362624390726_762859358_n.jpg?oh=4430e47104d3d102389f2d1dcce68357&oe=5590B755"></div></div></div>');
			}
		});
	}
	function createMarker(latlng,comment, id, map){
		var infoWindow = new google.maps.InfoWindow();
		var marker = new google.maps.Marker({position: latlng, map: map});
		google.maps.event.addListener(marker, 'click', function() {
			infoWindow.setContent(comment + '<br><form action="looker.php" method="Get"><input type="hidden" name="toilet" value="' + id + '"><input type="submit" value="|дﾟ)"></form>');
			infoWindow.open(map,marker);
			// currentWindow = infoWindow;
		});
	}
	</script>

	</body>
</html>
