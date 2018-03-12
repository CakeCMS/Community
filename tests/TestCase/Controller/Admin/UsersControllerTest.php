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

namespace Community\Test\TestCase\Controller\Admin;

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Community\Model\Entity\User;
use Community\Controller\Admin\UsersController;
use Test\App\TestCase\AppControllerTest as IntegrationTestCase;

/**
 * Class UsersControllerTest
 *
 * @package     Community\Test\TestCase
 * @property    UsersController|null $_controller
 */
class UsersControllerTest extends IntegrationTestCase
{

    public $fixtures = [
        'plugin.community.users',
        'plugin.community.groups',
    ];

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
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'add']);
        $this->post($url, $this->_getData());

        $this->assertNoRedirect();
        $this->assertResponseSuccess();
        $this->assertResponseContains(__d('community', 'User could not be updated. Please, try again.'));
    }

    public function testAddSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'add']);

        $this->post($url, $this->_getData([
            'action'           => 'save',
            'password'         => '123456',
            'password_confirm' => '123456',
            'login'            => 'new-user',
            'name'             => 'new-user',
            'slug'             => 'new-user',
            'email'            => 'new-user@mail.com'
        ]));

        $this->assertResponseSuccess();
        $this->assertRedirect([
            'prefix'     => 'admin',
            'controller' => 'Users',
            'action'     => 'index',
            'plugin'     => 'Community'
        ]);
    }

    public function testAddSuccessNotify()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'add']);

        $this->post($url, $this->_getData([
            'notify'           => 1,
            'action'           => 'save',
            'password'         => '123456',
            'password_confirm' => '123456',
            'login'            => 'user-notify',
            'name'             => 'user-notify',
            'slug'             => 'user-notify',
            'email'            => 'new-user-notify@mail.com'
        ]));

        $this->assertResponseSuccess();
        $this->assertRedirect([
            'prefix'     => 'admin',
            'controller' => 'Users',
            'action'     => 'index',
            'plugin'     => 'Community'
        ]);

        /** @var User $user */
        $user = $this->_controller->Users->findByLogin('user-notify')->first();
        self::assertNotNull($user->token);
    }

    public function testEditFail()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 2;
        $url    = $this->_getUrl(['action' => 'edit', $userId]);

        $table = TableRegistry::get('Community.Users');
        /** @var User $user */
        $user = $table->get($userId);

        self::assertSame('tester', $user->name);

        $this->post($url, [
            'action'           => 'save',
            'id'               => $userId,
            'login'            => 'new-user',
            'name'             => 'new-user',
            'slug'             => 'new-user',
            'email'            => 'new-user@mail.com',
            'password'         => ''
        ]);

        $this->assertSession(
            __d('community', 'User could not be updated. Please, try again.'),
            'Flash.flash.0.message'
        );

        self::assertTrue(is_array($this->_controller->viewVars));
        self::assertArrayHasKey('user', $this->_controller->viewVars);
        self::assertArrayHasKey('groups', $this->_controller->viewVars);
        self::assertArrayHasKey('page_title', $this->_controller->viewVars);

        self::assertSame(
            __d('community', 'Profiles: Edit user - {0}', 'new-user'),
            $this->viewVariable('page_title')
        );
    }

    public function testEditSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 2;
        $url    = $this->_getUrl(['action' => 'edit', $userId]);

        $table = TableRegistry::get('Community.Users');
        /** @var User $user */
        $user = $table->get($userId);

        self::assertSame('tester', $user->name);

        $this->post($url, [
            'action'           => 'save',
            'id'               => $userId,
            'login'            => 'new-user',
            'name'             => 'new-user',
            'slug'             => 'new-user',
            'email'            => 'new-user@mail.com'
        ]);

        $this->assertResponseSuccess();

        $user = $this->_controller->Users->get($userId);

        self::assertSame($userId, $user->id);
        self::assertSame('new-user', $user->name);

        $this->assertRedirect([
            'prefix'     => 'admin',
            'controller' => 'Users',
            'action'     => 'index',
            'plugin'     => 'Community'
        ]);

        $this->assertSession(
            __d('community', 'The user {0} has been saved.', sprintf(
                '<strong>«%s»</strong>',
                $user->login
            )),
            'Flash.flash.0.message'
        );
    }

    public function testFailChangePassword()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $userId = 1;

        $url = $this->_getUrl(['action' => 'changePassword', $userId]);

        $this->post($url, [
            'action'            => 'save',
            'password'          => 111000,
            'password_confirm'  => 111111
        ]);

        $this->assertNoRedirect();
        $this->assertResponseSuccess();
        $this->assertResponseContains(__d('community', 'Password could not be updated. Please, try again.'));
    }

    public function testIndex()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'index']);
        $this->get($url);

        self::assertTrue(is_array($this->_controller->viewVars));
        self::assertArrayHasKey('page_title', $this->_controller->viewVars);
        self::assertArrayHasKey('users', $this->_controller->viewVars);

        self::assertSame(__d('community', 'Profiles: User list'), $this->_controller->viewVars['page_title']);
        self::assertInstanceOf('Cake\ORM\ResultSet', $this->_controller->viewVars['users']);
    }

    public function testLogin()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

        $url = $this->_getUrl(['action' => 'login']);

        $this->post($url, [
            'login'    => 'login',
            'password' => 'password'
        ]);

        $this->assertResponseOk();

        $this->assertSession(
            __d('community', 'Login or password is incorrect'),
            'Flash.flash.0.message'
        );

        self::assertTrue(is_array($this->_controller->viewVars));
        self::assertArrayHasKey('page_title', $this->_controller->viewVars);
        self::assertSame(__d('community', 'Authorize profile'), $this->_controller->viewVars['page_title']);

        $this->post($url, [
            'login'    => 'admin',
            'password' => '375210'
        ]);

        $this->assertRedirect([
            'prefix'     => 'admin',
            'action'     => 'index',
            'controller' => 'Users',
            'plugin'     => 'Community'
        ]);
    }

    public function testLogout()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'logout']);
        $this->get($url);

        $this->assertRedirect([
            'prefix'     => 'admin',
            'action'     => 'login',
            'controller' => 'Users',
            'plugin'     => 'Community'
        ]);
    }

    /**
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function testProcessSuccessDelete()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'process']);

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
            'controller' => 'Users',
            'action'     => 'index',
            'plugin'     => 'Community'
        ]);

        $this->_controller->Users->get(1);
    }

    public function testSuccessChangePassword()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $userId = 1;

        $url = $this->_getUrl(['action' => 'changePassword', $userId]);

        $this->post($url, [
            'action'            => 'save',
            'password'          => 111111,
            'password_confirm'  => 111111
        ]);

        $this->assertRedirect([
            'controller' => 'Users',
            'prefix'     => 'admin',
            'action'     => 'index',
            'plugin'     => 'Community'
        ]);
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
