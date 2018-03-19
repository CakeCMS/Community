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

namespace Community\Controller\Component;

use Cake\Controller\Component\AuthComponent as BaseAuthComponent;

/**
 * Class AuthComponent
 *
 * @package Community\Controller\Component
 */
class AuthComponent extends BaseAuthComponent
{

    /**
     * Get login redirect by app client.
     *
     * @return  array
     */
    protected function _getLoginRedirect()
    {
        $redirect = [
            'action'     => 'index',
            'controller' => 'Users',
            'plugin'     => 'Community'
        ];

        if (!$this->request->getParam('prefix')) {
            $redirect = [
                'controller' => 'Users',
                'action'     => 'profile',
                'plugin'     => 'Community'
            ];
        }
        return $redirect;
    }

    /**
     * Sets defaults for configs.
     *
     * @return  void
     */
    protected function _setDefaults()
    {
        $defaults = [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Users',
                    'scope'     => ['Users.status' => 1],
                    'fields'    => [
                        'username' => 'login',
                        'password' => 'password'
                    ]
                ]
            ],
            'flash' => [
                'key'       => 'auth',
                'element'   => 'error',
                'params'    => ['class' => 'error']
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action'     => 'login',
                'plugin'     => 'Community'
            ],
            'unauthorizedRedirect' => [
                'action'     => 'login',
                'controller' => 'Users',
                'plugin'     => 'Community'
            ],
            'authorize'      => ['Community.Base'],
            'loginRedirect'  => $this->_getLoginRedirect(),
            'logoutRedirect' => $this->_config['loginAction'],
            'authError'      => __d('community', 'You are not authorized to access that location.')
        ];

        $config = $this->getConfig();
        foreach ($config as $key => $value) {
            if ($value !== null) {
                unset($defaults[$key]);
            }
        }

        $this->setConfig($defaults);
    }
}
