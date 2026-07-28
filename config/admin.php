<?php

$admins = array_values(array_filter([
    env('ADMIN_EMAIL', 'iec360@umbrella.sa'),
    env('ADMIN_EMAIL_2', 'mo.faour@gmail.com'),
    env('ADMIN_EMAIL_3', 'aomar@umbrella.sa'),
]));

return [
    'emails' => $admins,

    // ponytail: ADMIN_REGISTRATION_NOTIFICATIONS=false silences the admins for new
    // registrations only (contact form still uses 'emails'); eid always gets them.
    'registration_emails' => array_merge(
        env('ADMIN_REGISTRATION_NOTIFICATIONS', true) ? $admins : [],
        ['eidddsheba@gmail.com'],
    ),
];
