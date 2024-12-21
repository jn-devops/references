<?php

return [
    'expiry' => env('REFERENCE_EXPIRY_INTERVAL', 'P30D'), //https://en.wikipedia.org/wiki/ISO_8601#Durations
    'models' => [
        'input' => \Homeful\References\Models\Input::class,
        'lead' => \Homeful\KwYCCheck\Models\Lead::class,
        'contract' => \Homeful\Contracts\Models\Contract::class,
        'contact' => \Homeful\Contacts\Models\Contact::class,
    ],
];
