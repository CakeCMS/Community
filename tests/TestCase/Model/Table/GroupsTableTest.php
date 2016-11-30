<?php
/**
 * CakeCMS Community
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Community
 * @license   MIT
 * @copyright MIT License http://www.opensource.org/licenses/mit-license.php
 * @link      https://github.com/CakeCMS/Community".
 * @author    Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

namespace Community\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Community\Model\Entity\Group;
use Community\Model\Table\GroupsTable;
use Core\TestSuite\IntegrationTestCase;

/**
 * Class GroupsTableTest
 *
 * @package Community\Test\TestCase\Model\Table
 */
class GroupsTableTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.community.groups'];
    protected $_plugin = 'Core';
    protected $_corePlugin = 'Community';

    public function testClassName()
    {
        $this->assertInstanceOf('Community\Model\Table\GroupsTable', $this->_getTable());
        $this->assertSame(CMS_TABLE_GROUPS, $this->_getTable()->table());
    }

    public function testDefaultValidation()
    {
        $table  = $this->_getTable();
        $entity = $table->newEntity([]);

        $this->assertSame([
            'name' => [
                '_required' => __d('community', 'This field is required')
            ],
            'slug' => [
                '_required' => __d('community', 'This field is required')
            ]
        ], $entity->errors());
        $this->assertFalse($table->save($entity));

        $entity = $table->newEntity([
            'name' => 'Test'
        ]);
        
        $this->assertSame([
            '_required' => __d('community', 'This field is required')
        ], $entity->errors('slug'));
        $this->assertFalse($table->save($entity));

        $entity = $table->newEntity([
            'name' => 'Registered',
            'slug' => 'registered',
        ]);

        $this->assertSame([
            'unique' => __d('community', 'Group with this slug already exists.')
        ], $entity->errors('slug'));
        $this->assertFalse($table->save($entity));
    }

    public function testSuccessSave()
    {
        $table  = $this->_getTable();
        $entity = $table->newEntity([
            'name' => 'Moderator',
            'slug' => 'moderator',
            'params' => [
                'label' => 'Site moderator',
                'description' => 'Moderator description param'
            ]
        ]);

        /** @var Group $result */
        $result = $table->save($entity);
        $this->assertInstanceOf('Community\Model\Entity\Group', $result);
        $this->assertSame('Moderator', $result->name);
        $this->assertSame('moderator', $result->slug);
        $this->assertInstanceOf('JBZoo\Data\JSON', $result->params);
        $this->assertInstanceOf('JBZoo\Data\JSON', $result->get('params'));
        $this->assertSame('Site moderator', $result->params->get('label'));
        $this->assertSame('Moderator description param', $result->params->get('description'));
    }

    /**
     * @return \Cake\ORM\Table|GroupsTable
     */
    protected function _getTable()
    {
        return TableRegistry::get('Community.Groups');
    }
}
