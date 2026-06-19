<?php
/** Book — shows the form and handles its submission. */
$errors  = [];
$success = false;
$old = ['name' => '', 'email' => '', 'phone' => '', 'service_id' => '', 'preferred_date' => '', 'message' => ''];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Honeypot: real users leave this empty.
    if (trim($_POST['website'] ?? '') === '') {
        foreach ($old as $k => $_) {
            $old[$k] = trim((string) ($_POST[$k] ?? ''));
        }
        if ($old['name'] === '') {
            $errors['name'] = 'Please tell us your name.';
        }
        if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'A valid email lets us confirm your appointment.';
        }
        if (!$errors) {
            create_booking_request($old);
            $success = true;
            $old = array_fill_keys(array_keys($old), '');
        }
    } else {
        $success = true; // silently absorb bots
    }
}

render('book', [
    'title'    => 'Book an Appointment — ' . get_setting('site_name_full'),
    'meta'     => 'Request an appointment at ' . get_setting('site_name') . '.',
    'active'   => '',
    'css'      => ['book'],
    'js'       => ['pages/book'],
    'services' => get_services(),
    'hours'    => get_opening_hours(),
    'errors'   => $errors,
    'success'  => $success,
    'old'      => $old,
]);
