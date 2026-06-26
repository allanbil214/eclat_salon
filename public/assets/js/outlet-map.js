/* ÉCLAT admin — outlet map picker (Leaflet + Google Maps URL coord extractor).
   Depends on: Leaflet CSS/JS loaded by layout when $leaflet = true.
   Data attrs:
     [data-outlet-map]   – wrapper div
     [data-map-canvas]   – div Leaflet mounts into
     [data-lat-input]    – hidden/number input for lat
     [data-lng-input]    – hidden/number input for lng
     [data-gmaps-input]  – the Google Maps URL field to parse
     [data-extract-btn]  – button that triggers URL parsing
*/
(function () {
  'use strict';

  var wrapper = document.querySelector('[data-outlet-map]');
  if (!wrapper || typeof L === 'undefined') return;

  var canvas      = wrapper.querySelector('[data-map-canvas]');
  var latInput    = wrapper.querySelector('[data-lat-input]');
  var lngInput    = wrapper.querySelector('[data-lng-input]');
  var gmapsInput  = document.querySelector('[data-gmaps-input]');
  var extractBtn  = wrapper.querySelector('[data-extract-btn]');
  var feedback    = wrapper.querySelector('[data-map-feedback]');

  // Default centre: Jakarta (sensible default for an Indonesian salon chain)
  var DEFAULT_LAT = -6.2088;
  var DEFAULT_LNG = 106.8456;
  var DEFAULT_ZOOM = 12;
  var PIN_ZOOM = 16;

  var initLat = parseFloat(latInput.value) || null;
  var initLng = parseFloat(lngInput.value) || null;
  var hasCoords = initLat !== null && initLng !== null;

  // --- Init Leaflet map ---
  var map = L.map(canvas, { zoomControl: true });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
  }).addTo(map);

  var marker = null;

  function placeMarker(lat, lng, zoom) {
    if (marker) {
      marker.setLatLng([lat, lng]);
    } else {
      marker = L.marker([lat, lng], { draggable: true }).addTo(map);
      marker.on('dragend', function () {
        var pos = marker.getLatLng();
        setCoords(pos.lat, pos.lng);
      });
    }
    map.setView([lat, lng], zoom || PIN_ZOOM);
  }

  function setCoords(lat, lng) {
    var rLat = Math.round(lat * 1e7) / 1e7;
    var rLng = Math.round(lng * 1e7) / 1e7;
    latInput.value = rLat;
    lngInput.value = rLng;
  }

  // Seed map with existing coords or default view
  if (hasCoords) {
    placeMarker(initLat, initLng, PIN_ZOOM);
  } else {
    map.setView([DEFAULT_LAT, DEFAULT_LNG], DEFAULT_ZOOM);
  }

  // Click on map → drop/move pin
  map.on('click', function (e) {
    placeMarker(e.latlng.lat, e.latlng.lng);
    setCoords(e.latlng.lat, e.latlng.lng);
    showFeedback('Pin placed. Drag to fine-tune.', false);
  });

  // --- Extract coords from Google Maps URL ---
  function extractFromUrl(url) {
    if (!url) return null;

    // Pattern 1: @lat,lng  (most share URLs and /maps/place/ URLs)
    var m = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    // Pattern 2: ?q=lat,lng  (simple /maps?q= URLs)
    m = url.match(/[?&]q=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    // Pattern 3: ll=lat,lng
    m = url.match(/[?&]ll=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    // Pattern 4: /place/.../@lat,lng  (already covered by #1 but kept for clarity)
    return null;
  }

  function showFeedback(msg, isErr) {
    if (!feedback) return;
    feedback.textContent = msg;
    feedback.className = 'adm-map-feedback' + (isErr ? ' err' : ' ok');
  }

  if (extractBtn && gmapsInput) {
    extractBtn.addEventListener('click', function () {
      var url = gmapsInput.value.trim();
      var coords = extractFromUrl(url);
      if (coords) {
        placeMarker(coords.lat, coords.lng, PIN_ZOOM);
        setCoords(coords.lat, coords.lng);
        showFeedback('Coordinates extracted. Drag the pin to fine-tune.', false);
      } else {
        showFeedback('Could not extract coordinates from this URL. Try clicking the map manually.', true);
      }
    });

    // Also try auto-extract when the gmaps URL field loses focus
    gmapsInput.addEventListener('blur', function () {
      if (latInput.value && lngInput.value) return; // already set
      var coords = extractFromUrl(gmapsInput.value.trim());
      if (coords) {
        placeMarker(coords.lat, coords.lng, PIN_ZOOM);
        setCoords(coords.lat, coords.lng);
        showFeedback('Coordinates auto-extracted from Maps URL.', false);
      }
    });
  }

})();
