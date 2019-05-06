<?php

return[
  'recaptcha'=>[
      'key'=>env('RECAPTCHA_KEY'),
      'secret'=>env('RECAPTCHA_SECRET')
  ],
    'adminstrators'=>[
        'keenan.barrows@example.org'
    ],
     'reputation' => [
        'thread_published' => 10,
        'reply_posted' => 5,
        'best_reply_awarded' => 25,
        'reply_favorited' => 15
    ],
    'pagination'=>[
        'perPage'=>25
    ]
];

