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
 * Class ExtensionsFixture
 *
 * @package Community\Test\Fixture
 */
class ExtensionsFixture extends TestFixture
{

    /**
     * Full Table Name
     *
     * @var string
     */
    public $table = 'extensions';

    /**
     * Fields / Schema for the fixture.
     *
     * @var array
     */
    public $fields = [
        'id'            => ['type' => 'integer', 'length' => 11],
        'name'          => ['type' => 'string', 'length' => 150],
        'type'          => ['type' => 'string',  'length' => 20],
        'ordering'      => ['type' => 'integer', 'default' => 0],
        'slug'          => ['type' => 'string', 'length' => 150],
        'core'          => ['type' => 'integer', 'default' => 0],
        'status'        => ['type' => 'integer', 'default' => 0],
        'params'        => 'text',
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
                'id'        => 1,
                'name'      => 'Extensions',
                'type'      => 'plugin',
                'ordering'  => 0,
                'slug'      => 'extensions',
                'core'      => 1,
                'status'    => 1,
                'params'    => json_encode([], JSON_PRETTY_PRINT),
            ],
            [
                'id'        => 2,
                'name'      => 'Community',
                'type'      => 'plugin',
                'ordering'  => 0,
                'slug'      => 'community',
                'core'      => 1,
                'status'    => 1,
                'params'    => json_encode([
                    'msg_account_create_subject'    => 'Create profile subject.',
                    'msg_account_create_msg'        => '{name}, account created.',
                    'msg_account_activate_subject'  => 'Activate profile subject.',
                    'msg_account_activate_msg'      => '{name}, account activated',
                ], JSON_PRETTY_PRINT),
            ],
            [
                'id'        => 3,
                'name'      => 'Core',
                'type'      => 'plugin',
                'ordering'  => 0,
                'slug'      => 'core',
                'core'      => 1,
                'status'    => 1,
                'params'    => json_encode([
                    'admin_email' => 'admin@email.net'
                ], JSON_PRETTY_PRINT),
            ],
        ];

        parent::init();
    }
}
