@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/cadets/location.css'])


<div class="location-card">

    <div class="map-title">
        📍 Cadet Live Location
    </div>

    <div class="info-box">
        <strong>Name:</strong> {{ $cadet->full_name }} <br>
        <strong>Course:</strong> {{ $cadet->course }} <br>
        <strong>Last Seen:</strong>
        {{ $cadet->last_seen ?? 'No location yet' }}

@php
    $status = strtolower($cadet->online_status);
@endphp

@if($status === 'active')
    <span class="status active">🟢 Active now</span>

@elseif($status === 'inactive')
    <span class="status inactive">🟡 Inactive (5 min)</span>

@elseif($status === 'away')
    <span class="status away">🔵 Away (30 min)</span>

@else
    <span class="status offline">🔴 Offline</span>
@endif

    </div>

    <div id="map"></div>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div id="map"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const lat = Number(@json($cadet->latitude));
    const lng = Number(@json($cadet->longitude));

    if (isNaN(lat) || isNaN(lng)) {
        document.getElementById("map").innerHTML =
            "<p style='color:white;'>No GPS location yet.</p>";
        return;
    }

    const map = L.map('map').setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng])
        .addTo(map)
        .bindPopup(@json($cadet->full_name))
        .openPopup();
});
</script>

<script>
setInterval(() => {
    fetch(window.location.href)
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // update only status + last seen
            document.querySelector(".info-box").innerHTML =
                doc.querySelector(".info-box").innerHTML;
        });
}, 5000);
</script>

@endsection