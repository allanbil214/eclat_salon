<?php
/** 404. */
render('not_found', [
    'title'  => 'Page not found — ' . get_setting('site_name_full'),
    'active' => '',
]);
