<?php

// Alias to the long PHP Dir Separator.
defined('DS') ?: define('DS', DIRECTORY_SEPARATOR);

// Library's root directory
defined('ROOT_DIR') ?: define('ROOT_DIR', __DIR__ . DS . '..');

// library's main directories hierarchy
return [
    'resources_dir' => ROOT_DIR . DS . 'resources',
    'sources_dir' => ROOT_DIR . DS . 'src',
    'vendor_dir' => ROOT_DIR . DS . 'vendor',
];