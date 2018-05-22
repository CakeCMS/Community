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

namespace Community\Test\TestCase\Controller;

use Core\Plugin;
use Community\Model\Entity\User;
use Community\Controller\UsersController;
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
        'plugin.community.groups'
    ];

    protected $_corePlugin = 'Community';

    public function setUp()
    {
        parent::setUp();
        $this->_url = $this->_getUrl([
            'controller' => 'Users',
            'plugin'     => $this->_corePlugin
        ]);

        unset($this->_url['prefix']);

        $this->_useHttpServer = true;

        Plugin::routes($this->_corePlugin);
    }

    /**
     * @throws \Aura\Intl\Exception
     * @throws \PHPUnit\Exception
     */
    public function testActivateUserActivated()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 3;
        $url    = $this->_getUrl(['action' => 'activate', $userId, 33333]);

        $this->get($url);

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'login',
            'plugin'     => 'Community'
        ]);

        $this->assertSession(
            __d(
                'community',
                '«{0}», you have already activated your profile before.',
                sprintf('<strong>%s</strong>', 'tester3')
            ),
            'Flash.flash.0.message'
        );
    }

    /**
     * @throws \Aura\Intl\Exception
     * @throws \PHPUnit\Exception
     */
    public function testActivateUserSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 2;
        $table  = $this->_getTable('Users');

        /** @var User $user */
        $user = $table->get($userId);

        self::assertSame(0, $user->status);
        self::assertNotNull($user->token);

        $this->get($this->_getUrl(['action' => 'activate', $user->id, $user->token]));

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'login',
            'plugin'     => 'Community'
        ]);

        $this->assertSession(
            __d(
                'community',
                '«{0}», you profile has been activate successfully.',
                sprintf('<strong>%s</strong>', $user->name)
            ),
            'Flash.flash.0.message'
        );

        $user = $this->_controller->Users->get($user->id);

        self::assertSame(1, $user->status);
        self::assertNull($user->token);
    }

    /**
     * @throws \Aura\Intl\Exception
     * @throws \PHPUnit\Exception
     */
    public function testActivationNotFindUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 1111;
        $this->get($this->_getUrl(['action' => 'activate', $userId, 33333]));

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'login',
            'plugin'     => 'Community'
        ]);

        $this->assertSession(
            __d('community', 'User was not found'),
            'Flash.flash.0.message'
        );
    }

    /**
     * @throws \Aura\Intl\Exception
     * @throws \PHPUnit\Exception
     */
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
    }

    /**
     * @throws \PHPUnit\Exception
     */
    public function testLoginSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

        $url = $this->_getUrl(['action' => 'login']);

        $this->post($url, [
            'login'    => 'admin',
            'password' => '375210'
        ]);

        $this->assertRedirect([
            'prefix'     => false,
            'controller' => 'Users',
            'action'     => 'profile',
            'plugin'     => 'Community'
        ]);
    }

    /**
     * @throws \PHPUnit\Exception
     */
    public function testLogout()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'logout']);
        $this->get($url);

        $this->assertRedirect([
            'prefix'     => false,
            'action'     => 'login',
            'controller' => 'Users',
            'plugin'     => 'Community'
        ]);
    }

    /**
     * @throws \PHPUnit\Exception
     */
    public function testSetupPasswordActiveUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 3;
        $url    = $this->_getUrl(['action' => 'setupPassword', $userId, 33333]);

        $this->post($url, [
            'id'                => $userId,
            'password'          => 123456,
            'password_confirm'  => 123456
        ]);

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'login',
            'plugin'     => 'Community'
        ]);

        $this->assertSession(
            '«<strong>tester3</strong>», You have successfully changed your password.',
            'Flash.flash.0.message'
        );
    }

    /**
     * @throws \PHPUnit\Exception
     */
    public function testSetupPasswordNotActivateUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 2;
        $url    = $this->_getUrl(['action' => 'setupPassword', $userId, 22222]);

        $this->post($url, [
            'id'                => 2,
            'password'          => 123456,
            'password_confirm'  => 123456
        ]);

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'activate',
            'plugin'     => 'Community',
            $userId,
            22222
        ]);
    }

    /**
     * @throws \Aura\Intl\Exception
     * @throws \PHPUnit\Exception
     */
    public function testSetupPasswordNotFindUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'setupPassword', 111, 'token']);

        $this->get($url);

        $this->assertSession(
            __d('community', 'User was not found'),
            'Flash.flash.0.message'
        );

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'login',
            'plugin'     => 'Community'
        ]);
    }

    /**
     * @throws \Aura\Intl\Exception
     * @throws \PHPUnit\Exception
     */
    public function testSetupPasswordNotSave()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages()
            ->_setAuthUserData();

        $userId = 2;
        $url    = $this->_getUrl(['action' => 'setupPassword', $userId, 22222]);

        $this->post($url, [
            'id'                => 2,
            'password'          => 12345,
            'password_confirm'  => 123456
        ]);

        $this->assertResponseOk();

        $this->assertSession(
            __d('community', 'An error has occurred. Please, try again.'),
            'Flash.flash.0.message'
        );

        self::assertSame(__d('community', 'Setup new password'), $this->_controller->viewVars['page_title']);
        self::assertInstanceOf('Community\Model\Entity\User', $this->_controller->viewVars['user']);
    }

    /**
     * @throws \PHPUnit\Exception
     */
    public function testProfile()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $this->get($this->_getUrl(['action' => 'profile']));

        self::assertTrue(is_array($this->_controller->viewVars));
        self::assertArrayHasKey('user', $this->_controller->viewVars);
        self::assertArrayHasKey('page_title', $this->_controller->viewVars);
    }

    /**
     * @throws \PHPUnit\Exception
     */
    public function testProfileNotAuth()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken();

        $this->session([
            'Auth' => [
                'User' => []
            ]
        ]);

        $this->get($this->_getUrl(['action' => 'profile']));

        $this->assertRedirect([
            'controller' => 'Users',
            'action'     => 'login',
            'plugin'     => 'Community',
            'redirect'   => '/profile/profile'
        ]);
    }
}
