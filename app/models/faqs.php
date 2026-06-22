<?php
/** Frequently asked questions. */
declare(strict_types=1);

/** Active FAQs, in display order. */
function get_faqs(): array {
    return q('SELECT * FROM faq WHERE is_active = 1 ORDER BY sort_order ASC, id ASC');
}

/** All FAQs incl. inactive (dashboard). */
function get_all_faqs(): array {
    return q('SELECT * FROM faq ORDER BY sort_order ASC, id ASC');
}

/** One FAQ by id (or null). */
function get_faq(int $id): ?array {
    return q1('SELECT * FROM faq WHERE id = :id', ['id' => $id]);
}
