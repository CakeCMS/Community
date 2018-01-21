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

namespace Community\Test\TestCase\Model\Table;

use Test\Cases\TestCase;
use Cake\ORM\TableRegistry;
use Community\Model\Table\UsersTable;

/**
 * Class UsersTableTest
 *
 * @package Community\Test\TestCase\Model\Table
 */
class UsersTableTest extends TestCase
{

    public $fixtures = ['plugin.community.users'];

    protected $_corePlugin = 'Community';

    /**
     * @var UsersTable
     */
    protected $Users;

    public function setUp()
    {
        parent::setUp();
        $this->Users = TableRegistry::get('Community.Users');
    }

    public function testAliasValidate()
    {
        $data = [
            'login'    => 'tester',
            'group_id' => 2,
            'name'     => 'I Tester',
            'slug'     => ''
        ];

        $entity = $this->Users->newEntity($data);
        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            '_empty' => __d('community', 'Alias could not be empty.')
        ], $entity->getError('slug'));

        $data['slug'] = 'admin';
        $entity = $this->Users->newEntity($data);
        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'unique' => __d('community', 'User with this alias already exists.')
        ], $entity->getError('slug'));

        $data['slug'] = 'admn';
        $entity = $this->Users->newEntity($data);
        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'length' => __d('community', 'The minimum alias length must be {0} characters', MIN_LENGTH_LOGIN)
        ], $entity->getError('slug'));
    }

    public function testClassName()
    {
        self::assertInstanceOf('Community\Model\Table\UsersTable', $this->Users);
        self::assertSame(CMS_TABLE_USERS, $this->Users->getTable());
    }

    public function testEmailValidate()
    {
        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => 2,
            'name'     => 'Tester',
            'email'    => '',
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            '_empty' => __d('community', 'Please, enter you email.')
        ], $entity->getError('email'));

        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => 2,
            'name'     => 'Tester',
            'email'    => 'admin@test.ru',
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'unique' => __d('community', 'User with this email already exists.')
        ], $entity->getError('email'));

        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => 2,
            'name'     => 'Tester',
            'email'    => 'not@gmail',
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'valid' => __d('community', 'Please enter valid email.')
        ], $entity->getError('email'));
    }

    public function testGroupIdValidate()
    {
        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => ''
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            '_empty' => __d('community', 'Please, choose user group.')
        ], $entity->getError('group_id'));
    }

    public function testLoginValidate()
    {
        $entity = $this->Users->newEntity(['login' => '']);
        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            '_empty' => __d('community', 'Login could not be empty.')
        ], $entity->getError('login'));

        $entity = $this->Users->newEntity(['login' => 'admin']);
        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'unique' => __d('community', 'User with this login already exists.')
        ], $entity->getError('login'));

        $entity = $this->Users->newEntity(['login' => 'admn']);
        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'length' => __d(
                'community',
                'The minimum login length must be {0} characters', MIN_LENGTH_LOGIN
            )
        ], $entity->getError('login'));
    }

    public function testNameValidate()
    {
        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => 2,
            'name'     => '',
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            '_empty' => __d('community', 'Please, enter you full name.')
        ], $entity->getError('name'));
    }

    public function testPasswordConfirmValidate()
    {
        $entity = $this->Users->newEntity([
            'login'             => 'tester',
            'group_id'          => 2,
            'password'          => '123456',
            'password_confirm'  => '23456',
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'no-misspelling' => __d('community', 'Passwords are not equal')
        ], $entity->getError('password_confirm'));

        $entity = $this->Users->newEntity([
            'login'             => 'tester',
            'group_id'          => 2,
            'password'          => '123456',
            'password_confirm'  => '123456',
        ]);

        $this->Users->save($entity);
        self::assertSame([], $entity->getError('password_confirm'));
    }

    public function testPasswordValidate()
    {
        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => 2,
            'password' => ''
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            '_empty' => __d('community', 'Please, enter you password.')
        ], $entity->getError('password'));

        $entity = $this->Users->newEntity([
            'login'    => 'tester',
            'group_id' => 2,
            'password' => 'pwd'
        ]);

        $result = $this->Users->save($entity);
        self::assertFalse($result);
        self::assertSame([
            'minLength' => __d('community', 'The minimum password length is {0}', MIN_LENGTH_PASS)
        ], $entity->getError('password'));
    }
}
