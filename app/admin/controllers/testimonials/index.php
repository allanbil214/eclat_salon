<?php
render_admin('testimonials/index', ['title' => 'Testimonials', 'active' => 'testimonials', 'rows' => get_all_testimonials()]);
