<html>
<head>
    <link rel="icon" href="/images/icon.jpg" type="image/png">
    <title>Ravenor World Map</title>
    <link rel="stylesheet" href="/map/libs/leaflet-0.7.3.css" />
    <link rel="stylesheet" href="/map/libs/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="/map/libs/MarkerCluster.css" />
    <link rel="stylesheet" href="/map/libs/L.Control.Zoomslider.css" />
    <link rel="stylesheet" href="/map/libs/chosen.min.css" />

    <link rel="stylesheet" href="/map/libs/leaflet.label.css" /> 
    <link rel="stylesheet" href="/map/libs/bootstrap-3.3.2.min.css">

    <style>
		html, body {
			margin: 0;
			padding: 0;
			height: 100%;
			width: 100%;
			overflow: hidden;
            background-color: #0d1117;
            color: silver;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
		}

        #mapTitle {
            color: silver;
            font-weight: bold;
            padding: 16px 12px 4px 12px;
            text-align: center;
            user-select: none;
            width: 80vw;
            max-width: 1200px;
			margin-top: 20px; 
        }

        #mapSubtitle {
            color: silver;
            font-size: 16px;
            font-weight: normal;
            padding: 0 12px 12px 12px;
            text-align: center;
            user-select: none;
            width: 80vw;
            max-width: 1200px;
        }

        #mapBox {
            border: 2px solid silver;
            width: 80vw;
            max-width: 1200px;
            height: 70vh;
            background-color: black;
            box-sizing: border-box;
            position: relative;
            display: flex;
            flex-direction: column;
			margin-top: 10px;
        }

		#map {
			flex-grow: 1;
			background-color: black;
			position: relative;
		}

        img { 
            image-rendering: optimizeSpeed;
            image-rendering: -moz-crisp-edges;
            image-rendering: -o-crisp-edges;
            -ms-interpolation-mode: nearest-neighbor; 
            image-rendering: pixelated;
        }

        form.form-inline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            gap: 8px;
        }

        form.form-inline button.btn {
            min-width: 35px;
            padding: 5px 10px;
            font-weight: bold;
        }

        form.form-inline .input-group {
            flex-grow: 1;
            min-width: 100px;
        }

        form.form-inline select.form-control {
            width: 100%;
            height: 32px;
            font-size: 14px;
            padding: 3px 6px;
        }
        
        .leaflet-div-icon {
            background: transparent;
            font-size:16px;
            color: #30a33b;
            font-weight: bold;
            border: none;
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
            text-align:center;
            z-index: 999999999 !important;
        }
		
		.leaflet-right {
			display: none;
		}

        #floorControl {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            width: 260px;
            color: #333;
            z-index: 1000;
            user-select: none;
        }

        #footer {
            color: silver;
            margin-top: 16px;
            font-size: 14px;
            user-select: none;
            text-align: center;
            width: 100%;
        }

		@font-face {
			font-family: 'Martel';
			src: url('/martel.ttf') format('truetype'); 
			font-weight: normal;
			font-style: normal;
		}
    </style>

    <script src="/map/libs/byte64.js"></script>
    <script src="/map/libs/jquery-1.11.2.min.js"></script>
    <script src="/map/libs/leaflet-0.7.3.js"></script>
    <script src="/map/libs/leaflet.markercluster.js"></script>
    <script src="/map/libs/L.Control.Zoomslider.js"></script>
    <script src="/map/libs/leaflet.label.js"></script>
    <script src="/map/libs/chosen.jquery.min.js"></script>
    <script src="/map/libs/convex_hull.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

    <div id="mapTitle" style="font-family: 'Martel', sans-serif; font-size: 44px; font-weight: normal; display: flex; align-items: center; justify-content: center; gap: 12px;">
		<span>Ravenor Map Explorer</span>
	</div>

    <div id="mapSubtitle" style="font-style: italic;">Explore every corner of the world!</div>

    <div id="mapBox">
        <div id="map"></div>

        <div id="floorControl">
            <span style="display: block; font-size: 14px; font-weight: bold; color: #333;">
                <i class="fas fa-layer-group" style="margin-right: 6px;"></i>Choose Ground Level
            </span>

            <hr style="margin: 6px 0; border: none; border-top: 1px solid #ccc; padding-bottom: 10px">

            <form class="form-inline" onsubmit="return false;" style="display: flex; align-items: center; gap: 8px;">
                <button onclick="Map.setFloor(Map.getFloor()+1)" type="submit" class="btn btn-default">-</button>
                <div class="input-group" style="min-width: 130px;">
                    <div class="input-group-addon"><i class="fas fa-building"></i><span style="margin-left: 4px">Floor</span></div>
                    <select id="floorLevel" class="form-control">
                        <option value="0">+7</option>
                        <option value="1">+6</option>
                        <option value="2">+5</option>
                        <option value="3">+4</option>
                        <option value="4">+3</option>
                        <option value="5">+2</option>
                        <option value="6">+1</option>
                        <option value="7">Ground</option>
                        <option value="8">-1</option>
                        <option value="9">-2</option>
                        <option value="10">-3</option>
                        <option value="11">-4</option>
                        <option value="12">-5</option>
                        <option value="13">-6</option>
                        <option value="14">-7</option>
                        <option value="15">-8</option>
                    </select>
                </div>
                <button onclick="Map.setFloor(Map.getFloor()-1)" type="submit" class="btn btn-default">+</button>
            </form>

			<button onclick="window.location.href='/'" class="btn btn-default" style="font-weight: bold; display: block; margin: 10px auto 0 auto;">
				<i class="fas fa-house" style="margin-right: 6px;"></i>Back to Website Home
			</button>
        </div>
    </div>

    <div id="footer">© 2025 Ravenor Map</div>

    <script src="/map/map.js?v=4"></script>

</body>
</html>
