class LeafletMap {

    constructor(containerId, center, zoom) {
        this.map = L.map(containerId).setView(center, zoom);
        this.initSatelliteLayer();
    }

    initSatelliteLayer() {
        L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            {
                maxZoom: 19,
                attribution:
                    'Tiles © Esri — Source: Esri, Maxar, Earthstar Geographics'
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

const myMap = new LeafletMap('map', [8.36030503390942, 124.86816627657458], 18);
myMap.loadMarkersFromJson('pin.json');