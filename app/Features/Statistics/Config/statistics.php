<?php

return [
    'name' => 'Statistics',
    'description' => 'Statistics feature for dashboard analytics and reporting',
    'version' => '1.0.0',
    'author' => 'Qena Market Place',

    // Dashboard refresh intervals (in seconds)
    'refresh_intervals' => [
        'dashboard' => 300, // 5 minutes
        'properties' => 600, // 10 minutes
        'users' => 900, // 15 minutes
    ],

    // Chart colors for frontend
    'chart_colors' => [
        'primary' => '#3B82F6',
        'success' => '#10B981',
        'warning' => '#F59E0B',
        'danger' => '#EF4444',
        'info' => '#06B6D4',
        'secondary' => '#6B7280',
    ],

    // Default trends period
    'default_trends_months' => 6,
];
