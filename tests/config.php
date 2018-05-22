<?php
/**
 * CakeCMS Community
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     Community
 * @license     MIT
 * @copyright   MIT License http://www.opensource.org/licenses/mit-license.php
 * @link        https://github.com/CakeCMS/Community".
 * @author      Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;

//  Write test application config.
Configure::write('debug', true);
Configure::write('App', [
    'base'          => false,
    'dir'           => 'src',
    'jsBaseUrl'     => 'js/',
    'cssBaseUrl'    => 'css/',
    'imageBaseUrl'  => 'img/',
    'cacheDir'      => 'cache',
    'lessBaseUrl'   => 'less/',
    'wwwRoot'       => WWW_ROOT,
    'webroot'       => 'webroot',
    'namespace'     => 'Test\App',
    'fullBaseUrl'   => 'http://localhost',
    'encoding'      => env('APP_ENCODING', 'UTF-8'),
    'defaultLocale' => env('APP_DEFAULT_LOCALE', 'ru_RU'),
    'paths'         => [
        'plugins' => [
            TEST_APP_DIR . 'plugins' . DS,
            TEST_APP_DIR . 'themes' . DS
        ],
        'templates' => [
            APP . 'Template' . DS
        ],
        'locales' => [
            APP . 'Locale' . DS
        ]
    ],
]);

Configure::write('EmailTransport', [
    'default' => [
        'timeout'   => 30,
        'port'      => 25,
        'client'    => null,
        'tls'       => null,
        'className' => 'Mail',
        'username'  => 'user',
        'password'  => 'secret',
        'host'      => 'localhost'
    ]
]);

Configure::write('Email', [
    'default' => [
        'charset'       => 'utf-8',
        'headerCharset' => 'utf-8',
        'transport'     => 'default',
        'from'          => 'you@localhost'
    ]
]);

Configure::write('Theme', [
    'admin' => 'Backend',
    'site'  => 'Frontend'
]);

Configure::write('Session', ['defaults' => 'php']);

Cache::setConfig([
    '_cake_core_' => [
        'serialize' => true,
        'engine'    => 'File',
        'prefix'    => 'cms_core_'
    ],
    '_cake_model_' => [
        'serialize' => true,
        'engine'    => 'File',
        'prefix'    => 'cms_model_'
    ],
    '_cake_routes_' => [
        'className' => 'File',
        'prefix'    => 'myapp_cake_routes_',
        'path'      => CACHE,
        'serialize' => true,
        'duration'  => '+1 years',
        'url'       => env('CACHE_CAKEROUTES_URL', null),
    ]
]);
