# ÉCLAT — image guide

Every image the site uses lives in this folder. Right now each file is a **dark
placeholder** so nothing renders broken. Replace any file with a real photo
**using the exact same filename** and it appears automatically — no code or
database changes (the `?v=` cache-buster updates itself from the file date).

All sizes are *minimum* guides — bigger is fine, keep the aspect ratio roughly
the same. Export as JPG, quality ~80, and try to keep each file under ~400 KB.

## Where to get free, commercial-use photos
- **Unsplash** — https://unsplash.com  (search, download, free for commercial use)
- **Pexels** — https://pexels.com
- **Freepik** (Indonesian-friendly, some free) — https://freepik.com

Tip: dark/editorial shots suit the theme best. After downloading, you can drag
each onto https://squoosh.app to shrink it before uploading.

---

## Team portraits — `team/` · 640×800 (portrait, 4:5)
Indonesian portraits, ideally clean/studio or salon background. Search Unsplash/
Pexels for the terms below.

| File | Person / role | Suggested search |
|------|---------------|------------------|
| `team/1.jpg` | Dewi Anggraini — Founder & Creative Director (woman) | "indonesian woman portrait professional" |
| `team/2.jpg` | Sari Wijaya — Master Colourist (woman) | "asian woman hairstylist portrait" |
| `team/3.jpg` | Reza Pratama — Senior Stylist (man) | "indonesian man portrait professional" |
| `team/4.jpg` | Putri Maharani — Master Stylist (woman) | "asian woman portrait studio" |
| `team/5.jpg` | Nadia Kusuma — Colour Specialist (woman) | "indonesian woman portrait smiling" |
| `team/6.jpg` | Bayu Saputra — Senior Barber (man) | "asian man barber portrait" |
| `team/7.jpg` | Maya Hartono — Bridal Specialist (woman) | "indonesian woman portrait elegant" |
| `team/8.jpg` | Arif Setiawan — Stylist (man) | "asian man portrait casual professional" |

## Gallery / lookbook — `gallery/` · 900×1100 (portrait, ~3:4)
Generic professional hair photography is fine here. The `*b.jpg` files are the
"before" shots for the drag-to-reveal — just use a different hair photo.

| File | Look | Suggested search |
|------|------|------------------|
| `gallery/g1.jpg` + `gallery/g1b.jpg` | Bronde balayage (after + before) | "balayage hair", "brunette hair before" |
| `gallery/g2.jpg` | Soft copper melt | "copper hair colour" |
| `gallery/g3.jpg` + `gallery/g3b.jpg` | Blunt bob (after + before) | "blunt bob haircut", "long hair before" |
| `gallery/g4.jpg` | Bridal half-up | "bridal hairstyle" |
| `gallery/g5.jpg` + `gallery/g5b.jpg` | Platinum blonde (after + before) | "platinum blonde hair", "dark hair before" |
| `gallery/g6.jpg` | Evening updo | "updo hairstyle" |
| `gallery/g7.jpg` | Textured crop + fade | "men textured crop fade" |
| `gallery/g8.jpg` | Long layered restyle | "long layered hair" |
| `gallery/g9.jpg` | Honey balayage | "honey balayage" |
| `gallery/g10.jpg` | Natural curls | "curly hair styling" |
| `gallery/g11.jpg` | Brunette gloss | "glossy brunette hair" |
| `gallery/g12.jpg` | Gentleman's cut | "men classic haircut" |

## Page backgrounds — `hero/` · 1920×1000 (1920×1200 for home)
These sit behind a dark overlay + headline, so moody salon/interior shots work
well (faces optional).

| File | Page | Suggested search |
|------|------|------------------|
| `hero/home-hero.jpg` (1920×1200) | Home hero | "luxury hair salon interior dark" |
| `hero/about-hero.jpg` | About | "hair salon interior" |
| `hero/services-hero.jpg` | Services | "hairdresser tools styling" |
| `hero/gallery-hero.jpg` | Gallery | "hairstyle editorial dark" |
| `hero/book-hero.jpg` | Book | "salon chair interior" |

## Other — `home/`, `about/`, `cta/`
| File | Used for | Size | Suggested search |
|------|----------|------|------------------|
| `home/intro.jpg` | "About the house" teaser | 900×1100 | "salon interior detail" |
| `about/story-1.jpg` | About story (tall) | 900×1200 | "stylist at work" |
| `about/story-2.jpg` | About story (wide) | 1200×750 | "salon detail wide" |
| `cta/cta.jpg` | Booking banner background | 1600×800 | "hair salon dark moody" |
| `hero/faq-hero.jpg` | FAQ page background | 1920×1000 | "salon reception calm" |

## Shop — `shop/` · 600×600 (square) + `hero/shop-hero.jpg` (1920×1000)
Product packshots — ideally the real product on a plain/dark background. Most
brands provide press images, or shoot them on the salon shelf.

| File | Product |
|------|---------|
| `hero/shop-hero.jpg` | Shop page background — "haircare products shelf" |
| `shop/p1.jpg` | Olaplex No.3 Hair Perfector |
| `shop/p2.jpg` | Olaplex No.4 Shampoo |
| `shop/p3.jpg` | Kérastase Bain Satin Shampoo |
| `shop/p4.jpg` | Kérastase Nutritive Hair Mask |
| `shop/p5.jpg` | Davines OI Oil |
| `shop/p6.jpg` | Oribe Gold Lust Repair Shampoo |
| `shop/p7.jpg` | Wella Oil Reflections |
| `shop/p8.jpg` | Redken Acidic Bonding Concentrate |
| `shop/p9.jpg` | K18 Leave-In Molecular Repair Mask |

Each product also has a small gallery on its detail page: `shop/pN-2.jpg` and
`shop/pN-3.jpg` (600×600) are the extra thumbnails — swap them for more shots of
the same product, or add rows to the `product_images` table for more.

## Article (blog) — `blog/` · 1200×700 covers + `hero/blog-hero.jpg` (1920×1000)
| File | Post |
|------|------|
| `hero/blog-hero.jpg` | Article index background — "salon editorial" |
| `blog/c1.jpg` | How to make your balayage last longer |
| `blog/c2.jpg` | The five-minute routine for healthier hair |
| `blog/c3.jpg` | Choosing a fringe for your face shape |
| `blog/c4.jpg` | This season we are loving warm brunettes |
| `blog/c5.jpg` | Planning your bridal hair |

Post bodies are HTML in the `posts.body` column — ready for a Quill editor later.
