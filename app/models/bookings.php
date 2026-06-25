<?php
/** Booking enquiries submitted from the Book page. */
declare(strict_types=1);

function create_booking_request(array $d): bool {
    $stmt = db()->prepare(
        'INSERT INTO booking_requests
            (name, email, phone, service_id, outlet_id, preferred_date, message, created_at)
         VALUES (:name, :email, :phone, :service_id, :outlet_id, :preferred_date, :message, :created_at)'
    );
    return $stmt->execute([
        'name'           => $d['name'],
        'email'          => $d['email'],
        'phone'          => $d['phone'],
        'service_id'     => $d['service_id'] !== '' ? (int) $d['service_id'] : null,
        'outlet_id'      => !empty($d['outlet_id']) ? (int) $d['outlet_id'] : null,
        'preferred_date' => $d['preferred_date'] !== '' ? $d['preferred_date'] : null,
        'message'        => $d['message'],
        'created_at'     => date('Y-m-d H:i:s'),
    ]);
}

/**
 * Build a wa.me link with the booking details pre-filled (Indonesian).
 * The number lives in settings → 'whatsapp' (digits only, e.g. 6281211988279).
 */
function whatsapp_booking_url(array $d, string $service_name = '', string $outlet_name = '', string $outlet_whatsapp = ''): string {
    $raw    = $outlet_whatsapp !== '' ? $outlet_whatsapp : get_setting('whatsapp');
    $number = preg_replace('/\D+/', '', $raw);
    if ($number === '') {
        return '';
    }
    $lines = [
        'Halo ÉCLAT! Saya ingin membuat janji.',
        '',
        'Nama: '    . ($d['name'] !== '' ? $d['name'] : '-'),
        'Outlet: '  . ($outlet_name !== '' ? $outlet_name : '-'),
        'Layanan: ' . ($service_name !== '' ? $service_name : '-'),
        'Tanggal: ' . (!empty($d['preferred_date']) ? $d['preferred_date'] : '-'),
    ];
    if (!empty($d['phone'])) {
        $lines[] = 'No. HP: ' . $d['phone'];
    }
    $lines[] = 'Catatan: ' . (!empty($d['message']) ? $d['message'] : '-');

    return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
}

/* ---------------- dashboard (admin) helpers ---------------- */
function get_booking_requests(): array {
    return q('SELECT b.*, s.name AS service_name, o.name AS outlet_name
              FROM booking_requests b
              LEFT JOIN services s ON s.id = b.service_id
              LEFT JOIN outlets o ON o.id = b.outlet_id
              ORDER BY b.created_at DESC, b.id DESC');
}
function get_booking_request_by_id(int $id): ?array {
    return q1('SELECT b.*, s.name AS service_name, o.name AS outlet_name, o.whatsapp AS outlet_whatsapp
               FROM booking_requests b
               LEFT JOIN services s ON s.id = b.service_id
               LEFT JOIN outlets o ON o.id = b.outlet_id
               WHERE b.id = :id', ['id' => $id]);
}
/** wa.me link to reply to the customer (Indonesian). Uses wa_number() from orders model. */
function whatsapp_booking_reply_url(array $b): string {
    $number = wa_number((string) ($b['phone'] ?? ''));
    if ($number === '') return '';
    $name = trim((string) $b['name']);
    $lines = [
        'Halo ' . ($name !== '' ? $name : 'Kak') . '! Terima kasih sudah menghubungi ÉCLAT.',
    ];
    if (!empty($b['service_name'])) $lines[] = 'Layanan: ' . $b['service_name'];
    if (!empty($b['preferred_date'])) $lines[] = 'Tanggal yang diminta: ' . $b['preferred_date'];
    $lines[] = '';
    $lines[] = 'Kami ingin membantu mengatur jadwal Anda.';
    return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
}