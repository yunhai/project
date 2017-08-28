<?php

return [
    'facebook' => [
        'id' => '182550052275861',
        'token' => 'c509b8ae330e03f8f2619cb1c506fe6b',
        'redirect' => 'user/login/facebook',
        'fallback' => 'user/login'
    ],
    'google' => [
        'id' => '129842522962-vqrcr1ek838f3ih4n1vmaf85l4p687k7.apps.googleusercontent.com',
        'token' => 'I0EQFuQhLe9HMV9atU4DIc4h',
        'redirect' => 'user/login/google',
        'accessType'   => 'offline',
        'fallback' => 'user/login'
    ]
];