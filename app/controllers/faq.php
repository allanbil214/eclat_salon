<?php
/** FAQ — frequently asked questions. */
render('faq', [
    'title'  => 'FAQ — ' . get_setting('site_name_full'),
    'meta'   => 'Answers to common questions about appointments, colour, products and payment at ' . get_setting('site_name') . '.',
    'active' => '',
    'css'    => ['faq'],
    'faqs'   => get_faqs(),
]);
