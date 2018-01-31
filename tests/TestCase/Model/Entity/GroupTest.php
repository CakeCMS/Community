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

use Test\Cases\TestCase;
use Cake\ORM\TableRegistry;
use Community\Model\Entity\Group;

/**
 * Class GroupTest
 *
 * @package Community\Test\TestCase\Model\Entity
 */
class GroupTest extends TestCase
{

    public $fixtures = ['plugin.community.groups'];

    protected $_corePlugin = 'Community';

    public function testClassName()
    {
        $entity = new Group();
        $table  = TableRegistry::get('Community.Groups');
        $group  = $table->get(1)->toArray();

        self::assertArrayHasKey('id',        $group);
        self::assertArrayHasKey('lft',       $group);
        self::assertArrayHasKey('rght',      $group);
        self::assertArrayHasKey('name',      $group);
        self::assertArrayHasKey('slug',      $group);
        self::assertArrayHasKey('params',    $group);
        self::assertArrayHasKey('parent_id', $group);

        self::assertInstanceOf($table->getEntityClass(), $entity);
    }
}
