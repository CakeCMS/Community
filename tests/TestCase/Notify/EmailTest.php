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

namespace Community\Test\TestCase\Notify;

use Core\Plugin;
use Test\Cases\TestCase;
use Community\Notify\Email;
use Community\Model\Table\UsersTable;

/**
 * Class EmailTest
 *
 * @package Community\Test\TestCase\Notify
 */
class EmailTest extends TestCase
{

    protected $_corePlugin = 'Community';

    public $fixtures = [
        'plugin.community.users',
        'plugin.community.extensions'
    ];

    public function setUp()
    {
        parent::setUp();
        Plugin::load('Extensions', ['autoload' => true, 'bootstrap' => true]);
    }

    public function tearDown()
    {
        parent::tearDown();
        Plugin::unload('Extensions');
    }

    public function testActivationMessage()
    {
        /** @var UsersTable $table */
        $table = $this->_getTable('Users');
        $user  = $table->get(1);

        $user->set('name', 'Tester sender');

        $mailer = new Email($user);
        $result = $mailer->sendActivationMessage();

        self::assertTrue(is_array($result));
        self::assertArrayHasKey('headers', $result);
        self::assertArrayHasKey('message', $result);

        self::assertRegExp('/From: admin@email.net/', (string) $result['headers']);
        self::assertRegExp('/<title>Activate profile subject.<\/title>/', (string) $result['message']);
        self::assertRegExp('/' . $user->name . ', account activated/', (string) $result['message']);
    }

    public function testCreateMessage()
    {
        /** @var UsersTable $table */
        $table = $this->_getTable('Users');
        $user  = $table->get(1);

        $user->set('name', 'Tester sender');

        $mailer = new Email($user);
        $result = $mailer->sendCreateMessage();

        self::assertTrue(is_array($result));
        self::assertArrayHasKey('headers', $result);
        self::assertArrayHasKey('message', $result);

        self::assertRegExp('/From: admin@email.net/', (string) $result['headers']);
        self::assertRegExp('/<title>Create profile subject.<\/title>/', (string) $result['message']);
        self::assertRegExp('/' . $user->name . ', account created/', (string) $result['message']);
    }
}
