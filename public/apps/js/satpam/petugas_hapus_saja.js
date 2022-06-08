var x = document.getElementById("lbl-status");

function setStatus() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
                sendStatus(position);
            }, function (e) {
                alert('Browser Anda Tidak Mendukung Geolocation.');
            }, {
                enableHighAccuracy: true
            });
    } else { 
        x.innerHTML = "Browser Anda Tidak Mendukung Geolocation.";
    }
}

function sendStatus(position){
    var ilat = position.coords.latitude.toFixed(6);
    var ilong = position.coords.longitude.toFixed(6);
    var location = ilat + "," + ilong;
    var postdata = {koordinat:location};

    x.innerHTML = "Status GPS: Offline";

    $.postJSON("home/update_geolocation", postdata, function (data, status) {
        // console.log(status);
		if (status=='success'){
            x.innerHTML = "Status GPS: Online";
        }
    });    
}

$(function () {  
    setStatus();
});