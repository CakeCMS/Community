<?php
/**
 * CakeCMS Community
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Community
 * @license   MIT
 * @copyright MIT License http://www.opensource.org/licenses/mit-license.php
 * @link      https://github.com/CakeCMS/Community".
 * @author    Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

use Core\Nav;

Nav::add('sidebar', 'profiles', [
    'title' =>__d('community', 'Profiles'),
    'weight'=> 20,
    'icon' => 'user',
    'url' => '#',
    'children' => [
        'list' => [
            'title' => __d('community', 'List of users'),
            'weight' => 10,
            'url' => [
                'plugin' => 'Community',
                'controller' => 'Users',
                'action' => 'index',
            ]
        ],
        'types' => [
            'title' => __d('community', 'Groups'),
            'weight' => 20,
            'url' => [
                'plugin' => 'Community',
                'controller' => 'Groups',
                'action' => 'index',
            ]
        ]
    ]
]);
