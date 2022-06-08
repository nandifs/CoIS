var objViewLocation;

function getPosition(objView) {
    objViewLocation = objView;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
                getKoordinat(position, myCallback);
            }, function (e) {
                myCallback("Browser Tidak Mendukung Geolocation.")
            }, {
                enableHighAccuracy: true
            });
    } else { 
        myCallback("Browser Tidak Mendukung Geolocation.")
    }
}

function getKoordinat(position){
    var ilat = position.coords.latitude.toFixed(6);
    var ilong = position.coords.longitude.toFixed(6);
    var location = ilat + "," + ilong;
    
    myCallback(location);
}

function myCallback(data){
    if (objViewLocation==null){
        return data;
    }else{
        if(data!="Browser Tidak Mendukung Geolocation."){
            objViewLocation.innerHTML = "Status GPS: Online (" + data +")";
        }else{
            objViewLocation.innerHTML = "Status GPS: OFF (" + data + ")";
        }
    }    
}

//get koordinat only
function getGeoLocation(objView) {
    objViewLocation = objView;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
                getKoordinat1(position, myCallback1);
            }, function (e) {
                myCallback1("Browser Tidak Mendukung Geolocation.")
            }, {
                enableHighAccuracy: true
            });
    } else { 
        myCallback1("Browser Tidak Mendukung Geolocation.")
    }
}

function getKoordinat1(position){
    var ilat = position.coords.latitude.toFixed(6);
    var ilong = position.coords.longitude.toFixed(6);
    var location = ilat + "," + ilong;
    
    myCallback1(location);
}

function myCallback1(data){    
    if (objViewLocation==null){
        return null;
    }else{
        
        if (objViewLocation.nodeName=="LABEL"){
            if(data!="Browser Tidak Mendukung Geolocation."){
                objViewLocation.innerHTML = data;
            }else{
                objViewLocation.innerHTML = "Browser Tidak Mendukung Geolocation";
            }
        }else if(objViewLocation.nodeName=="INPUT"){            
            if(data!="Browser Tidak Mendukung Geolocation."){
                objViewLocation.value  = data;
            }else{
                objViewLocation.value  = "Browser Tidak Mendukung Geolocation";
            }
        }        
    }    
}
