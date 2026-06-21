-- ÉCLAT — Hair Atelier · seed data
-- Images use placeholder CDNs (i.pravatar.cc faces, picsum.photos editorial
-- shots) so the demo always renders. Every image is a single DB field —
-- swap in real Unsplash or the salon's own photos by editing image_url / photo_url.

SET NAMES utf8mb4;

-- ---- Settings ------------------------------------------------------------
INSERT INTO settings (skey, svalue) VALUES
('site_name',        'ÉCLAT'),
('site_name_full',   'ÉCLAT — Hair Atelier'),
('tagline',          'The art of beautiful hair'),
('currency_symbol',  'Rp'),
('founded_year',     '2009'),
('phone',            '+62 21 2700 1488'),
('whatsapp',         '6281211988279'),
('email',            'studio@eclat-atelier.id'),
('address_line1',    'Jl. Senopati Raya No. 72, Kebayoran Baru'),
('address_line2',    'Jakarta Selatan 12190, Indonesia'),
('instagram',        'https://instagram.com/eclat.atelier'),
('facebook',         'https://facebook.com/eclatatelier'),
('tiktok',           'https://tiktok.com/@eclat.atelier'),
('youtube',          'https://youtube.com/@eclatatelier'),
('hero_eyebrow',     'Est. 2009 · Award-winning atelier'),
('hero_title',       'Hair, considered as craft.'),
('hero_lead',        'A Jakarta atelier where master colourists and cutters turn a single appointment into the look you have been picturing for years.'),
('about_eyebrow',    'The house of ÉCLAT'),
('about_title',      'Sixteen years of quiet, deliberate transformation'),
('about_p1',         'ÉCLAT began in 2009 as a two-chair studio with one belief: that great hair is not a service you buy but a craft you commission. Today our atelier brings together colourists, cutters and texture specialists who treat every head of hair as its own brief.'),
('about_p2',         'We keep the room small on purpose. Fewer chairs means longer appointments, undivided attention, and the kind of result that has guests travelling across the city — and occasionally across an ocean — to sit in our chairs.'),
('booking_note',     'Appointments are confirmed within one business day. For same-day requests, call the studio.');

-- ---- Opening hours -------------------------------------------------------
INSERT INTO opening_hours (day_order, day_name, open_time, close_time, is_closed) VALUES
(1, 'Monday',    NULL,       NULL,       1),
(2, 'Tuesday',   '10:00:00', '20:00:00', 0),
(3, 'Wednesday', '10:00:00', '20:00:00', 0),
(4, 'Thursday',  '10:00:00', '21:00:00', 0),
(5, 'Friday',    '10:00:00', '21:00:00', 0),
(6, 'Saturday',  '09:00:00', '18:00:00', 0),
(7, 'Sunday',    '10:00:00', '16:00:00', 0);

-- ---- Stats (homepage counters) ------------------------------------------
INSERT INTO stats (label, value, prefix, suffix, sort_order) VALUES
('Years of artistry',  16,    '',  '',  1),
('Guests transformed', 12000, '',  '+', 2),
('Master stylists',    8,     '',  '',  3),
('Five-star reviews',  2400,  '',  '+', 4),
('Industry awards',    14,    '',  '',  5);

-- ---- Service categories --------------------------------------------------
INSERT INTO service_categories (id, name, slug, blurb, sort_order) VALUES
(1, 'Cut & Style',     'cut-style',   'Precision shapes and finishes, tailored to how you actually wear your hair.', 1),
(2, 'Colour',          'colour',      'From lived-in balayage to bold creative colour, built by hand.',            2),
(3, 'Treatments',      'treatments',  'Repair, smooth and restore — the health work behind every great look.',     3),
(4, 'Bridal & Events', 'bridal',      'Trials, day-of styling and occasion hair for the moments that matter.',      4),
(5, 'Men''s Grooming', 'mens',        'Sharp cuts, fades and beard work, with the same care as everything else.',  5);

-- ---- Services ------------------------------------------------------------
INSERT INTO services (category_id, name, description, price_from, price_to, duration_min, is_featured, sort_order) VALUES
(1, 'Precision Cut & Finish',        'A consultation, precision cut and a polished blow-dry finish.',                 250000,  450000,  60,  0, 1),
(1, 'Restyle & Consultation',        'For a real change — extended consultation, restyle and styling lesson.',       350000,  600000,  90,  0, 2),
(1, 'Blow-Dry & Styling',            'Wash, blow-dry and styling for everyday polish or a night out.',               150000,  300000,  45,  0, 3),
(1, 'Curl & Wave Styling',           'Heat or set styling that works with your natural texture, not against it.',    200000,  350000,  60,  0, 4),

(2, 'Full Balayage',                 'Hand-painted, lived-in colour with a tailored toner and finish.',              1500000, 3500000, 180, 1, 1),
(2, 'Signature Highlights',          'Foil work for dimension and brightness, placed to suit your cut.',             1200000, 2500000, 150, 1, 2),
(2, 'Creative / Fashion Colour',     'Vivids, bold blocking and bespoke colour design.',                             1800000, 4000000, 210, 0, 3),
(2, 'Full-Head Colour',              'Even, glossy single-process colour from root to tip.',                         800000,  1500000, 120, 0, 4),
(2, 'Root & Gloss Refresh',          'A regrowth touch-up and a shine-boosting gloss between full appointments.',     600000,  1000000, 90,  0, 5),

(3, 'Olaplex Bond Repair',           'Rebuilds broken bonds for stronger, healthier hair. Add to any service.',      350000,  600000,  45,  0, 1),
(3, 'Keratin Smoothing',             'Tames frizz and cuts styling time for months. Built to your hair type.',       1500000, 3500000, 150, 1, 2),
(3, 'Scalp & Hydration Ritual',      'A deep-cleansing scalp treatment and intensive moisture mask.',                400000,  700000,  60,  0, 3),
(3, 'Gloss & Shine Treatment',       'A quick, mirror-shine top-up that refreshes tone and condition.',              300000,  500000,  30,  0, 4),

(4, 'Bridal Hair — Trial & Day',     'A pre-wedding trial plus styling on the day, start to veil.',                  3500000, 7500000, NULL,1, 1),
(4, 'Event Updo',                    'A bespoke updo for galas, parties and red-carpet moments.',                    600000,  1200000, 75,  0, 2),
(4, 'Occasion Blow-Dry',             'A long-lasting, camera-ready blow-dry for any special event.',                 400000,  700000,  45,  0, 3),

(5, 'Men''s Cut & Style',            'Consultation, scissor or clipper cut, and a styling finish.',                  150000,  300000,  45,  0, 1),
(5, 'Skin Fade & Detail',            'A crisp, blended fade with precise detailing and a hot-towel finish.',         180000,  350000,  50,  0, 2),
(5, 'Beard Sculpt',                  'Beard shaping, line-up and conditioning. Pairs well with a cut.',              100000,  200000,  30,  0, 3);

-- ---- Team ----------------------------------------------------------------
INSERT INTO team (name, role, specialty, bio, photo_url, instagram, years_exp, is_owner, sort_order) VALUES
('Dewi Anggraini',   'Founder & Creative Director', 'Editorial colour & atelier direction',
 'Dewi opened ÉCLAT in 2009 after a decade between Paris and Jakarta runway teams. She still takes a handful of colour clients each week.',
 'assets/img/team/1.jpg', '@dewi.eclat',   22, 1, 1),
('Sari Wijaya',      'Master Colourist',            'Balayage, blonding & colour correction',
 'Sari is our go-to for the most delicate blonding and correction work — the appointments other salons turn away.',
 'assets/img/team/2.jpg', '@sari.colour',  14, 0, 2),
('Reza Pratama',     'Senior Stylist',              'Precision cutting & restyles',
 'Reza''s cuts are architectural — built to grow out beautifully and fall back into shape every morning.',
 'assets/img/team/3.jpg', '@reza.cuts',    12, 0, 3),
('Putri Maharani',   'Master Stylist',              'Curls, coils & textured hair',
 'A texture specialist who shapes curls dry, Putri has a waitlist of guests who finally feel seen.',
 'assets/img/team/4.jpg', '@putri.texture',11, 0, 4),
('Nadia Kusuma',     'Colour Specialist',           'Creative & fashion colour',
 'From soft money-piece to full vivids, Nadia treats colour as design. Nothing is off the table.',
 'assets/img/team/5.jpg', '@nadia.colour', 9,  0, 5),
('Bayu Saputra',     'Senior Barber',               'Men''s grooming, fades & beards',
 'Bayu brought barbering precision into the atelier — fades and beard work with a tailor''s patience.',
 'assets/img/team/6.jpg', '@bayu.cuts',    10, 0, 6),
('Maya Hartono',     'Bridal Specialist',           'Updos & occasion styling',
 'Maya has styled more than four hundred weddings. Calm under pressure, flawless under a veil.',
 'assets/img/team/7.jpg', '@maya.bridal',  13, 0, 7),
('Arif Setiawan',    'Stylist',                     'Cutting & everyday styling',
 'Arif trained in-house at ÉCLAT and brings a fresh, modern eye to classic cuts and blow-dries.',
 'assets/img/team/8.jpg', '@arif.style',   7,  0, 8);

-- ---- Gallery categories --------------------------------------------------
INSERT INTO gallery_categories (id, name, slug, sort_order) VALUES
(1, 'Colour',   'colour',   1),
(2, 'Cuts',     'cuts',     2),
(3, 'Balayage', 'balayage', 3),
(4, 'Updos',    'updos',    4),
(5, 'Bridal',   'bridal',   5),
(6, 'Men''s',   'mens',     6);

-- ---- Gallery (image_url + optional before_image_url for the reveal) ------
INSERT INTO gallery (category_id, title, image_url, before_image_url, stylist_id, is_featured, sort_order) VALUES
(3, 'Lived-in bronde balayage',  'assets/img/gallery/g1.jpg',  'assets/img/gallery/g1b.jpg', 2, 1, 1),
(1, 'Soft copper melt',          'assets/img/gallery/g2.jpg',  NULL, 5, 1, 2),
(2, 'Blunt collarbone bob',      'assets/img/gallery/g3.jpg',  'assets/img/gallery/g3b.jpg', 3, 1, 3),
(5, 'Romantic bridal half-up',   'assets/img/gallery/g4.jpg',  NULL, 7, 1, 4),
(1, 'Icy platinum blonde',       'assets/img/gallery/g5.jpg',  'assets/img/gallery/g5b.jpg', 2, 1, 5),
(4, 'Sculpted evening updo',     'assets/img/gallery/g6.jpg',  NULL, 7, 0, 6),
(6, 'Textured crop & skin fade', 'assets/img/gallery/g7.jpg',  NULL, 6, 0, 7),
(2, 'Long layered restyle',      'assets/img/gallery/g8.jpg',  NULL, 3, 0, 8),
(3, 'Honey-dimensional balayage','assets/img/gallery/g9.jpg',  NULL, 5, 0, 9),
(2, 'Natural curl shaping',      'assets/img/gallery/g10.jpg', NULL, 4, 0, 10),
(1, 'Rich brunette gloss',       'assets/img/gallery/g11.jpg', NULL, 5, 0, 11),
(6, 'Classic gentleman''s cut',  'assets/img/gallery/g12.jpg', NULL, 6, 0, 12);

-- ---- Testimonials --------------------------------------------------------
INSERT INTO testimonials (author, rating, quote, service, source, sort_order) VALUES
('Priya N.',     5, 'I have spent years and a small fortune trying to get my blonde right. Mara fixed it in one appointment. I actually cried a little.', 'Colour correction', 'Google',    1),
('James W.',     5, 'Theo is the first person in a decade who cut my hair and it still looked good a month later. I will not go anywhere else.',            'Precision Cut',    'Google',    2),
('Aaliyah R.',   5, 'They understood my curls without me having to explain or apologise. Yuki is a genius and the room feels like a calm little sanctuary.', 'Curl shaping',     'Instagram', 3),
('Sofia & Marc', 5, 'Elena did my bridal trial and the day-of styling. It survived rain, tears and a ten-hour party. Flawless from first photo to last.',  'Bridal Hair',      'Google',    4),
('Daniel K.',    5, 'Booked on a whim for a fade and a beard tidy. Best grooming experience I have had — proper consultation, no rush, perfect result.',     'Skin Fade',        'Google',    5),
('Hana T.',      5, 'The balayage is the most natural I have ever had. Six weeks on and it is still gorgeous. Worth every cent and the trip downtown.',       'Full Balayage',    'Instagram', 6);

-- ---- Brands (marquee) ----------------------------------------------------
INSERT INTO brands (name, sort_order) VALUES
('Olaplex', 1), ('Kérastase', 2), ('Wella Professionals', 3), ('L''Oréal Professionnel', 4),
('Davines', 5), ('Oribe', 6), ('Redken', 7), ('K18', 8);

-- ---- Sample booking enquiries (so the future dashboard has data) ---------
INSERT INTO booking_requests (name, email, phone, service_id, preferred_date, message, created_at) VALUES
('Maya Putri', 'maya.putri@example.com', '+62 812-9087-5521', 5, '2026-06-24', 'Would love to go a few shades lighter for summer — open to your recommendation.', '2026-06-15 14:22:00'),
('Tomi Reza',    'tomi.reza@example.com', '+62 813-4410-2208', 18, '2026-06-21', 'First time — looking for a fresh fade before a wedding.', '2026-06-16 09:05:00');

-- =========================================================================
-- TODO / FUTURE seed data (tables exist but are not wired to any page yet)
-- =========================================================================
INSERT INTO faq (question, answer, sort_order) VALUES
('Do I need a consultation before a colour appointment?', 'For first-time colour, big changes or corrections, yes — we book a short consultation (often same visit) so your stylist can plan properly. For maintenance, it is built into your appointment.', 1),
('What is your cancellation policy?', 'We ask for 48 hours'' notice so we can offer the slot to someone on the waitlist. Late cancellations or no-shows may incur a fee of up to 50% of the booked service.', 2),
('Do you take a deposit?', 'For longer colour services and first-time bookings we take a small deposit when you book, which comes straight off your final bill. Everyday cuts and styling do not require one.', 3),
('How long does balayage last?', 'Because it is hand-painted and grows out softly, most guests return every 10–14 weeks, with a gloss refresh in between to keep the tone fresh.', 4),
('How do I keep my colour looking fresh at home?', 'Wash a little less often and in cooler water, use a sulphate-free colour-safe shampoo, and add a weekly bonding mask. We are happy to build you a simple routine in the chair.', 5),
('Can I buy the products you use in the salon?', 'Yes — most of what we reach for in the chair is on our shelf, and you can browse it on our Shop page or ask your stylist on the day. Tap Enquire on any product to ask about availability on WhatsApp.', 6),
('What payment methods do you accept?', 'We accept cash, all major debit and credit cards, and QRIS / bank transfer. Payment is taken at the end of your appointment.', 7),
('Where are you, and is there parking?', 'We are in Kebayoran Baru, South Jakarta. There is paid parking in the building and street parking nearby; ride-hailing drops you right at the door.', 8);

INSERT INTO posts (title, slug, excerpt, body, cover_url, author, category, published_at, is_published) VALUES
('How to make your balayage last longer', 'make-balayage-last',
 'Five habits that keep hand-painted colour looking fresh for months.',
 '<p>Balayage is hand-painted to grow out softly, but the colour still needs care to stay luminous between visits. With a few simple habits you can keep that sun-kissed finish looking fresh for months.</p><h2>Wash less, and wash cooler</h2><p>Every wash gently lifts colour. Stretching the time between washes, and rinsing in cool rather than hot water, keeps the tone richer for longer. Two to three washes a week is plenty for most hair types.</p><h2>Feed the ends</h2><p>Painted colour sits on the mid-lengths and ends, the most fragile part of the hair. A weekly mask keeps them soft and reflective.</p><ul><li>Use a sulphate-free, colour-safe shampoo.</li><li>Apply a bonding treatment once a week.</li><li>Always use heat protection before styling.</li><li>Book a gloss refresh every eight to ten weeks.</li></ul><p>Caring for balayage is mostly about gentleness. Treat the colour kindly and it will reward you with months of effortless shine.</p>',
 'assets/img/blog/c1.jpg', 'Mara Voss', 'Colour', '2026-05-28 10:00:00', 1),

('The five-minute routine for healthier hair', 'five-minute-hair-routine',
 'Small daily habits beat expensive products. Here is where to start.',
 '<p>Healthy hair rarely comes from a single miracle product. It comes from a handful of small habits repeated daily. The good news is that the whole routine takes about five minutes.</p><h2>Start in the shower</h2><p>Focus shampoo on the scalp, not the lengths, and let it rinse through the ends. Follow with conditioner from the mid-lengths down, and comb it through with your fingers before rinsing.</p><h2>Be kind when it is wet</h2><p>Wet hair stretches and snaps easily. Blot with a soft towel rather than rubbing, and detangle gently from the ends upward.</p><ul><li>Always detangle from the bottom up.</li><li>Let hair air-dry to eighty percent before heat styling.</li><li>Sleep on a silk pillowcase to cut friction.</li></ul><p>Consistency is everything. Done daily, these small choices add up to visibly stronger, glossier hair within weeks.</p>',
 'assets/img/blog/c2.jpg', 'Sasha Lin', 'Care', '2026-05-14 10:00:00', 1),

('Choosing a fringe for your face shape', 'fringe-for-face-shape',
 'Curtain, blunt, or wispy — what actually suits you.',
 '<p>A fringe can reframe your whole face, but the right shape depends on your features. Here is a quick guide to what tends to flatter each face shape.</p><h2>Round faces</h2><p>Longer, side-swept or curtain fringes add length and structure, drawing the eye downward rather than across.</p><h2>Square and angular faces</h2><p>Soft, wispy fringes soften a strong jaw, while a heavier blunt fringe can emphasise it if that is the look you want.</p><h2>Long faces</h2><p>A fuller, blunt fringe shortens the face and balances the proportions beautifully.</p><p>The most important thing is honest advice in the chair. Bring a photo of what you love and we will adapt it to suit you.</p>',
 'assets/img/blog/c3.jpg', 'Theo Park', 'Styling', '2026-04-30 10:00:00', 1),

('This season we are loving warm brunettes', 'warm-brunettes-trend',
 'Soft, glossy, low-maintenance brown is the colour of the season.',
 '<p>After seasons of cool tones, warmth is back. Glossy chestnut, soft chocolate and golden brunette are everywhere, and for good reason: they flatter almost every skin tone and grow out gracefully.</p><h2>Why it works</h2><p>Warm brunette catches the light without the upkeep of high-contrast blonde. A few face-framing highlights add dimension while keeping the maintenance low.</p><p>If you have been colouring cool for years, the shift can be gradual. We can warm the tone over a couple of appointments so it never feels drastic.</p><p>Pair it with a weekly gloss at home and the colour stays rich and reflective right up to your next visit.</p>',
 'assets/img/blog/c4.jpg', 'Sasha Lin', 'Trends', '2026-04-12 10:00:00', 1),

('Planning your bridal hair', 'planning-bridal-hair',
 'A simple timeline so your wedding-day hair is effortless.',
 '<p>Wedding hair should feel like you on your best day, not a stranger in the mirror. A little planning makes the morning calm rather than rushed.</p><h2>Three months out</h2><p>Book your trial and any colour you want refreshed. This is the time to experiment, not the week of the wedding.</p><h2>The final weeks</h2><p>Keep colour and cuts subtle and familiar. A bonding treatment in the last fortnight leaves the hair glossy for photographs.</p><ul><li>Bring photos, your veil and any accessories to the trial.</li><li>Tell us about the dress neckline — it shapes the style.</li><li>Plan a gentle wash the day before, not the morning of.</li></ul><p>On the day, we come to you or you come to us, and all you have to do is relax.</p>',
 'assets/img/blog/c5.jpg', 'Nadia Reyes', 'Occasions', '2026-03-20 10:00:00', 1);

INSERT INTO products (name, slug, brand, description, price, image_url, in_stock, sort_order) VALUES
('No.3 Hair Perfector',              'olaplex-no-3-hair-perfector',          'Olaplex',             'At-home bond-building treatment to use weekly between appointments.',          450000,  'assets/img/shop/p1.jpg', 1, 1),
('No.4 Bond Maintenance Shampoo',    'olaplex-no-4-bond-maintenance-shampoo','Olaplex',             'Reparative, hydrating shampoo that keeps coloured hair strong.',               520000,  'assets/img/shop/p2.jpg', 1, 2),
('Bain Satin Shampoo',               'kerastase-bain-satin-shampoo',         'Kérastase',           'Nourishing everyday shampoo for normal to dry hair.',                          520000,  'assets/img/shop/p3.jpg', 1, 3),
('Nutritive Hair Mask',              'kerastase-nutritive-hair-mask',        'Kérastase',           'Deep-conditioning mask that restores softness and shine.',                     680000,  'assets/img/shop/p4.jpg', 1, 4),
('OI Oil',                           'davines-oi-oil',                       'Davines',             'Lightweight, multi-benefit oil for shine, softness and heat protection.',      590000,  'assets/img/shop/p5.jpg', 1, 5),
('Gold Lust Repair Shampoo',         'oribe-gold-lust-repair-shampoo',       'Oribe',               'A luxury repairing shampoo that rebalances and revitalises the scalp.',        850000,  'assets/img/shop/p6.jpg', 1, 6),
('Oil Reflections Luminous Oil',     'wella-oil-reflections-luminous-oil',   'Wella Professionals', 'Anti-oxidant oil for instant smoothness and mirror shine.',                    420000,  'assets/img/shop/p7.jpg', 1, 7),
('Acidic Bonding Concentrate',       'redken-acidic-bonding-concentrate',    'Redken',              'Leave-in treatment for severely damaged, over-processed hair.',                480000,  'assets/img/shop/p8.jpg', 1, 8),
('Leave-In Molecular Repair Mask',   'k18-leave-in-molecular-repair-mask',   'K18',                 'Patented four-minute mask that reverses damage from colour and heat.',         1150000, 'assets/img/shop/p9.jpg', 0, 9);

-- Extra gallery images (2 per product) for the product-detail thumbnails.
INSERT INTO product_images (product_id, image_url, sort_order) VALUES
(1,'assets/img/shop/p1-2.jpg',1),(1,'assets/img/shop/p1-3.jpg',2),
(2,'assets/img/shop/p2-2.jpg',1),(2,'assets/img/shop/p2-3.jpg',2),
(3,'assets/img/shop/p3-2.jpg',1),(3,'assets/img/shop/p3-3.jpg',2),
(4,'assets/img/shop/p4-2.jpg',1),(4,'assets/img/shop/p4-3.jpg',2),
(5,'assets/img/shop/p5-2.jpg',1),(5,'assets/img/shop/p5-3.jpg',2),
(6,'assets/img/shop/p6-2.jpg',1),(6,'assets/img/shop/p6-3.jpg',2),
(7,'assets/img/shop/p7-2.jpg',1),(7,'assets/img/shop/p7-3.jpg',2),
(8,'assets/img/shop/p8-2.jpg',1),(8,'assets/img/shop/p8-3.jpg',2),
(9,'assets/img/shop/p9-2.jpg',1),(9,'assets/img/shop/p9-3.jpg',2);

-- A sample order so the dashboard isn't empty (safe to delete).
INSERT INTO orders (ref, customer_name, customer_phone, customer_email, address, fulfillment, note, item_count, total, status, created_at) VALUES
('ECL-0001','Putri Andini','081234567890','putri@example.com','Jl. Senopati No. 12, Jakarta Selatan','delivery','Tolong dibungkus rapi ya','3',1490000,'new','2026-06-18 14:32:00');

INSERT INTO order_items (order_id, product_id, product_name, brand, unit_price, qty, line_total) VALUES
(1,1,'No.3 Hair Perfector','Olaplex',450000,2,900000),
(1,5,'OI Oil','Davines',590000,1,590000);

INSERT INTO promotions (title, detail, cta_label, cta_url, is_active, sort_order) VALUES
('20% off your first colour', 'New guests save 20% on any colour service with a master colourist this season.', 'Book now', '/book', 1, 1);

INSERT INTO gift_vouchers (code, amount, purchaser, recipient, created_at) VALUES
('ECLAT-GIFT-DEMO', 500000, 'Demo Purchaser', 'Demo Recipient', '2026-06-01 12:00:00');
