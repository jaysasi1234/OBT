import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Main
                'resources/css/app.css',
                'resources/js/app.js',

                // Admin
                'resources/css/admin/dashboard.css',

                // Cadets
                'resources/css/admin/cadets/cadets.css',
                'resources/css/admin/cadets/create.css',
                'resources/css/admin/cadets/location.css',

                // Cadet Requirements
                'resources/css/admin/cadet_requirements/cadet_requirements.css',

                // Cadet BS Requirements
                'resources/css/admin/cadet_bs_requirements/cadet_bs_requirements.css',

                // Complaints
                'resources/css/admin/complaints/complaints.css',

                // Deployment
                'resources/css/admin/deployment/deployment.css',

                // Locations
                'resources/css/admin/locations/locations.css',

                // Notifications
                'resources/css/admin/notifications/notification.css',

                // Remarks
                'resources/css/admin/remarks/remarks.css',

                // Reports
                'resources/css/admin/reports/cadet-masterlist.css',
                'resources/css/admin/reports/complaint.css',
                'resources/css/admin/reports/deployments.css',
                'resources/css/admin/reports/reporting.css',
                'resources/css/admin/reports/verification.css',

                // Settings
                'resources/css/admin/settings/account-credentials.css',
                'resources/css/admin/settings/batch.css',
                'resources/css/admin/settings/bs_requirements.css',
                'resources/css/admin/settings/complaint.css',
                'resources/css/admin/settings/course.css',
                'resources/css/admin/settings/onboard_requirements.css',
                'resources/css/admin/settings/report-settings.css',
                'resources/css/admin/settings/requirement.css',
                'resources/css/admin/settings/settings.css',
                'resources/css/admin/settings/system.css',

                // Shipped On Order
                'resources/css/admin/shipped_so/shipped_so.css',

                // Users
                'resources/css/admin/users/users.css',

                // Verification
                'resources/css/admin/verification/show.css',
                'resources/css/admin/verification/verification.css',
            ],

            refresh: true,
        }),
    ],
});