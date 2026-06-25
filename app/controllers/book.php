<?php
/** Book — shows the form, saves the enquiry, then redirects to /booked. */
$errors   = [];
$services = get_services();
$outlets  = get_active_outlets();
$old = ['name' => '', 'email' => '', 'phone' => '', 'outlet_id' => '', 'service_id' => '', 'preferred_date' => '', 'message' => ''];

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

            // Look up chosen service name.
            $service_name = '';
            foreach ($services as $svc) {
                if ((string) $svc['id'] === (string) $old['service_id']) {
                    $service_name = $svc['category_name'] . ' — ' . $svc['name'];
                    break;
                }
            }

            // Look up chosen outlet name.
            $outlet_name = '';
            foreach ($outlets as $out) {
                if ((string) $out['id'] === (string) $old['outlet_id']) {
                    $outlet_name = $out['name'];
                    break;
                }
            }

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['booking'] = [
                'wa_url' => whatsapp_booking_url($old, $service_name, $outlet_name),
                'name'   => $old['name'],
            ];
            header('Location: ' . url('booked'));
            exit;
        }
    } else {
        header('Location: ' . url(''));
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
    'outlets'  => $outlets,
    'hours'    => get_opening_hours(),
    'errors'   => $errors,
    'old'      => $old,
]);
