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

use Core\View\AppView;
use Cake\Controller\Controller;
use Community\Model\Entity\User;

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

    'Controller.initialize' => function (Controller $controller) {
        $controller->loadComponent('Community.Auth');
        if ($controller->request->getParam('prefix') === 'admin') {
            $controller->loadComponent('Community.User');
        }
    },

    'Controller.beforeFilter' => function (Controller $controller) {
        $user = new User((array) $controller->Auth->user());
        $controller->set('authorized', $user);
    },

    'params' => [
        'Messages' => [
            'separator' => function(AppView $view) {
                return $view->Html->tag('h4', __d('community', 'Create account message settings'), [
                    'ck-param-separator'
                ]);
            },
            'msg_account_create_subject' => [
                'type'    => 'text',
                'label'   => __d('community', 'Message create subject'),
                'default' => __d('community', 'Account created')
            ],
            'msg_account_create_msg' => [
                'type'    => 'textarea',
                'label'   => __d('community', 'Message create text'),
                'default' => __d('community', 'You account created')
            ],
            'separator-1' => function(AppView $view) {
                return $view->Html->tag('h4', __d('community', 'Activation account message settings'), [
                    'ck-param-separator'
                ]);
            },
            'msg_account_activate_subject' => [
                'type'    => 'text',
                'label'   => __d('community', 'Message activate subject'),
                'default' => __d('community', 'Account activation')
            ],
            'msg_account_activate_msg' => [
                'type'    => 'textarea',
                'label'   => __d('community', 'Message create text'),
                'default' => __d('community', 'Account activation')
            ],
        ]
    ]
];
