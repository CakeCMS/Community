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

use Cake\ORM\TableRegistry;
use Community\Model\Entity\Group;
use Test\Cases\IntegrationTestCase;

/**
 * Class GroupsTableTest
 *
 * @package Community\Test\TestCase\Model\Table
 */
class GroupsTableTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.community.groups'];

    protected $_corePlugin = 'Community';


    public function testClassName()
    {
        self::assertInstanceOf('Community\Model\Table\GroupsTable', $this->_getTable());
        self::assertSame(CMS_TABLE_GROUPS, $this->_getTable()->getTable());
    }

    /**
     * @throws \Aura\Intl\Exception
     */
    public function testDefaultValidation()
    {
        $table  = $this->_getTable();
        $entity = $table->newEntity([]);

        self::assertSame([
            'name' => [
                '_required' => __d('community', 'This field is required')
            ],
            'slug' => [
                '_required' => __d('community', 'This field is required')
            ]
        ], $entity->getErrors());
        self::assertFalse($table->save($entity));

        $entity = $table->newEntity([
            'name' => 'Test'
        ]);
        
        self::assertSame([
            'slug' => [
                '_required' => __d('community', 'This field is required')
            ]
        ], $entity->getErrors('slug'));
        self::assertFalse($table->save($entity));

        $entity = $table->newEntity([
            'name' => 'Registered',
            'slug' => 'registered',
        ]);

        self::assertSame([
            'slug' => [
                'unique' => __d('community', 'Group with this slug already exists.')
            ]
        ], $entity->getErrors('slug'));
        self::assertFalse($table->save($entity));
    }

    public function testSuccessSave()
    {
        $table  = $this->_getTable();
        $entity = $table->newEntity([
            'name'   => 'Moderator',
            'slug'   => 'moderator',
            'params' => [
                'label'       => 'Site moderator',
                'description' => 'Moderator description param'
            ]
        ]);

        /** @var Group $result */
        $result = $table->save($entity);

        self::assertInstanceOf('Community\Model\Entity\Group', $result);
        self::assertSame('Moderator', $result->name);
        self::assertSame('moderator', $result->slug);
        self::assertInstanceOf('JBZoo\Data\JSON', $result->params);
        self::assertInstanceOf('JBZoo\Data\JSON', $result->get('params'));
        self::assertSame('Site moderator', $result->params->get('label'));
        self::assertSame('Moderator description param', $result->params->get('description'));
    }

    /**
     * Get table object.
     *
     * @param null|string $name
     * @return \Cake\ORM\Table
     */
    protected function _getTable($name = 'Groups')
    {
        return TableRegistry::getTableLocator()->get($this->_corePlugin . '.' . $name);
    }
}
