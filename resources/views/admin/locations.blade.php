@extends('layouts.admin')

@section('content')

@vite([
    'resources/css/admin/locations/locations.css'
])

{{-- =========================================================
     MAPLIBRE GL JS
========================================================= --}}

<link
    rel="stylesheet"
    href="https://unpkg.com/maplibre-gl@5.6.1/dist/maplibre-gl.css"
/>

<script
    src="https://unpkg.com/maplibre-gl@5.6.1/dist/maplibre-gl.js"
></script>


<div class="location-map-page">

    {{-- =====================================================
         MAIN CARD
    ====================================================== --}}

    <div class="location-map-card">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="location-map-header">

            <div class="location-map-title-wrapper">

                <div class="location-map-icon">

                    <i class="fas fa-location-dot"></i>

                </div>

                <div class="location-map-heading">

                    <h1 class="location-map-title">
                        Deployed Cadets Location Map
                    </h1>

                    <p class="location-map-subtitle">
                        Real-time location monitoring for deployed cadets.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 REALTIME STATUS
            ================================================== --}}

            <div
                id="realtimeStatus"
                class="map-live-status"
            >

                <span
                    id="realtimeStatusDot"
                    class="map-live-dot"
                ></span>

                <span id="realtimeStatusText">
                    Connecting...
                </span>

            </div>

        </div>


        {{-- =================================================
             MAP BODY
        ================================================== --}}

        <div class="location-map-body">

            <div class="map-wrapper">

                <div id="map"></div>


                {{-- =================================================
                     MAP TOP CONTROLS
                ================================================== --}}

                <div class="map-floating-controls">

                    <button
                        type="button"
                        id="fitAllCadetsBtn"
                        class="map-floating-btn"
                        title="Show all deployed cadets"
                    >

                        <i class="fas fa-expand"></i>

                        <span>
                            Show All
                        </span>

                    </button>

                </div>


                {{-- =================================================
                     MAP LEGEND
                ================================================== --}}

                <div class="map-legend">

                    <div class="map-legend-title">
                        Cadet Status
                    </div>

                    <div class="map-legend-item">

                        <span class="legend-dot online"></span>

                        <span>
                            Online
                        </span>

                    </div>

                    <div class="map-legend-item">

                        <span class="legend-dot offline"></span>

                        <span>
                            Offline
                        </span>

                    </div>

                </div>


                {{-- =================================================
                     LOADING
                ================================================== --}}

                <div
                    id="mapLoading"
                    class="map-loading"
                >

                    <div class="map-loading-content">

                        <div class="map-loading-spinner"></div>

                        <div class="map-loading-text">
                            Loading deployed cadets...
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

                <div
                    id="mapEmptyState"
                    class="map-empty-state"
                >

                    <div class="map-empty-content">

                        <div class="map-empty-icon">

                            <i class="fas fa-location-crosshairs"></i>

                        </div>

                        <h3>
                            No Cadet Locations Available
                        </h3>

                        <p>
                            There are currently no deployed cadets
                            with available location coordinates.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     ERROR STATE
                ================================================== --}}

                <div
                    id="mapError"
                    class="map-error"
                >

                    <div class="map-error-icon">

                        <i class="fas fa-triangle-exclamation"></i>

                    </div>

                    <h3>
                        Unable to Load Locations
                    </h3>

                    <p id="mapErrorMessage">
                        Unable to retrieve cadet location data.
                    </p>

                    <button
                        type="button"
                        class="map-retry-btn"
                        onclick="loadInitialCadets()"
                    >

                        <i class="fas fa-rotate-right"></i>

                        Try Again

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     POPUP OVERLAY
========================================================= --}}

<div
    id="cadetPopupOverlay"
    class="cadet-popup-overlay"
    onclick="closeCadetPopup()"
></div>


{{-- =========================================================
     CADET POPUP
========================================================= --}}

<div
    id="cadetPopup"
    class="cadet-popup"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cadetPopupTitle"
>

    <div class="cadet-popup-header">

        <div
            id="cadetPopupTitle"
            class="cadet-popup-header-title"
        >

            <i class="fas fa-user-location"></i>

            <span>
                Cadet Location Details
            </span>

        </div>


        <button
            type="button"
            class="close-btn"
            onclick="closeCadetPopup()"
            aria-label="Close"
        >

            <i class="fas fa-xmark"></i>

        </button>

    </div>


    <div id="cadetInfo"></div>

</div>


<script>

(function () {

    'use strict';


    /* =========================================================
       PREVENT DUPLICATE INITIALIZATION
    ========================================================= */

    if (
        window.__adminCadetLocationMapInitialized
    ) {

        console.warn(
            '[Locations] Map already initialized.'
        );

        return;

    }


    window.__adminCadetLocationMapInitialized = true;


    /* =========================================================
       GLOBAL REFERENCES
    ========================================================= */

    let map = null;

    let previousEchoChannel = null;

    let previousEchoConnectionHandlers = [];

    let activePopupCadetId = null;


    /*
     * MapLibre marker registry.
     *
     * Structure:
     *
     * Map(
     *     cadet_id => {
     *         marker,
     *         cadet
     *     }
     * )
     */

    const markerRegistry = new Map();


    /* =========================================================
       DOM READY
    ========================================================= */

    document.addEventListener(
        'DOMContentLoaded',
        function () {


            /* =====================================================
               DOM ELEMENTS
            ====================================================== */

            const mapLoading =
                document.getElementById(
                    'mapLoading'
                );

            const mapEmptyState =
                document.getElementById(
                    'mapEmptyState'
                );

            const mapError =
                document.getElementById(
                    'mapError'
                );

            const mapErrorMessage =
                document.getElementById(
                    'mapErrorMessage'
                );

            const cadetPopup =
                document.getElementById(
                    'cadetPopup'
                );

            const cadetPopupOverlay =
                document.getElementById(
                    'cadetPopupOverlay'
                );

            const cadetInfo =
                document.getElementById(
                    'cadetInfo'
                );

            const realtimeStatusText =
                document.getElementById(
                    'realtimeStatusText'
                );

            const realtimeStatusDot =
                document.getElementById(
                    'realtimeStatusDot'
                );

            const fitAllCadetsBtn =
                document.getElementById(
                    'fitAllCadetsBtn'
                );


            /* =====================================================
               HTML ESCAPE
            ====================================================== */

            function escapeHtml(value)
            {

                if (
                    value === null ||
                    value === undefined
                ) {

                    return '';

                }


                return String(value)

                    .replace(
                        /&/g,
                        '&amp;'
                    )

                    .replace(
                        /</g,
                        '&lt;'
                    )

                    .replace(
                        />/g,
                        '&gt;'
                    )

                    .replace(
                        /"/g,
                        '&quot;'
                    )

                    .replace(
                        /'/g,
                        '&#039;'
                    );

            }


            /* =====================================================
               COORDINATE VALIDATION
            ====================================================== */

            function validCoordinates(cadet)
            {

                if (!cadet) {

                    return false;

                }


                const latitude =
                    parseFloat(
                        cadet.latitude
                    );

                const longitude =
                    parseFloat(
                        cadet.longitude
                    );


                return (

                    Number.isFinite(latitude)

                    &&

                    Number.isFinite(longitude)

                    &&

                    latitude >= -90

                    &&

                    latitude <= 90

                    &&

                    longitude >= -180

                    &&

                    longitude <= 180

                );

            }


            /* =====================================================
               ONLINE STATUS
            ====================================================== */

            function isOnline(cadet)
            {

                if (!cadet) {

                    return false;

                }


                if (

                    cadet.is_online === true ||

                    cadet.is_online === 1 ||

                    cadet.is_online === '1'

                ) {

                    return true;

                }


                const status =
                    String(
                        cadet.online_status ??
                        cadet.status ??
                        cadet.user_status ??
                        ''
                    )
                    .trim()
                    .toLowerCase();


                return [

                    'online',
                    'active',
                    'connected',
                    'available',
                    'logged_in',
                    'logged in'

                ].includes(status);

            }


            /* =====================================================
               PHOTO URL
            ====================================================== */

            function photoUrl(photo)
            {

                if (!photo) {

                    return null;

                }


                const value =
                    String(photo)
                        .replace(
                            /^\/+/,
                            ''
                        );


                if (

                    value.startsWith(
                        'http://'
                    )

                    ||

                    value.startsWith(
                        'https://'
                    )

                ) {

                    return value;

                }


                return `/storage/${value}`;

            }


            /* =====================================================
               REALTIME STATUS
            ====================================================== */

            function setRealtimeStatus(
                connected
            )
            {

                if (

                    !realtimeStatusText ||

                    !realtimeStatusDot

                ) {

                    return;

                }


                if (connected) {

                    realtimeStatusText.textContent =
                        'Live Connected';


                    realtimeStatusDot.style.background =
                        '#22c55e';


                    realtimeStatusDot.style.boxShadow =
                        '0 0 0 4px rgba(34,197,94,.10), 0 0 14px rgba(34,197,94,.55)';

                }

                else {

                    realtimeStatusText.textContent =
                        'Connecting...';


                    realtimeStatusDot.style.background =
                        '#f59e0b';


                    realtimeStatusDot.style.boxShadow =
                        '0 0 0 4px rgba(245,158,11,.10), 0 0 14px rgba(245,158,11,.45)';

                }

            }


            /* =====================================================
               NORMALIZE CADET PAYLOAD
            ====================================================== */

            function normalizeCadetPayload(
                payload
            )
            {

                if (!payload) {

                    return null;

                }


                let cadet =
                    payload?.cadet ??
                    payload;


                if (!cadet) {

                    return null;

                }


                /*
                 * Backend may send:
                 *
                 * id
                 * cadet_id
                 */

                if (

                    !cadet.cadet_id &&

                    cadet.id

                ) {

                    cadet = {

                        ...cadet,

                        cadet_id:
                            cadet.id

                    };

                }


                if (

                    !cadet.cadet_id &&

                    !cadet.id &&

                    cadet.user_id

                ) {

                    console.warn(
                        '[Reverb] Payload has user_id but no cadet ID.',
                        cadet
                    );

                }


                if (

                    cadet.cadet_id !== undefined &&

                    cadet.cadet_id !== null

                ) {

                    cadet.cadet_id =
                        String(
                            cadet.cadet_id
                        );

                }


                return cadet;

            }


            /* =====================================================
               CREATE MARKER ELEMENT
            ====================================================== */

            function createMarkerElement(
                cadet
            )
            {

                const online =
                    isOnline(cadet);


                const element =
                    document.createElement(
                        'div'
                    );


                element.className =
                    `cadet-map-marker ${
                        online
                            ? 'online'
                            : 'offline'
                    }`;


                element.innerHTML = `

                    <div class="cadet-marker-ring">

                        <i class="fas fa-user"></i>

                    </div>

                `;


                element.setAttribute(
                    'aria-label',
                    cadet.full_name ||
                    'Cadet'
                );


                element.title =
                    cadet.full_name ||
                    'Cadet';


                return element;

            }


            /* =====================================================
               UPDATE MARKER ELEMENT
            ====================================================== */

            function updateMarkerElement(
                element,
                cadet
            )
            {

                if (!element) {

                    return;

                }


                const online =
                    isOnline(cadet);


                element.classList.toggle(
                    'online',
                    online
                );


                element.classList.toggle(
                    'offline',
                    !online
                );


                element.setAttribute(
                    'aria-label',
                    cadet.full_name ||
                    'Cadet'
                );


                element.title =
                    cadet.full_name ||
                    'Cadet';

            }


            /* =====================================================
               CREATE MARKER
            ====================================================== */

            function createCadetMarker(
                cadet
            )
            {

                if (
                    !validCoordinates(cadet)
                ) {

                    return null;

                }


                const element =
                    createMarkerElement(
                        cadet
                    );


                const latitude =
                    parseFloat(
                        cadet.latitude
                    );

                const longitude =
                    parseFloat(
                        cadet.longitude
                    );


                const marker =
                    new maplibregl.Marker({

                        element:
                            element,

                        anchor:
                            'bottom'

                    })

                    .setLngLat([

                        longitude,
                        latitude

                    ])

                    .addTo(map);


                /*
                 * Click marker.
                 */

                element.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        showCadetPopup(
                            cadet
                        );

                    }
                );


                /*
                 * Hover tooltip.
                 */

                element.addEventListener(
                    'mouseenter',
                    function () {

                        element.classList.add(
                            'hovered'
                        );

                    }
                );


                element.addEventListener(
                    'mouseleave',
                    function () {

                        element.classList.remove(
                            'hovered'
                        );

                    }
                );


                return marker;

            }


            /* =====================================================
               UPSERT MARKER
            ====================================================== */

            function upsertCadetMarker(
                incomingCadet,
                shouldMoveMap = false
            )
            {

                const cadet =
                    normalizeCadetPayload(
                        incomingCadet
                    );


                if (

                    !cadet ||

                    !cadet.cadet_id

                ) {

                    console.warn(
                        '[Map] Invalid cadet payload:',
                        incomingCadet
                    );

                    return;

                }


                if (
                    !validCoordinates(cadet)
                ) {

                    console.warn(
                        '[Map] Invalid coordinates:',
                        cadet
                    );

                    return;

                }


                const id =
                    String(
                        cadet.cadet_id
                    );


                const latitude =
                    parseFloat(
                        cadet.latitude
                    );

                const longitude =
                    parseFloat(
                        cadet.longitude
                    );


                const existing =
                    markerRegistry.get(id);


                /* =================================================
                   EXISTING MARKER
                ================================================== */

                if (existing) {

                    existing.marker.setLngLat([

                        longitude,
                        latitude

                    ]);


                    const element =
                        existing.marker.getElement();


                    updateMarkerElement(
                        element,
                        cadet
                    );


                    existing.cadet =
                        cadet;


                    /*
                     * Refresh open popup.
                     */

                    if (

                        activePopupCadetId &&

                        String(
                            activePopupCadetId
                        ) === id

                    ) {

                        showCadetPopup(
                            cadet
                        );

                    }


                    if (shouldMoveMap) {

                        map.easeTo({

                            center: [
                                longitude,
                                latitude
                            ],

                            duration:
                                700

                        });

                    }


                    hideEmptyState();

                    return;

                }


                /* =================================================
                   NEW MARKER
                ================================================== */

                const marker =
                    createCadetMarker(
                        cadet
                    );


                if (!marker) {

                    return;

                }


                markerRegistry.set(

                    id,

                    {

                        marker:
                            marker,

                        cadet:
                            cadet

                    }

                );


                hideEmptyState();


                if (shouldMoveMap) {

                    map.easeTo({

                        center: [
                            longitude,
                            latitude
                        ],

                        zoom: 15,

                        duration: 700

                    });

                }

            }


            /* =====================================================
               REMOVE MARKER
            ====================================================== */

            function removeCadetMarker(
                cadetId
            )
            {

                const id =
                    String(
                        cadetId
                    );


                const existing =
                    markerRegistry.get(id);


                if (!existing) {

                    return;

                }


                existing.marker.remove();


                markerRegistry.delete(id);


                if (
                    activePopupCadetId === id
                ) {

                    closeCadetPopup();

                }


                if (
                    markerRegistry.size === 0
                ) {

                    showEmptyState();

                }

            }


            /* =====================================================
               FIT ALL CADETS
            ====================================================== */

            function fitAllCadets()
            {

                if (
                    !map ||
                    markerRegistry.size === 0
                ) {

                    return;

                }


                const bounds =
                    new maplibregl.LngLatBounds();


                markerRegistry.forEach(
                    function (item) {

                        const lngLat =
                            item.marker.getLngLat();


                        bounds.extend([
                            lngLat.lng,
                            lngLat.lat
                        ]);

                    }
                );


                if (
                    !bounds.isEmpty()
                ) {

                    map.fitBounds(
                        bounds,
                        {

                            padding:
                                {
                                    top: 90,
                                    bottom: 90,
                                    left: 90,
                                    right: 90
                                },

                            maxZoom:
                                16,

                            duration:
                                800

                        }
                    );

                }

            }


            /* =====================================================
               INITIAL DATABASE LOAD
            ====================================================== */

            window.loadInitialCadets =
                async function ()
                {

                    mapLoading.classList.remove(
                        'hidden'
                    );


                    mapError.classList.remove(
                        'show'
                    );


                    try {

                        const response =
                            await fetch(

                                '{{ route("admin.admin.locations.data") }}',

                                {

                                    method:
                                        'GET',

                                    headers:
                                        {

                                            'Accept':
                                                'application/json',

                                            'X-Requested-With':
                                                'XMLHttpRequest'

                                        },

                                    cache:
                                        'no-store'

                                }

                            );


                        if (!response.ok) {

                            throw new Error(

                                `Server returned ${response.status}`

                            );

                        }


                        const cadets =
                            await response.json();


                        if (
                            !Array.isArray(
                                cadets
                            )
                        ) {

                            throw new Error(
                                'Invalid cadet location data.'
                            );

                        }


                        /*
                         * Remove existing markers.
                         */

                        markerRegistry.forEach(
                            function (item) {

                                item.marker.remove();

                            }
                        );


                        markerRegistry.clear();


                        let validCount = 0;


                        cadets.forEach(
                            function (cadet) {

                                const normalized =
                                    normalizeCadetPayload(
                                        cadet
                                    );


                                if (

                                    normalized &&

                                    validCoordinates(
                                        normalized
                                    )

                                ) {

                                    upsertCadetMarker(
                                        normalized,
                                        false
                                    );


                                    validCount++;

                                }

                            }
                        );


                        if (
                            validCount === 0
                        ) {

                            showEmptyState();

                        }

                        else {

                            hideEmptyState();


                            /*
                             * Wait for MapLibre to finish rendering
                             * before fitting bounds.
                             */

                            setTimeout(
                                function () {

                                    fitAllCadets();

                                },
                                150
                            );

                        }

                    }

                    catch (error) {

                        console.error(
                            '[Map] Initial location load failed:',
                            error
                        );


                        mapErrorMessage.textContent =
                            'Unable to retrieve the initial cadet locations. Please try again.';


                        mapError.classList.add(
                            'show'
                        );

                    }

                    finally {

                        mapLoading.classList.add(
                            'hidden'
                        );

                    }

                };


            /* =====================================================
               EMPTY STATE
            ====================================================== */

            function showEmptyState()
            {

                mapEmptyState.classList.add(
                    'show'
                );

            }


            function hideEmptyState()
            {

                mapEmptyState.classList.remove(
                    'show'
                );

            }


            /* =====================================================
               CADET POPUP
            ====================================================== */

            function showCadetPopup(cadet)
            {

                if (!cadet) {

                    return;

                }


                const normalizedCadet =
                    normalizeCadetPayload(
                        cadet
                    );


                if (
                    !normalizedCadet
                ) {

                    return;

                }


                cadet =
                    normalizedCadet;

                    const deployment = cadet.deployment ?? {};

                    const deploymentType =
                        cadet.deployment_type ??
                        deployment.deployment_type ??
                        deployment.type ??
                        '-';

                    const deploymentStatus =
                        cadet.deployment_status ??
                        deployment.deployment_status ??
                        deployment.status ??
                        cadet.status ??
                        '-';

                activePopupCadetId =
                    String(
                        cadet.cadet_id
                    );


                cadetInfo.dataset.cadetId =
                    cadet.cadet_id;


                const photo =
                    photoUrl(
                        cadet.photo
                    );


                const online =
                    isOnline(cadet);


                let photoHtml;


                if (photo) {

                    photoHtml = `

                        <img
                            src="${escapeHtml(photo)}"
                            class="cadet-photo"
                            alt="${escapeHtml(
                                cadet.full_name ||
                                'Cadet'
                            )}"

                            onerror="
                                this.style.display='none';
                                this.nextElementSibling.style.display='flex';
                            "
                        >

                        <div
                            class="cadet-photo-placeholder"
                            style="display:none;"
                        >

                            <i class="fas fa-user"></i>

                        </div>

                    `;

                }

                else {

                    photoHtml = `

                        <div
                            class="cadet-photo-placeholder"
                        >

                            <i class="fas fa-user"></i>

                        </div>

                    `;

                }


                const hasLocation =
                    validCoordinates(
                        cadet
                    );


                let locationButton;


                if (hasLocation) {

                    locationButton = `

                        <a
                            href="https://www.google.com/maps?q=${encodeURIComponent(
                                cadet.latitude
                            )},${encodeURIComponent(
                                cadet.longitude
                            )}"

                            target="_blank"

                            rel="noopener noreferrer"

                            class="
                                map-action-btn
                                map-action-btn-primary
                            "
                        >

                            <i class="fas fa-location-dot"></i>

                            Open Location in Google Maps

                        </a>

                    `;

                }

                else {

                    locationButton = `

                        <button
                            type="button"

                            class="
                                map-action-btn
                                map-action-btn-disabled
                            "

                            disabled
                        >

                            <i class="fas fa-location-slash"></i>

                            Location Unavailable

                        </button>

                    `;

                }


                cadetInfo.innerHTML = `

                    {{-- PROFILE --}}

                    <div class="cadet-profile">

                        <div class="cadet-photo-wrapper">

                            ${photoHtml}

                            <span
                                class="cadet-online-indicator
                                    ${online ? 'online' : 'offline'}"
                            ></span>

                        </div>


                        <h3>

                            ${escapeHtml(
                                cadet.full_name ||
                                'Unknown Cadet'
                            )}

                        </h3>


                        <div class="cadet-course">

                            ${escapeHtml(
                                cadet.course ||
                                'Course unavailable'
                            )}

                        </div>


                        <span
                            class="
                                cadet-status
                                ${online ? 'online' : 'offline'}
                            "
                        >

                            <span
                                class="status-small-dot"
                            ></span>

                            ${escapeHtml(
                                online
                                    ? (
                                        cadet.online_status ||
                                        'Online'
                                    )
                                    : (
                                        cadet.online_status ||
                                        'Offline'
                                    )
                            )}

                        </span>

                    </div>


                    <div class="cadet-info-divider"></div>


                    {{-- INFORMATION --}}

                    <div class="cadet-info-grid">

                        <div class="cadet-info-item">

                            <span class="cadet-info-label">
                                TRB Number
                            </span>

                            <span class="cadet-info-value">

                                ${escapeHtml(
                                    cadet.trb_control_number ||
                                    '-'
                                )}

                            </span>

                        </div>


                        <div class="cadet-info-item">

                            <span class="cadet-info-label">
                                Course
                            </span>

                            <span class="cadet-info-value">

                                ${escapeHtml(
                                    cadet.course ||
                                    '-'
                                )}

                            </span>

                        </div>


                        <div class="cadet-info-item">
                            <span class="cadet-info-label">
                                Deployment
                            </span>
                            <span class="cadet-info-value">
                                ${escapeHtml(deploymentType)}
                            </span>
                        </div>


                        <div class="cadet-info-item">
                            <span class="cadet-info-label">
                                Status
                            </span>
                            <span class="cadet-info-value">
                                ${escapeHtml(deploymentStatus)}
                            </span>
                        </div>

                    </div>


                    {{-- LAST SEEN --}}

                    <div class="last-seen-box">

                        <div class="last-seen-icon">

                            <i class="fas fa-clock"></i>

                        </div>

                        <div class="last-seen-content">

                            <span class="last-seen-label">
                                Last Seen
                            </span>

                            <span class="last-seen-value">

                                ${escapeHtml(
                                    cadet.last_seen ||
                                    '-'
                                )}

                            </span>

                        </div>

                    </div>


                    {{-- COORDINATES --}}

                    <div class="cadet-coordinates">

                        <div class="coordinate-item">

                            <span class="coordinate-label">
                                Latitude
                            </span>

                            <span class="coordinate-value">

                                ${escapeHtml(
                                    cadet.latitude ||
                                    '-'
                                )}

                            </span>

                        </div>


                        <div class="coordinate-item">

                            <span class="coordinate-label">
                                Longitude
                            </span>

                            <span class="coordinate-value">

                                ${escapeHtml(
                                    cadet.longitude ||
                                    '-'
                                )}

                            </span>

                        </div>

                    </div>


                    {{-- ACTION --}}

                    <div class="cadet-popup-actions">

                        ${locationButton}

                    </div>

                `;


                cadetPopupOverlay.classList.add(
                    'show'
                );


                cadetPopup.classList.add(
                    'show'
                );


                document.body.style.overflow =
                    'hidden';

            }


            /* =====================================================
               CLOSE POPUP
            ====================================================== */

            window.closeCadetPopup =
                function ()
                {

                    cadetPopup.classList.remove(
                        'show'
                    );


                    cadetPopupOverlay.classList.remove(
                        'show'
                    );


                    activePopupCadetId =
                        null;


                    cadetInfo.dataset.cadetId =
                        '';


                    document.body.style.overflow =
                        '';

                };


            /* =====================================================
               ESC KEY
            ====================================================== */

            document.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Escape'
                    ) {

                        closeCadetPopup();

                    }

                }
            );


            /* =====================================================
               FIT BUTTON
            ====================================================== */

            if (fitAllCadetsBtn) {

                fitAllCadetsBtn.addEventListener(
                    'click',
                    function () {

                        fitAllCadets();

                    }
                );

            }


            /* =====================================================
               MAP INITIALIZATION
            ====================================================== */

            map =
                new maplibregl.Map({

                    container:
                        'map',

                    /*
                     * LIGHT MAP STYLE
                     *
                     * OpenFreeMap Liberty style.
                     *
                     * No Google Maps API key required.
                     */

                    style:
                        'https://tiles.openfreemap.org/styles/liberty',

                    center:
                        [
                            125.5406,
                            8.9475
                        ],

                    zoom:
                        13,

                    attributionControl:
                        true,

                    cooperativeGestures:
                        false,

                    dragRotate:
                        false,

                    pitchWithRotate:
                        false

                });


            /* =====================================================
               NAVIGATION CONTROL
            ====================================================== */

            map.addControl(

                new maplibregl.NavigationControl({

                    showCompass:
                        false

                }),

                'top-right'

            );


            /* =====================================================
               MAP LOAD
            ====================================================== */

            map.on(
                'load',
                function () {

                    console.log(
                        '[MapLibre] Light map loaded.'
                    );


                    loadInitialCadets();


                    setTimeout(
                        function () {

                            map.resize();

                        },
                        250
                    );

                }
            );


            /* =====================================================
               MAP ERROR
            ====================================================== */

            map.on(
                'error',
                function (event) {

                    console.error(
                        '[MapLibre] Map error:',
                        event
                    );

                }
            );


            /* =====================================================
               CLEANUP PREVIOUS ECHO LISTENER
            ====================================================== */

            function cleanupEchoListener()
            {

                if (
                    !window.Echo
                ) {

                    return;

                }


                try {

                    window.Echo.leave(
                        'admin.cadet-locations'
                    );


                    console.log(
                        '[Reverb] Previous location channel cleaned up.'
                    );

                }

                catch (error) {

                    console.warn(
                        '[Reverb] Unable to clean channel:',
                        error
                    );

                }


                previousEchoChannel =
                    null;


                previousEchoConnectionHandlers =
                    [];

            }


            /* =====================================================
               REALTIME LOCATION LISTENER
            ====================================================== */

            function listenForLocationUpdates()
            {

                if (
                    !window.Echo
                ) {

                    console.error(
                        '[Locations] Laravel Echo unavailable.'
                    );


                    setRealtimeStatus(
                        false
                    );


                    let attempts = 0;


                    const retryTimer =
                        setInterval(
                            function () {

                                attempts++;


                                if (
                                    window.Echo
                                ) {

                                    clearInterval(
                                        retryTimer
                                    );


                                    listenForLocationUpdates();

                                    return;

                                }


                                if (
                                    attempts >= 20
                                ) {

                                    clearInterval(
                                        retryTimer
                                    );


                                    console.error(
                                        '[Locations] Echo failed to initialize.'
                                    );

                                }

                            },
                            250
                        );


                    return;

                }


                if (
                    window.__adminCadetLocationEchoSubscribed
                ) {

                    console.log(
                        '[Reverb] Listener already active.'
                    );

                    return;

                }


                cleanupEchoListener();


                console.log(
                    '[Reverb] Subscribing to admin.cadet-locations'
                );


                const channel =
                    window.Echo.private(
                        'admin.cadet-locations'
                    );


                previousEchoChannel =
                    channel;


                window.__adminCadetLocationEchoSubscribed =
                    true;


                /* =================================================
                   LOCATION EVENT
                ================================================== */

                channel.listen(
                    '.cadet.location.updated',
                    function (event) {

                        console.log(
                            '[Reverb] Raw location event:',
                            event
                        );


                        const cadet =
                            normalizeCadetPayload(
                                event
                            );


                        if (

                            !cadet ||

                            !cadet.cadet_id

                        ) {

                            console.warn(
                                '[Reverb] Invalid location payload:',
                                event
                            );

                            return;

                        }


                        console.log(
                            '[Reverb] Updating marker:',
                            cadet.cadet_id,
                            cadet.full_name,
                            cadet.latitude,
                            cadet.longitude
                        );


                        upsertCadetMarker(
                            cadet,
                            false
                        );

                    }
                );


                /* =================================================
                   CONNECTION STATUS
                ================================================== */

                if (

                    window.Echo.connector &&

                    window.Echo.connector.pusher &&

                    window.Echo.connector.pusher.connection

                ) {

                    const connection =
                        window.Echo
                            .connector
                            .pusher
                            .connection;


                    const connectedHandler =
                        function () {

                            console.log(
                                '[Reverb] WebSocket Connected'
                            );


                            setRealtimeStatus(
                                true
                            );

                        };


                    const disconnectedHandler =
                        function () {

                            console.warn(
                                '[Reverb] WebSocket Disconnected'
                            );


                            setRealtimeStatus(
                                false
                            );

                        };


                    const errorHandler =
                        function (error) {

                            console.error(
                                '[Reverb] WebSocket Error:',
                                error
                            );


                            setRealtimeStatus(
                                false
                            );

                        };


                    connection.bind(
                        'connected',
                        connectedHandler
                    );


                    connection.bind(
                        'disconnected',
                        disconnectedHandler
                    );


                    connection.bind(
                        'error',
                        errorHandler
                    );


                    previousEchoConnectionHandlers = [

                        {

                            connection:
                                connection,

                            event:
                                'connected',

                            handler:
                                connectedHandler

                        },

                        {

                            connection:
                                connection,

                            event:
                                'disconnected',

                            handler:
                                disconnectedHandler

                        },

                        {

                            connection:
                                connection,

                            event:
                                'error',

                            handler:
                                errorHandler

                        }

                    ];


                    if (
                        connection.state ===
                        'connected'
                    ) {

                        setRealtimeStatus(
                            true
                        );

                    }

                }

                else {

                    console.warn(
                        '[Reverb] Pusher connection unavailable.'
                    );

                }

            }


            /* =====================================================
               INITIAL REALTIME STATUS
            ====================================================== */

            setRealtimeStatus(
                false
            );


            /*
             * Start Reverb listener.
             */

            listenForLocationUpdates();


            /* =====================================================
               GLOBAL CLEANUP
            ====================================================== */

            window.__cleanupAdminCadetLocationMap =
                function ()
                {

                    console.log(
                        '[Locations] Cleaning up map.'
                    );


                    previousEchoConnectionHandlers
                        .forEach(
                            function (item) {

                                try {

                                    item.connection.unbind(
                                        item.event,
                                        item.handler
                                    );

                                }

                                catch (error) {

                                    console.warn(
                                        '[Reverb] Unable to unbind:',
                                        error
                                    );

                                }

                            }
                        );


                    previousEchoConnectionHandlers =
                        [];


                    if (
                        window.Echo
                    ) {

                        try {

                            window.Echo.leave(
                                'admin.cadet-locations'
                            );

                        }

                        catch (error) {

                            console.warn(
                                '[Reverb] Unable to leave channel:',
                                error
                            );

                        }

                    }


                    previousEchoChannel =
                        null;


                    window.__adminCadetLocationEchoSubscribed =
                        false;


                    markerRegistry.forEach(
                        function (item) {

                            item.marker.remove();

                        }
                    );


                    markerRegistry.clear();


                    if (map) {

                        map.remove();

                        map = null;

                    }

                };


            /* =====================================================
               WINDOW RESIZE
            ====================================================== */

            window.addEventListener(
                'resize',
                function () {

                    if (map) {

                        map.resize();

                    }

                }
            );


        }

    );

})();

</script>

@endsection