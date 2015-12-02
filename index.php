<!DOCTYPE html>
<html>

<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
	<script src="ocrad.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>
	<title></title>
</head>

<body>

	<video id="video" muted autoplay width="640" height="480"></video>
	<canvas id="canvas"></canvas>
	<div class="select">
		<select id="videoSource">
		</select>

	</div>
	<div id="foo"></div>
	<div class="grid">

	</div>
	<script>
		$(document).ready(function() {
			
			var $items;
			$.ajax({
				url: 'select.php',
				type: 'POST'
			})
			.done(function(result) {
				console.log("done")
				$items = result;
				$grid.append($items)
			.masonry('appended', $items);
			})
			.fail(function(result) {
				console.log(result);
			})
			.always(function(result) {
			 console.log("complete " + result);
			});
			var $grid = $('.grid').masonry({
					itemSelector: '.grid-item'
			});

		});

		$("#video").hide();
		$("#canvas").hide();
		$(".select").hide();
		$(document).ready(function() {
			var video = document.querySelector('video');
			var videoSelect = document.querySelector('select#videoSource');
			navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
			var sources = [];

			function gotSources(sourceInfos) {
				for (var i = 0; i !== sourceInfos.length; ++i) {
					var sourceInfo = sourceInfos[i];
					var option = document.createElement('option');
					option.value = sourceInfo.id;
					if (sourceInfo.kind === 'video') {
						sources.push(sourceInfo[i]);
						option.text = sourceInfo.label || 'camera ' + (videoSelect.length + 1);
						videoSelect.appendChild(option);
					} else {
						console.log('Some other kind of source: ', sourceInfo);
					}
				}
			}
			if (typeof MediaStreamTrack === 'undefined' ||
				typeof MediaStreamTrack.getSources === 'undefined') {
				alert('This browser does not support MediaStreamTrack.\n\nTry Chrome.');
			} else {
				MediaStreamTrack.getSources(gotSources);
			}

			function successCallback(stream) {
				window.stream = stream;
				video.src = window.URL.createObjectURL(stream);
				video.play();
			}

			function errorCallback(error) {
				alert("navigator.getusermedia error: ", error);
			}

			function start() {
				if (window.stream) {
					video.src = null;
					window.stream.stop();
				}
				var videoSource = videoSelect.value;
				var canvas = document.getElementById('canvas');
				var context = canvas.getContext("2d");
				canvas.width = window.innerWidth;
				canvas.height = window.innerHeight;
				var videoObj = {
					video: {
						optional: [{
							sourceId: videoSource
						}]
					}

				};
				// var cool = setInterval(awesome, 20);

				navigator.getUserMedia(videoObj, successCallback, errorCallback);
				$("html").on("click", function() {
					vid = document.getElementById('video');
					context.drawImage(video, 0, 0);
					var dataURL = canvas.toDataURL("image/jpeg");
					console.log(dataURL);
					insert(dataURL);
				});
			}
			$("html").on("swiperight", function() {
				$("#videoSource option:selected").next().attr('selected', 'selected');
				start()
			})
			$("html").on("swipeleft", function() {
				$("#videoSource option:selected").prev().attr('selected', 'selected');
				start()
			})
			start();
		});

		function insert(x) {
			$(document).ready(function() {
				var picture = x;
				var dataString = 'picture=' + picture;
				$.ajax({
						url: 'insertDB.php',
						type: 'POST',
						data: dataString,
						cache: false
					})
					.done(function(result) {
						newNotification(x, result)
						console.log(result);
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});

			});
		}
		function newNotification(dataurl, result) {
			var options = {
				body: result,
				icon: dataurl
			}
			if (!("Notification" in window)) {
				alert("this browser does not support desktop Notification");
			} else if (Notification.permission === "granted") {
				var n = new Notification("hello", options);
				n.body;
				n.data;
			} else if (Notification.permission !== "denied") {
				Notification.requestPermission(function(permission) {
					if (permission === "granted") {
						var n = new Notification("hi there", options);
						n.body;
						n.data;
					}
				});
			}
		}
		function run() {
			$.get("createTable.php");
			return false;
		}
	</script>
</body>

</html>
