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

return [
    'meta' => [
        'name'        => 'Community',
        'author'      => 'Cheren',
        'version'     => '0.0.1',
        'copyright'   => 'CakePHP CMS',
        'license'     => 'MIT',
        'email'       => 'kalistratov.s.m@gmail.com',
        'url'         => 'http://cool-code.ru',
        'description' => 'Community plugin for UnionCMS',
        'core'        => true
    ],
    'events' => [
        'Community.UserEventHandler',
    ],
    'params' => [
        'Messages' => [
            'msg_account_create_subject' => [
                'type'    => 'text',
                'label'   => __d('community', 'Message subject'),
                'default' => __d('community', 'Account activation')
            ]
        ]
    ]
];
