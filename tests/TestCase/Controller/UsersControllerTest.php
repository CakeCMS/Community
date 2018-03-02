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

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Community\Model\Entity\User;
use Core\Plugin;
use Test\Cases\IntegrationTestCase;
use Community\Controller\UsersController;

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
            'controller' => 'Users',
            'plugin'     => $this->_corePlugin
        ]);

        unset($this->_url['prefix']);

        Plugin::routes($this->_corePlugin);
    }

    public function testActivateUserActivated()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

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

    public function testActivateUserSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

        $userId = 2;
        $table  = TableRegistry::get('Community.Users');

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

    public function testActivationNotFindUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken();

        $userId = 1111;
        $url    = $this->_getUrl(['action' => 'activate', $userId, 33333]);

        $this->get($url);
        $this->assertResponseError(__d('community', 'User was not found'));
    }

    public function testSetupPasswordActiveUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

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

    public function testSetupPasswordNotActivateUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

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

    public function testSetupPasswordNotFindUser()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken();

        $url = $this->_getUrl(['action' => 'setupPassword', 111, 'token']);

        $this->get($url);
        $this->assertResponseError(__d('community', 'User was not found'));
    }

    public function testSetupPasswordNotSave()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->enableRetainFlashMessages();

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
}
