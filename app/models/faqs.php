<?php
/** Frequently asked questions. */
declare(strict_types=1);

/** Active FAQs, in display order. */
function get_faqs(): array {
    return q('SELECT * FROM faq WHERE is_active = 1 ORDER BY sort_order ASC, id ASC');
}
