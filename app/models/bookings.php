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
