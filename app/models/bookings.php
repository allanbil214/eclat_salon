<?php
/** Booking enquiries submitted from the Book page. */
declare(strict_types=1);

function create_booking_request(array $d): bool {
    $stmt = db()->prepare(
        'INSERT INTO booking_requests
            (name, email, phone, service_id, preferred_date, message, created_at)
         VALUES (:name, :email, :phone, :service_id, :preferred_date, :message, :created_at)'
    );
    return $stmt->execute([
        'name'           => $d['name'],
        'email'          => $d['email'],
        'phone'          => $d['phone'],
        'service_id'     => $d['service_id'] !== '' ? (int) $d['service_id'] : null,
        'preferred_date' => $d['preferred_date'] !== '' ? $d['preferred_date'] : null,
        'message'        => $d['message'],
        'created_at'     => date('Y-m-d H:i:s'),
    ]);
}

/**
 * Build a wa.me link with the booking details pre-filled (Indonesian).
 * The number lives in settings → 'whatsapp' (digits only, e.g. 6281211988279).
 */
function whatsapp_booking_url(array $d, string $service_name = ''): string {
    $number = preg_replace('/\D+/', '', get_setting('whatsapp'));
    if ($number === '') {
        return '';
    }
    $lines = [
        'Halo ÉCLAT! Saya ingin membuat janji.',
        '',
        'Nama: '    . ($d['name'] !== '' ? $d['name'] : '-'),
        'Layanan: ' . ($service_name !== '' ? $service_name : '-'),
        'Tanggal: ' . (!empty($d['preferred_date']) ? $d['preferred_date'] : '-'),
    ];
    if (!empty($d['phone'])) {
        $lines[] = 'No. HP: ' . $d['phone'];
    }
    $lines[] = 'Catatan: ' . (!empty($d['message']) ? $d['message'] : '-');

    return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
}
