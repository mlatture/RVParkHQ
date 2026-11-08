<?php

return [
    'minimum_seconds' => 2,
    'maximum_age_seconds' => 2 * 60 * 60,
    'duplicate_seconds' => 2 * 60,

    'ip' => [
        'max_attempts' => 10,
        'decay_seconds' => 60,
    ],

    'email' => [
        'max_attempts' => 5,
        'decay_seconds' => 60 * 60,
    ],
];
