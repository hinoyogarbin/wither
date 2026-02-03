class LeafletMap {

     constructor(containerId, center, zoom) {
        this.map = L.map(containerId, {
            maxZoom: 22,
            minZoom: 3,
            zoomControl: true
        }).setView(center, zoom);

        this.initSatelliteLayer();
    }

   initSatelliteLayer() {
    L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        {
            attribution: 'Tiles © Esri — Source: Esri, Maxar, Earthstar Geographics',
            maxNativeZoom: 18,  
            maxZoom: 22,        
            tileSize: 256,
            noWrap: true
        }
    ).addTo(this.map);
}

  
            addMarker(lat, lng, message) {
                    const marker = L.marker([lat, lng]).addTo(this.map);
                    marker.bindPopup(message);
                }
            
                loadMarkersFromJson(url) {
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(marker => {
                                this.addMarker(marker.latitude, marker.longitude, marker.message);
                            });
                        })
                        .catch(error => console.error('Error loading markers:', error));
                }

            }
            const myMap = new LeafletMap('map', [8.360286647958642, 124.86846982625842], 18);
            
            myMap.loadMarkersFromJson('pin.json');
