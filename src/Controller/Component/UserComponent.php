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

use Cake\Event\Event;
use Core\Controller\Component\AppComponent;
use Core\Nav;

/**
 * Class UserComponent
 *
 * @package Community\Controller\Component
 */
class UserComponent extends AppComponent
{

    /**
     * Events supported by this component.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Controller.startup' => 'startup'
        ];
    }

    /**
     * Startup callback.
     *
     * @param   Event $event
     *
     * @throws  \Aura\Intl\Exception
     */
    public function startup(Event $event)
    {
        $prefix = $this->_controller->request->getParam('prefix');
        if ($prefix === 'admin' && $this->_controller->Auth->user('id')) {
            $this->_setupAdminProfileNavBar();
        }
    }

    /**
     * Setup profile nav bar for admin.
     *
     * @return  void
     *
     * @throws  \Aura\Intl\Exception
     */
    protected function _setupAdminProfileNavBar()
    {
        Nav::add('profile', 'profile', [
            'weight' => 10,
            'icon'   => 'user',
            'title'  => __d('community', 'My profile'),
            'url'    => [
                'action'     => 'edit',
                'controller' => 'Users',
                'plugin'     => 'Community',
                $this->_controller->Auth->user('id')
            ]
        ]);

        Nav::add('profile', 'logout', [
            'weight' => 100,
            'icon'   => 'sign-out-alt',
            'title'  => __d('community', 'Logout'),
            'url' => [
                'controller' => 'Users',
                'action'     => 'logout',
                'plugin'     => 'Community'
            ]
        ]);
    }
}
