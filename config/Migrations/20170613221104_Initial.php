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

use Migrations\AbstractMigration;

/**
 * Class Initial
 */
class Initial extends AbstractMigration
{

    /**
     * Whether the tables created in this migration
     * should auto-create an `id` field or not
     *
     * This option is global for all tables created in the migration file.
     * If you set it to false, you have to manually add the primary keys for your
     * tables using the Migrations\Table::addPrimaryKey() method
     *
     * @var bool
     */
    public $autoId = false;

    /**
     * Migrate Up.
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function up()
    {
        /** @var \Migrations\Table $table */
        $this->table('groups')
            ->addColumn('id', 'integer', [
                'limit'         => 11,
                'autoIncrement' => true,
                'default'       => null,
                'null'          => false,
                'signed'        => false
            ])
            ->addPrimaryKey([
                'id'
            ])
            ->addColumn('parent_id', 'integer', [
                'limit'     => 10,
                'default'   => null,
                'null'      => true
            ])
            ->addColumn('name', 'string', [
                'limit'     => 100,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('slug', 'string', [
                'limit'     => 100,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('params', 'text', [
                'default'   => null,
                'limit'     => null,
                'null'      => true
            ])
            ->addColumn('lft', 'integer', [
                'limit'     => 10,
                'default'   => null,
                'null'      => true
            ])
            ->addColumn('rght', 'integer', [
                'limit'     => 10,
                'default'   => null,
                'null'      => true
            ])
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'limit'         => 11,
                'autoIncrement' => true,
                'default'       => null,
                'null'          => false,
                'signed'        => false
            ])
            ->addPrimaryKey([
                'id'
            ])
            ->addColumn('group_id', 'integer', [
                'limit'     => 10,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('login', 'string', [
                'limit'     => 60,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('name', 'string', [
                'limit'     => 60,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('slug', 'string', [
                'limit'     => 60,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('email', 'string', [
                'limit'     => 50,
                'default'   => null,
                'null'      => false
            ])
            ->addColumn('password', 'string', [
                'limit'     => 100,
                'default'   => null,
                'null'      => true
            ])
            ->addColumn('token', 'string', [
                'limit'     => 60,
                'default'   => null,
                'null'      => true,
            ])
            ->addColumn('status', 'boolean', [
                'limit'     => null,
                'default'   => false,
                'null'      => false
            ])
            ->addColumn('params', 'text', [
                'default'   => null,
                'limit'     => null,
                'null'      => true
            ])
            ->addColumn('last_login', 'datetime', [
                'limit'     => null,
                'null'      => true,
                'default'   => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('last_action', 'datetime', [
                'limit'     => null,
                'null'      => true,
                'default'   => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('modified', 'datetime', [
                'limit'     => null,
                'null'      => true,
                'default'   => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('created', 'datetime', [
                'limit'     => null,
                'null'      => true,
                'default'   => 'CURRENT_TIMESTAMP'
            ])
            ->create();
    }

    /**
     * Migrate down.
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable('groups');
        $this->dropTable('users');
    }
}
