<?php
/**
 * Bootstrap — the one place that wires everything together.
 * Loads config, the database accessor, helpers, then every model file.
 */
declare(strict_types=1);

require dirname(__DIR__) . '/config/config.php';  // defines ROOT_PATH, APP_PATH, …
require APP_PATH . '/database.php';
require APP_PATH . '/helpers.php';

foreach (glob(APP_PATH . '/models/*.php') as $model) {
    require $model;
}
