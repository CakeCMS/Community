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

namespace Community\Test\TestCase;

use Cake\Utility\Hash;
use Test\Cases\IntegrationTestCase;
use Community\Controller\Admin\UsersController;

/**
 * Class UsersControllerTest
 *
 * @package Community\Test\TestCase
 * @property UsersController|null $_controller
 */
class UsersControllerTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.community.users'];

    protected $_corePlugin = 'Community';

    public function setUp()
    {
        parent::setUp();
        $this->_url = $this->_getUrl([
            'prefix'     => 'admin',
            'controller' => 'Users',
            'plugin'     => $this->_corePlugin
        ]);
    }

    public function testAddFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $url = $this->_getUrl([
            'action' => 'add'
        ]);
        $this->post($url, $this->_getData());

        $this->assertNoRedirect();
        $this->assertResponseSuccess();
        $this->assertResponseContains(__d('community', 'User could not be updated. Please, try again.'));
    }

    public function testAddSuccess()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $url = $this->_getUrl([
            'action' => 'add'
        ]);

        $this->post($url, $this->_getData([
            'login'            => 'tester',
            'name'             => 'tester',
            'slug'             => 'tester',
            'email'            => 'tester@gmail.com',
            'password'         => '123456',
            'password_confirm' => '123456',
            'action'           => 'save'
        ]));

        $this->assertResponseSuccess();
        $this->assertRedirect([
            'prefix'     => 'admin',
            'plugin'     => 'Community',
            'controller' => 'Users',
            'action'     => 'index'
        ]);
    }

    /**
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function testProcessSuccessDelete()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $url = $this->_getUrl([
            'action' => 'process'
        ]);

        $this->post($url, [
            'user' => [
                1 => [
                    'id' => 1
                ]
            ],
            'action' => 'delete'
        ]);

        $this->assertRedirect([
            'prefix'     => 'admin',
            'plugin'     => 'Community',
            'controller' => 'Users',
            'action'     => 'index'
        ]);

        $this->_controller->Users->get(1);
    }

    protected function _getData(array $data = [])
    {
        return Hash::merge([
            'id'          => 1,
            'group_id'    => GROUP_ADMIN,
            'login'       => '',
            'name'        => '',
            'slug'        => '',
            'email'       => '',
            'password'    => '',
            'token'       => '',
            'status'      => 0,
            'params'      => '',
            'last_login'  => '0000-00-00 00:00:00',
            'last_action' => '0000-00-00 00:00:00',
            'modified'    => '0000-00-00 00:00:00',
            'created'     => '0000-00-00 00:00:00'
        ], $data);
    }
}
