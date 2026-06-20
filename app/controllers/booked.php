<?php
/** Booked — confirmation page reached only after a successful booking. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$booking = $_SESSION['booking'] ?? null;
unset($_SESSION['booking']);          // one-time: refreshing won't replay it

if (!$booking) {
    // Visited directly without booking — send them to the form.
    header('Location: ' . url('book'));
    exit;
}

render('booked', [
    'title'   => 'Appointment requested — ' . get_setting('site_name_full'),
    'meta'    => 'Your appointment request has been received.',
    'active'  => '',
    'css'     => ['booked'],
    'js'      => ['pages/booked'],
    'wa_url'  => $booking['wa_url'],
    'name'    => $booking['name'],
]);
