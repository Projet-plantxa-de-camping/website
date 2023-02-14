async function getLatLngLocation(api_key, location){
    const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${location}&key=${api_key}`;

    let res = {lat: 0, lng: 0}

    await fetch(url)
        .then(response => response.json())
        .then(data => {
            const location = data.results[0].geometry.location;
            res.lat = location.lat
            res.lng = location.lng
        })
        .catch(error => console.log("Une erreur s'est produite:", error));

    return res
}

async function googleMap(api_key, location) {
    const latLng = await getLatLngLocation(api_key, location)
    const mapProp = {
        center:new google.maps.LatLng(latLng.lat, latLng.lng),
        zoom:18,
        mapTypeId: "hybrid"
    };
    const map = new google.maps.Map(document.getElementById("map-container-google-3"),mapProp);

    const marker = new google.maps.Marker({
        position: new google.maps.LatLng(latLng.lat, latLng.lng),
        animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(map);
}