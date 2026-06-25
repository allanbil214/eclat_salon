<?php
/**
 * Main layout. render() sets $view_file (the page template) and the
 * variables below come from the controller's data array.
 */
$title  = $title  ?? get_setting('site_name_full');
$meta   = $meta   ?? get_setting('tagline');
$css    = $css    ?? [];   // extra page stylesheets (names under /css)
$js     = $js     ?? [];   // extra page scripts (names under /js)
$active = $active ?? '';   // nav highlight key
$solid_header = $solid_header ?? false;   // themed header for pages without a dark hero

// Stylesheets are loaded in order: base → components → page.
$base_css = ['base/tokens', 'base/reset', 'base/typography'];
$component_css = [
    'components/layout', 'components/buttons', 'components/header',
    'components/hero', 'components/cards', 'components/interactions',
    'components/forms', 'components/cart', 'components/footer',
    'components/outlets',
];
// Core scripts run on every page.
$core_js = ['core/preloader', 'core/theme-toggle', 'core/nav', 'core/reveal', 'core/counters', 'core/accordion', 'core/cart'];
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= e(current_theme()) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($meta) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Manrope:wght@400..700&display=swap" rel="stylesheet">
    <link rel="icon"
      type="image/svg+xml"
      href="https://www.svgrepo.com/download/530645/scissors.svg">

    <?php foreach (array_merge($base_css, $component_css) as $sheet) echo css($sheet) . "\n    "; ?>
    <?php foreach ($css as $sheet) echo css('pages/' . $sheet) . "\n    "; ?>
</head>
<body>
    <div class="preloader" aria-hidden="true">
        <div class="mark"><?= e(get_setting('site_name')) ?><span class="dot">.</span></div>
    </div>

    <?php partial('header', ['active' => $active, 'solid' => $solid_header]); ?>

    <main id="main">
        <?php require $view_file; ?>
    </main>

    <?php partial('cart_drawer'); ?>
    <?php partial('footer'); ?>

    <?php foreach (array_merge($core_js, $js) as $script) echo js($script) . "\n    "; ?>
</body>
</html>
