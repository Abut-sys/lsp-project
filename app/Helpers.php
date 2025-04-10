<?php

if (!function_exists('getFacilityIcon')) {
    function getFacilityIcon($facility)
    {
        $icons = [
            'ac' => 'fas fa-snowflake',
            'wifi' => 'fas fa-wifi',
            'tv' => 'fas fa-tv',
            'Shower' => 'fas fa-shower',
            'Breakfast' => 'fas fa-coffee',
            'gym' => 'fas fa-dumbbell',
            'restaurant' => 'fas fa-utensils',
            'pool' => 'fas fa-swimming-pool',
            'parking' => 'fas fa-parking',
            'spa' => 'fas fa-spa'
        ];

        return $icons[strtolower($facility)] ?? 'fas fa-star';
    }
}

if (!function_exists('getFacilityDescription')) {
    function getFacilityDescription($facility)
    {
        $descriptions = [
            'ac' => 'AC dengan pengatur suhu',
            'wifi' => 'Wi-Fi kecepatan tinggi',
            'tv' => 'TV layar datar 40"',
            'Shower' => 'Air panas 24 jam',
            'Breakfast' => 'Sarapan prasmanan',
            'gym' => 'Akses 24 jam ke gym',
            'restaurant' => 'Restoran bintang 5',
            'pool' => 'Kolam renang infinity',
            'parking' => 'Parkir valet gratis',
            'spa' => 'Layanan spa premium'
        ];

        return $descriptions[strtolower($facility)] ?? 'Fasilitas premium';
    }
}
