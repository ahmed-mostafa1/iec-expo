<?php

return [
    'emails' => array_values(array_filter([
        env('ADMIN_EMAIL', 'iec360@umbrella.sa'),
        env('ADMIN_EMAIL_2', 'mo.faour@gmail.com'),
        env('ADMIN_EMAIL_3', 'aomar@umbrella.sa'),
    ])),
];
