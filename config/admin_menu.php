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

use Core\Nav;

Nav::add('sidebar', 'profiles', [
    'weight'   => 20,
    'url'      => '#',
    'icon'     => 'user',
    'title'    =>__d('community', 'Profiles'),
    'children' => [

        'list' => [
            'url' => [
                'controller' => 'Users',
                'action'     => 'index',
                'plugin'     => 'Community'
            ],
            'weight' => 10,
            'title'  => __d('community', 'Users')
        ],

        'types' => [
            'url' => [
                'controller' => 'Groups',
                'action'     => 'index',
                'plugin'     => 'Community'
            ],
            'weight' => 20,
            'title'  => __d('community', 'Groups')
        ],

        'params' => [
            'url' => [
                'action'     => 'config',
                'controller' => 'Plugins',
                'plugin'     => 'Extensions',
                'community'
            ],
            'weight' => 30,
            'title'  => __d('community', 'Params')
        ]

    ]
]);
