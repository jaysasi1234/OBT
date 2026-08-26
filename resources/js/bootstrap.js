/*
|--------------------------------------------------------------------------
| BOOTSTRAP
|--------------------------------------------------------------------------
| Laravel Echo + Reverb
| Axios
| Realtime Notifications
| Realtime Chat
|--------------------------------------------------------------------------
*/

import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


// =========================================================
// AXIOS
// =========================================================

window.axios = axios;

window.axios.defaults.withCredentials = true;

window.axios.defaults.withXSRFToken = true;

window.axios.defaults.headers.common[
    'X-Requested-With'
] = 'XMLHttpRequest';


// =========================================================
// PUSHER
// =========================================================

window.Pusher = Pusher;


// =========================================================
// LARAVEL ECHO / REVERB
// =========================================================
//
// Echo is initialized ONLY ONCE here.
//
// Do NOT initialize Echo again inside app.js.
// =========================================================

window.Echo = new Echo({

    broadcaster: 'reverb',

    key:
        import.meta.env.VITE_REVERB_APP_KEY,

    wsHost:
        import.meta.env.VITE_REVERB_HOST,

    wsPort:
        Number(
            import.meta.env.VITE_REVERB_PORT
        ),

    wssPort:
        Number(
            import.meta.env.VITE_REVERB_PORT
        ),

    forceTLS: false,

    enabledTransports: [
        'ws',
        'wss'
    ],

    authEndpoint:
        '/broadcasting/auth',

    withCredentials: true,

    auth: {

        headers: {

            'X-CSRF-TOKEN':
                document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    ?.getAttribute('content'),

        }

    }

});


console.log(
    '[Echo] Laravel Echo Loaded'
);


// =========================================================
// CURRENT USER
// =========================================================

const userMeta =
    document.querySelector(
        'meta[name="user-id"]'
    );

const userId =
    userMeta?.getAttribute('content');


if (userId) {

    console.log(
        '[Echo] Realtime User ID:',
        userId
    );

} else {

    console.warn(
        '[Echo] No authenticated user ID found.'
    );

}


// =========================================================
// REALTIME CHAT
// =========================================================

if (userId) {

    window.Echo
        .private(
            `chat.${userId}`
        )
        .listen(
            '.message.sent',
            (event) => {

                console.log(
                    '[Echo] Realtime Chat:',
                    event
                );


                window.dispatchEvent(

                    new CustomEvent(
                        'chat-message',
                        {
                            detail: event
                        }
                    )

                );

            }
        );

}


// =========================================================
// REALTIME NOTIFICATIONS
// =========================================================
//
// Laravel database notifications broadcast through:
//
// App.Models.User.{id}
//
// Example:
//
// App.Models.User.81
//
// =========================================================

if (userId) {

    const notificationChannel =
        `App.Models.User.${userId}`;


    console.log(
        `[Echo] Subscribing to notification channel: ${notificationChannel}`
    );


    window.Echo
        .private(
            notificationChannel
        )
        .notification(
            (notification) => {

                console.log(
                    '[Echo] Realtime Notification:',
                    notification
                );


                // =================================================
                // ADMIN NOTIFICATION BADGE
                // =================================================

                updateAdminNotificationBadge();


                // =================================================
                // ADMIN NOTIFICATION LIST
                // =================================================

                addAdminRealtimeNotification(
                    notification
                );


                // =================================================
                // GLOBAL REALTIME EVENT
                // =================================================

                window.dispatchEvent(

                    new CustomEvent(
                        'realtime-notification',
                        {
                            detail:
                                notification
                        }
                    )

                );

            }
        );

}


// =========================================================
// UPDATE ADMIN NOTIFICATION BADGE
// =========================================================

function updateAdminNotificationBadge() {

    const notificationButton =
        document.querySelector(
            '.admin-notification-button'
        );


    if (!notificationButton) {

        console.warn(
            '[Echo] Admin notification button not found.'
        );

        return;

    }


    let badge =
        notificationButton.querySelector(
            '.admin-notification-badge'
        );


    // =====================================================
    // BADGE DOES NOT EXIST
    // =====================================================

    if (!badge) {

        badge =
            document.createElement(
                'span'
            );


        badge.className =
            'admin-notification-badge';


        badge.textContent =
            '1';


        notificationButton.appendChild(
            badge
        );


        console.log(
            '[Echo] Notification badge created.'
        );


        return;

    }


    // =====================================================
    // BADGE ALREADY EXISTS
    // =====================================================

    let currentCount =
        parseInt(
            badge.textContent || '0',
            10
        );


    if (
        Number.isNaN(
            currentCount
        )
    ) {

        currentCount = 0;

    }


    currentCount++;


    badge.textContent =
        currentCount > 99
            ? '99+'
            : currentCount;


    console.log(
        '[Echo] Notification badge updated:',
        currentCount
    );

}

// =========================================================
// ADD REALTIME NOTIFICATION TO ADMIN DROPDOWN
// =========================================================

function addAdminRealtimeNotification(notification) {

    const menu =
        document.querySelector(
            '#adminNotificationMenu'
        );


    if (!menu) {

        console.warn(
            '[Echo] Admin notification menu not found.'
        );

        return;

    }


    // =====================================================
    // NOTIFICATION DATA
    // =====================================================

    const notificationMessage =
        notification.message ??
        'New notification';


    const notificationIcon =
        notification.icon ??
        'fa-bell';


    const notificationUrl =
        notification.url ??
        '#';


    // =====================================================
    // SAFE MESSAGE
    // =====================================================

    const safeMessage =
        escapeNotificationHtml(
            notificationMessage
        );


        // =====================================================
        // NOTIFICATION ICON
        // =====================================================
        //
        // Laravel sends the actual Font Awesome class:
        //
        // fa-file-circle-check
        // fa-user-check
        // fa-graduation-cap
        // fa-ship
        // fa-message
        //
        // Use the exact class sent by Laravel.
        // =====================================================

        const iconClass =
            String(notificationIcon)
                .trim()
                .startsWith('fa-')
                    ? String(notificationIcon).trim()
                    : 'fa-bell';


    // =====================================================
    // CREATE NOTIFICATION LINK
    // =====================================================

    const link =
        document.createElement(
            'a'
        );


    /*
     * Use the URL directly here because it is assigned
     * through the DOM property rather than innerHTML.
     */
    link.href =
        notificationUrl;


    link.style.textDecoration =
        'none';


    // =====================================================
    // NOTIFICATION ITEM
    // =====================================================

    link.innerHTML = `

        <div class="
            admin-notification-item
            unread
        ">

            <div class="admin-notif-icon">

                <i class="fas ${iconClass}"></i>

            </div>


            <div class="admin-notif-content">

                <div class="admin-notif-text">

                    ${safeMessage}

                </div>


                <div class="admin-notif-time">

                    just now

                </div>

            </div>

        </div>

    `;


    // =====================================================
    // INSERT AFTER HEADER
    // =====================================================

    const header =
        menu.querySelector(
            '.admin-notification-header'
        );


    if (header) {

        header.insertAdjacentElement(
            'afterend',
            link
        );

    } else {

        menu.prepend(
            link
        );

    }


    // =====================================================
    // REMOVE "NO NOTIFICATIONS" MESSAGE
    // =====================================================

    const emptyItems =
        menu.querySelectorAll(
            '.admin-notification-item'
        );


    emptyItems.forEach(
        function (item) {

            const text =
                item.querySelector(
                    '.admin-notif-text'
                );


            if (
                text &&
                text.textContent
                    .trim()
                    .toLowerCase() ===
                    'no notifications found.'
            ) {

                const parent =
                    item.closest('a') ||
                    item;

                parent.remove();

            }

        }
    );


    // =====================================================
    // UPDATE UNREAD HEADER
    // =====================================================

    updateAdminUnreadHeader();


    console.log(
        '[Echo] Notification added to admin dropdown.'
    );

}


// =========================================================
// UPDATE ADMIN NOTIFICATION HEADER COUNT
// =========================================================

function updateAdminUnreadHeader() {

    const menu =
        document.querySelector(
            '#adminNotificationMenu'
        );


    if (!menu) {

        return;

    }


    const unreadItems =
        menu.querySelectorAll(
            '.admin-notification-item.unread'
        );


    const unreadCount =
        unreadItems.length;


    const header =
        menu.querySelector(
            '.admin-notification-header'
        );


    if (!header) {

        return;

    }


    let unreadText =
        header.querySelector(
            '.admin-live-unread-count'
        );


    // =====================================================
    // NO UNREAD NOTIFICATIONS
    // =====================================================

    if (unreadCount <= 0) {

        if (unreadText) {

            unreadText.remove();

        }

        return;

    }


    // =====================================================
    // CREATE HEADER COUNT
    // =====================================================

    if (!unreadText) {

        unreadText =
            document.createElement(
                'span'
            );


        unreadText.className =
            'admin-live-unread-count';


        unreadText.style.color =
            '#60a5fa';


        unreadText.style.fontSize =
            '10px';


        header.appendChild(
            unreadText
        );

    }


    unreadText.textContent =
        `${unreadCount} unread`;

}


// =========================================================
// ESCAPE NOTIFICATION HTML
// =========================================================

function escapeNotificationHtml(
    value
) {

    const div =
        document.createElement(
            'div'
        );


    div.textContent =
        value ?? '';


    return div.innerHTML;

}


// =========================================================
// ESCAPE ATTRIBUTE
// =========================================================

function escapeNotificationAttribute(
    value
) {

    return String(
        value ?? ''
    )
        .replace(
            /&/g,
            '&amp;'
        )
        .replace(
            /"/g,
            '&quot;'
        )
        .replace(
            /'/g,
            '&#039;'
        )
        .replace(
            /</g,
            '&lt;'
        )
        .replace(
            />/g,
            '&gt;'
        );

}


// =========================================================
// REVERB CONNECTION MONITOR
// =========================================================

if (
    window.Echo?.connector?.pusher
) {

    const connection =
        window.Echo
            .connector
            .pusher
            .connection;


    // =====================================================
    // CONNECTED
    // =====================================================

    connection.bind(
        'connected',
        () => {

            console.log(
                '[Reverb] WebSocket Connected'
            );


            window.dispatchEvent(

                new CustomEvent(
                    'reverb-connected'
                )

            );

        }
    );


    // =====================================================
    // DISCONNECTED
    // =====================================================

    connection.bind(
        'disconnected',
        () => {

            console.warn(
                '[Reverb] WebSocket Disconnected'
            );


            window.dispatchEvent(

                new CustomEvent(
                    'reverb-disconnected'
                )

            );

        }
    );


    // =====================================================
    // ERROR
    // =====================================================

    connection.bind(
        'error',
        (error) => {

            console.error(
                '[Reverb] WebSocket Error:',
                error
            );


            window.dispatchEvent(

                new CustomEvent(
                    'reverb-error',
                    {
                        detail:
                            error
                    }
                )

            );

        }
    );

}


// =========================================================
// DEBUG INFORMATION
// =========================================================

console.log(
    '[Echo] Realtime initialization complete.'
);

// =========================================================
// USER ONLINE HEARTBEAT
// =========================================================

function sendHeartbeat() {

    if (!document.querySelector(
        'meta[name="user-id"]'
    )) {
        return;
    }

    axios.post('/user/heartbeat')
        .then(response => {

            console.log(
                '[Presence] Heartbeat:',
                response.data
            );

        })
        .catch(error => {

            console.warn(
                '[Presence] Heartbeat failed:',
                error
            );

        });
}


// Send immediately
sendHeartbeat();


// Then every 30 seconds
setInterval(
    sendHeartbeat,
    30000
);