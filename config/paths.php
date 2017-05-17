<?php

// Alias to the long PHP Dir Separator.
!defined('DS') ?: defined('DS', DIRECTORY_SEPARATOR);

// Library's root directory
!defined('ROOT_DIR') ?: defined('ROOT_DIR', __DIR__ . '..');

// library's main directories hierarchy
return [
    'resources_dir' => ROOT_DIR . DS . 'resources',
    'sources_dir' => ROOT_DIR . DS . 'src',
    'vendor_dir' => ROOT_DIR . DS . 'vendor',
];