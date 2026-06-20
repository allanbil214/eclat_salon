<?php
/** Book — shows the form, saves the enquiry, then redirects to /booked. */
$errors  = [];
$services = get_services();
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
            create_booking_request($old);          // keep the lead for the dashboard

            // Look up the chosen service name for the WhatsApp message.
            $service_name = '';
            foreach ($services as $svc) {
                if ((string) $svc['id'] === (string) $old['service_id']) {
                    $service_name = $svc['category_name'] . ' — ' . $svc['name'];
                    break;
                }
            }

            // Hand off to the confirmation page (Post/Redirect/Get: no resubmit
            // on refresh). The WhatsApp link travels in the session, not the URL.
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['booking'] = [
                'wa_url' => whatsapp_booking_url($old, $service_name),
                'name'   => $old['name'],
            ];
            header('Location: ' . url('booked'));
            exit;
        }
    } else {
        header('Location: ' . url(''));   // silently send bots away
        exit;
    }
}

render('book', [
    'title'    => 'Book an Appointment — ' . get_setting('site_name_full'),
    'meta'     => 'Request an appointment at ' . get_setting('site_name') . '.',
    'active'   => '',
    'css'      => ['book'],
    'js'       => ['pages/book'],
    'services' => $services,
    'hours'    => get_opening_hours(),
    'errors'   => $errors,
    'old'      => $old,
]);
