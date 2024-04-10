<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Display</title>
    <!-- Include Leaflet CSS for the map display -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
<form id="locationForm">
    <input type="text" id="latitude" placeholder="Latitude" required>
    <input type="text" id="longitude" placeholder="Longitude" required disabled>
    <button type="submit" style="display:none;">Get Location</button>
</form>

<div id="address"></div>
<div id="map" style="height: 300px; width: 100%;"></div>

<!-- Include Leaflet JavaScript for the map display -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Your JavaScript code will be here -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const addressDiv = document.getElementById('address');
        let map = null;
        let updateTimeout = null;

        // Function to update map and address
        function updateMapAndAddress(latitude, longitude) {
            // JavaScript call to your API backend
            fetch(`/api/get-location?lat=${latitude}&lon=${longitude}`)
                .then(response => response.json())
                .then(data => {
                    // Display address
                    addressDiv.textContent = data.address;

                    // Initialize or update map
                    if (!map) {
                        map = L.map('map').setView([data.lat, data.lon], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);
                    } else {
                        map.setView([data.lat, data.lon], 13);
                    }

                    L.marker([data.lat, data.lon]).addTo(map)
                        .bindPopup(data.address)
                        .openPopup();
                });
        }

        // Enable longitude field when latitude is filled
        latitudeInput.addEventListener('input', function () {
            longitudeInput.disabled = latitudeInput.value.trim() === '';
        });

        // Update map and address on longitude input
        longitudeInput.addEventListener('input', function () {
            const latitude = latitudeInput.value.trim();
            const longitude = longitudeInput.value.trim();

            // Clear previous timeout to ensure this function runs after user has stopped typing
            clearTimeout(updateTimeout);

            // Set a timeout to update the map after the user has stopped typing for 1 second
            updateTimeout = setTimeout(() => {
                if (latitude !== '' && longitude !== '') {
                    updateMapAndAddress(latitude, longitude);
                }
            }, 1000); // Adjust timeout as needed
        });
    });


</script>


</body>
</html>
