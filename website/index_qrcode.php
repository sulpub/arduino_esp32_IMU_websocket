<?php

if(isset($_GET["ip_websocket"])) 
	{
	$ip_websocket='"ws://' . $_GET["ip_websocket"] . ':81"' ;
	}
else
	{
	$ip_websocket="\"ws://192.168.0.122:81\"";
	}

if(isset($_GET["infos"])) 
	{
	$infos=1 ;
	}
else
	{
	$infos=0 ;
	}
	
?>
<!--ip_websocket infos -->
<html>
  <head>
    		<style>
			body { margin: 0; }
			canvas { 
					width: 100%;
					height: 100%;
					background-image: url(images/lac_annecy1.jpg);
					background-size: cover;
					display: block;
					background: rgba(0, 0, 0, 0.0) /* Green background with 30% opacity */
			}
		</style>
		
	<meta charset="utf-8" />
	<link rel="shortcut icon" href="dodo.ico">
	<title>ESP32_MPU9250_websocket (Arduino-ESP32-websocket)</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<script type="text/javascript" src="js_script/smoothie.js"></script>

	<script src="js_script/three.min.js"></script>
	<script src="js_script/DDSLoader.js"></script>  
	<script src="js_script/three.module.js"></script> 

    <script>	
	
		  var scene;
		  var camera;
		  var renderer;
		  var cube;
		  var device_connected=0;

		  function render() {
			requestAnimationFrame(render);
			renderer.render(scene, camera);
		  }
	  
		  function CubeBeginOrigin() {
			scene = new THREE.Scene();
			camera = new THREE.PerspectiveCamera(
			  75,
			  window.innerWidth / window.innerHeight,
			  0.1,
			  1000
			);
			renderer = new THREE.WebGLRenderer();

			renderer.setSize(window.innerWidth, window.innerHeight);
			document.body.appendChild(renderer.domElement);
			
			var geometry = new THREE.BoxGeometry(100, 100, 100);
			
			var cubeMaterials = [
			  new THREE.MeshBasicMaterial({ color: 0xfe4365 }),
			  new THREE.MeshBasicMaterial({ color: 0xfc9d9a }),
			  new THREE.MeshBasicMaterial({ color: 0xf9cdad }),
			  new THREE.MeshBasicMaterial({ color: 0xc8cba9 }),
			  new THREE.MeshBasicMaterial({ color: 0x83af98 }),
			  new THREE.MeshBasicMaterial({ color: 0xe5fcc2 })
			];

			var material = new THREE.MeshFaceMaterial(cubeMaterials);
			cube = new THREE.Mesh(geometry, material);
			scene.add(cube);

			camera.position.z = 200;

			render();
		  }

		function animate() {

			if (device_connected==0)
			{
			requestAnimationFrame( animate );

			var time = Date.now() * 0.0005;

				cube.rotation.x = time;
				cube.rotation.y = time;

			renderer.render( scene, camera );
			}
		}

		function change_texture() {

			requestAnimationFrame( change_texture );

			var time_texture = Date.now() * 5;  //5sec

			render();

		}


		function CubeBegin() {
			scene = new THREE.Scene();
			var texture = new THREE.TextureLoader().load( 'images/face_HD1.gif' );

			var texture2 = new THREE.TextureLoader().load( 'images/face_HD1.gif' );
			texture2.magFilter = THREE.LinearFilter;
			texture2.minFilter = THREE.LinearFilter;
			texture2.mapping = THREE.CubeReflectionMapping;
			texture2.needsUpdate = true;
				
			camera = new THREE.PerspectiveCamera(
			  75,
			  window.innerWidth / window.innerHeight,
			  0.1,
			  1000
			);

			renderer = new THREE.WebGLRenderer( { antialias: true } );

			renderer.setSize(window.innerWidth, window.innerHeight);
			document.body.appendChild(renderer.domElement);
			var geometry = new THREE.BoxGeometry(100, 100, 100);

			var TextureMaterial = new THREE.MeshBasicMaterial( { map: texture } );

			var TextureMaterial2 = [
			  new THREE.MeshBasicMaterial({ map: texture2 }),
			  new THREE.MeshBasicMaterial({ map: texture2 }),
			  new THREE.MeshBasicMaterial({ map: texture2 }),
			  new THREE.MeshBasicMaterial({ map: texture2 }),
			  new THREE.MeshBasicMaterial({ map: texture2 }),
			  new THREE.MeshBasicMaterial({ map: texture2 })
			];

			var material = new THREE.MeshFaceMaterial(TextureMaterial2);
			cube = new THREE.Mesh(geometry, material);
			scene.add(cube);
			//meshes.push( cube );

			camera.position.z = 200;

			render();
		}
	  

		function WebSocketBegin() {
			CubeBegin();
			device_connected=0;
			animate();
			//animate();
			if ("WebSocket" in window) {
			  // Let us open a web socket
			  var ws = new WebSocket(<?php echo $ip_websocket;?>);

			  ws.onopen = function() {
				// Web Socket is connected
				//window.alert("Connected to device");
				document.getElementById("socketconnexion").innerHTML  = "Device connected";
				device_connected=1;
			  };

			  ws.onmessage = function(evt) {
				//create a JSON object
				var jsonObject = JSON.parse(evt.data);
				var q0 = jsonObject.q1/1000;
				var q1 = jsonObject.q2/1000;
				var q2 = jsonObject.q3/1000;
				var q3 = jsonObject.q0/1000;
				var tempcpu =  jsonObject.Tu;

				var quat1 = new THREE.Quaternion(q1, q2, q3, q0);
				//var quat2 = new THREE.Quaternion(1, 0, 0, 0);
				var quat2 = new THREE.Quaternion(0, 1, 0, 0);


				cube.quaternion.multiplyQuaternions(quat1, quat2);
				
				document.getElementById("q0").innerHTML  = "Q0:" + q0 + "";
				document.getElementById("q1").innerHTML  = "Q1:" + q1 + "";
				document.getElementById("q2").innerHTML  = "Q2:" + q2 + "";
				document.getElementById("q3").innerHTML  = "Q3:" + q3 + "";
				document.getElementById("TempCPU").innerHTML  = "Tcpu:" + tempcpu + "°C";
			  };

			  ws.onclose = function() {
				// websocket is closed.
				//alert("Connection is closed...");
				document.getElementById("socketconnexion").innerHTML  = "Device not connected";
				//animate();
				device_connected=0;
			  };
			} else {
			  // The browser doesn't support WebSocket
			  alert("WebSocket NOT supported by your Browser!");
			}
		}
		
    </script>
  </head>

  <body onLoad="javascript:WebSocketBegin()">

<?php
if($infos==1)
{
  	echo "<div id=\"q0\">Device not connected</div>";
	echo "<div id=\"q1\">Device not connected</div>";
	echo "<div id=\"q2\">Device not connected</div>";
	echo "<div id=\"q3\">Device not connected</div>";
	echo "<div id=\"TempCPU\">Device not connected</div>";
}
?>
	
	<div id="socketconnexion">Device not connected</div>
	<div id="qrcode"><img src="qrcode.png"></div>
	
  </body>
</html>
