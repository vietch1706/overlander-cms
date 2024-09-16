<?php

return [
    'override_router' => false,
    'temp_email_domain' => '@legato.co',
    'firebase_project_id' => '',
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/WWW-Authenticate
    'challenge' => 'WWW-Authenticate: Bearer realm="Application gateway."',
    'paginate_records_max_limit' => 100,
    'paginate_records_per_page' => 30,
    'login_timeout' => 60*24*365,
];
