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

namespace Community\Test\TestCase\Model\Entity;

use Cake\Routing\Router;
use Test\Cases\TestCase;
use Community\Model\Entity\User;
use Community\Model\Table\UsersTable;

/**
 * Class UserTest
 *
 * @package Community\Test\TestCase\Model\Entity
 */
class UserTest extends TestCase
{

    public $fixtures = ['plugin.community.users'];

    protected $_corePlugin = 'Community';

    public function testClassName()
    {
        $entity = new User();
        $table  = $this->_getTable('Users');
        $user   = $table->get(1)->toArray();

        self::assertArrayHasKey('id',           $user);
        self::assertArrayHasKey('name',         $user);
        self::assertArrayHasKey('slug',         $user);
        self::assertArrayHasKey('email',        $user);
        self::assertArrayHasKey('login',        $user);
        self::assertArrayHasKey('token',        $user);
        self::assertArrayHasKey('status',       $user);
        self::assertArrayHasKey('params',       $user);
        self::assertArrayHasKey('created',      $user);
        self::assertArrayHasKey('password',     $user);
        self::assertArrayHasKey('group_id',     $user);
        self::assertArrayHasKey('modified',     $user);
        self::assertArrayHasKey('last_login',   $user);
        self::assertArrayHasKey('last_action',  $user);

        self::assertInstanceOf($table->getEntityClass(), $entity);
    }

    public function testGetEditUrl()
    {
        /** @var UsersTable $table */
        $table  = $this->_getTable('Users');

        $userId = 1;
        $user   = $table->get($userId);

        self::assertSame($user->getEditUrl(), Router::url([
            'action'     => 'edit',
            'controller' => 'Users',
            'plugin'     => 'Community'
        ]));

        self::assertSame($user->getEditUrl(true), Router::url([
            'action'     => 'edit',
            'prefix'     => 'admin',
            'controller' => 'Users',
            'plugin'     => 'Community',
            $userId
        ]));
    }
}
