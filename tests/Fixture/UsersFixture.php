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

namespace Community\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * Class UsersFixture
 *
 * @package Community\Test\Fixture
 */
class UsersFixture extends TestFixture
{

    /**
     * Full Table Name
     *
     * @var string
     */
    public $table = 'users';

    /**
     * Fields / Schema for the fixture.
     *
     * @var array
     */
    public $fields = [
        'id'            => ['type' => 'integer', 'length' => 11],
        'group_id'      => ['type' => 'integer', 'null' => true, 'length' => 10],
        'login'         => ['type' => 'string', 'length' => 60],
        'name'          => ['type' => 'string', 'length' => 60],
        'slug'          => ['type' => 'string',  'length' => 60],
        'email'         => ['type' => 'string', 'length' => 50],
        'password'      => ['type' => 'string', 'length' => 100],
        'token'         => ['type' => 'string', 'length' => 60],
        'status'        => ['type' => 'integer', 'default' => 0],
        'params'        => 'text',
        'last_login'    => ['type' => 'datetime', 'default' => '0000-00-00 00:00:00'],
        'last_action'   => ['type' => 'datetime', 'default' => '0000-00-00 00:00:00'],
        'modified'      => ['type' => 'datetime', 'default' => '0000-00-00 00:00:00'],
        'created'       => ['type' => 'datetime', 'default' => '0000-00-00 00:00:00'],
        '_constraints'  => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];

    /**
     * Initialize the fixture.
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id'          => 1,
                'group_id'    => GROUP_ADMIN,
                'login'       => 'admin',
                'name'        => 'admin',
                'slug'        => 'admin',
                'email'       => 'admin@test.ru',
                'password'    => '1234',
                'token'       => '',
                'status'      => 1,
                'params'      => '',
                'last_login'  => '0000-00-00 00:00:00',
                'last_action' => '0000-00-00 00:00:00',
                'modified'    => '0000-00-00 00:00:00',
                'created'     => '0000-00-00 00:00:00'
            ]
        ];

        parent::init();
    }
}
