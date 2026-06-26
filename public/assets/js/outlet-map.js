/* ÉCLAT admin — outlet map picker (Leaflet + Google Maps URL coord extractor).
   Depends on: Leaflet CSS/JS loaded by layout when $leaflet = true.
   Data attrs:
     [data-outlet-map]   – wrapper div
     [data-map-canvas]   – div Leaflet mounts into
     [data-lat-input]    – number input for lat
     [data-lng-input]    – number input for lng
     [data-gmaps-input]  – the Google Maps URL field to parse
     [data-extract-btn]  – button that triggers URL parsing
     [data-map-feedback] – span that shows status messages
*/
(function () {
  'use strict';

  var wrapper = document.querySelector('[data-outlet-map]');
  if (!wrapper || typeof L === 'undefined') return;

  var canvas     = wrapper.querySelector('[data-map-canvas]');
  var latInput   = wrapper.querySelector('[data-lat-input]');
  var lngInput   = wrapper.querySelector('[data-lng-input]');
  var gmapsInput = document.querySelector('[data-gmaps-input]');
  var extractBtn = wrapper.querySelector('[data-extract-btn]');
  var feedback   = wrapper.querySelector('[data-map-feedback]');

  // Default centre: Jakarta
  var DEFAULT_LAT  = -6.2088;
  var DEFAULT_LNG  = 106.8456;
  var DEFAULT_ZOOM = 12;
  var PIN_ZOOM     = 16;

  var initLat   = parseFloat(latInput.value) || null;
  var initLng   = parseFloat(lngInput.value) || null;
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

  if (hasCoords) {
    placeMarker(initLat, initLng, PIN_ZOOM);
  } else {
    map.setView([DEFAULT_LAT, DEFAULT_LNG], DEFAULT_ZOOM);
  }

  map.on('click', function (e) {
    placeMarker(e.latlng.lat, e.latlng.lng);
    setCoords(e.latlng.lat, e.latlng.lng);
    showFeedback('Pin placed. Drag to fine-tune.', false);
  });

  // --- URL patterns ---
  // Returns {lat, lng} or null. Tries every known Google Maps URL shape.
  function extractFromUrl(url) {
    if (!url) return null;

    var m;

    // 1. @lat,lng — the most common share/place URL format
    //    e.g. /maps/place/Name/@-6.2088,106.8456,17z
    m = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    // 2. ?q=lat,lng or &q=lat,lng — simple query URLs
    //    e.g. /maps?q=-6.2088,106.8456
    m = url.match(/[?&]q=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    // 3. ll=lat,lng
    //    e.g. /maps?ll=-6.2088,106.8456&z=15
    m = url.match(/[?&]ll=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    // 4. Embed / iframe pb= blob — encodes !3d<lat> and !2d<lng>
    //    e.g. /maps/embed?pb=!1m18!...!2d106.8456!3d-6.2088!...
    //    Note: !2d = longitude, !3d = latitude (Google's own ordering)
    var m3d = url.match(/!3d(-?\d+\.?\d*)/);
    var m2d = url.match(/!2d(-?\d+\.?\d*)/);
    if (m3d && m2d) return { lat: parseFloat(m3d[1]), lng: parseFloat(m2d[1]) };

    // 5. /dir/destination as bare lat,lng path segment
    //    e.g. /maps/dir//-6.2088,106.8456/
    m = url.match(/\/(-?\d{1,3}\.\d+),(-?\d{1,3}\.\d+)/);
    if (m) return { lat: parseFloat(m[1]), lng: parseFloat(m[2]) };

    return null;
  }

  // Is this a short URL that needs server-side redirect resolution?
  function isShortUrl(url) {
    var host = '';
    try { host = new URL(url).hostname; } catch (e) { return false; }
    return host === 'maps.app.goo.gl' || host === 'goo.gl';
  }

  function showFeedback(msg, isErr) {
    if (!feedback) return;
    feedback.textContent = msg;
    feedback.className = 'adm-map-feedback' + (isErr ? ' err' : ' ok');
  }

  // Core: try to get coords from a URL, resolving short URLs via the PHP
  // proxy endpoint first if needed. Calls onSuccess({lat,lng}) or onFail().
  function resolveAndExtract(url, onSuccess, onFail) {
    // Try direct extraction first — works for all full URLs.
    var coords = extractFromUrl(url);
    if (coords) { onSuccess(coords); return; }

    // Short URL — ask the server to follow the redirect chain.
    if (isShortUrl(url)) {
      showFeedback('Resolving short URL…', false);
      var endpoint = (window.ADMIN_BASE || '/admin') + '/util/resolve-url?url=' + encodeURIComponent(url);
      fetch(endpoint)
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.error) { onFail(data.error); return; }
          var coords2 = extractFromUrl(data.resolved || '');
          if (coords2) { onSuccess(coords2); }
          else { onFail('URL resolved but no coordinates found. Try clicking the map.'); }
        })
        .catch(function () { onFail('Network error resolving URL.'); });
      return;
    }

    // Full URL but no pattern matched.
    onFail('Could not extract coordinates from this URL. Try clicking the map manually.');
  }

  if (extractBtn && gmapsInput) {
    extractBtn.addEventListener('click', function () {
      var url = gmapsInput.value.trim();
      if (!url) { showFeedback('Paste a Google Maps URL first.', true); return; }

      resolveAndExtract(
        url,
        function (coords) {
          placeMarker(coords.lat, coords.lng, PIN_ZOOM);
          setCoords(coords.lat, coords.lng);
          showFeedback('Coordinates extracted. Drag the pin to fine-tune.', false);
        },
        function (msg) { showFeedback(msg, true); }
      );
    });

    // Auto-extract on blur if coords not yet set.
    gmapsInput.addEventListener('blur', function () {
      if (latInput.value && lngInput.value) return;
      var url = gmapsInput.value.trim();
      if (!url) return;

      resolveAndExtract(
        url,
        function (coords) {
          placeMarker(coords.lat, coords.lng, PIN_ZOOM);
          setCoords(coords.lat, coords.lng);
          showFeedback('Coordinates auto-extracted from Maps URL.', false);
        },
        function () { /* silent on blur — user hasn't clicked Extract yet */ }
      );
    });
  }

})();
