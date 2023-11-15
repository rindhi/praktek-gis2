<!DOCTYPE html>
<html lang="en">
<head>
    <title>Praktek 1</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .fullscreen {
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .image-container {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            cursor: pointer;
        }

        .blok-info {
            z-index: 1000;
            top: 100px;
            right: 15px;
            position: absolute;
            border-radius: 15px;
            width: 200px;
            height: 100px;
            background: white;
            padding-left: 8px;
            padding-right: 8px;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        
    </style>
</head>
<body>
    <img src="google_my_maps.png" class="image-container" style="height: 50px; width: 50px" onclick="deteksilokasi()">
    <div class="blok-info" id="blokhasil"></div>

    <div id="petaku" class="fullscreen"></div>
    <script>
        //mengatur generate map
        var hasilpeta = L.map('petaku').setView([-7.520267989872001, 112.23230114203787], 18);
        //mengatur datanya
        L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}',{maxZoom: 20,subdomains:['mt0','mt1','mt2','mt3']}).addTo(hasilpeta);
        var iconmarker = L.icon ({
            iconUrl : "google_maps_new.png",
            iconSize: [40, 40]
        });
        //membuat marker
        var unwaha = L.marker([-7.520267989872001, 112.23230114203787], {title: "Ini Unwaha", icon: iconmarker, draggable: true}).addTo(hasilpeta);
        unwaha.bindPopup("Kampus Unwaha adalah salah satu kampus swasta yang ada di Jombang");
        
        // percobaan
        // var autoMoveMarker = L.marker([-7.520267989872001, 112.23230114203787], { icon: iconmarker }).addTo(hasilpeta);

        function deteksilokasi(){
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(deteksiok, deteksifail);
            }else{
                alert("Geolocation Tidak Support !");
            }
        }

        function deteksiok(posisi){
            let lintang = posisi.coords.latitude;
            let bujur = posisi.coords.longitude;
            alert("Lokasi Terdeteksi");
            hasilpeta.flyTo([lintang, bujur], 19);
            unwaha.setLatLng([lintang, bujur]);
        }

        // percobaan
        // function deteksiok(posisi){
        //     let lintang = posisi.coords.latitude;
        //     let bujur = posisi.coords.longitude;
        //     alert("Lokasi Terdeteksi");
        //     hasilpeta.flyTo([lintang, bujur], 19);
        //     autoMoveMarker.setLatLng([lintang, bujur]);
        // }

        function deteksifail(error){
            alert("Deteksi Gagal");
        }

        unwaha.on("dragend", deteksikoordinat);
        unwaha.bindPopup(deteksikoordinat);

        function deteksikoordinat(){
            let lintang = unwaha.getLatLng().lat;
            let bujur = unwaha.getLatLng().lng;
            let info = `Koordinat Terdeteksi<br>Lintang: ${lintang}<br>Bujur: ${bujur}`;
            $("#blokhasil").html(info);
            return info;
        }


    </script>
</body>
</html>

