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

namespace Community\Test\TestCase;

use Cake\ORM\TableRegistry;
use Community\Model\Entity\Group;
use Community\Model\Table\GroupsTable;
use Community\Controller\Admin\GroupsController;
use Test\App\TestCase\AppControllerTest as IntegrationTestCase;

/**
 * Class GroupsControllerTest
 *
 * @package Community\Test\TestCase
 */
class GroupsControllerTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.community.groups'];

    protected $_corePlugin = 'Community';

    protected $_data = [
        'params'    => '',
        'parent_id' => null,
        'action'    => 'save',
        'name'      => 'Custom',
        'slug'      => 'custom'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->_url = $this->_getUrl([
            'prefix'     => 'admin',
            'controller' => 'Groups',
            'plugin'     => $this->_corePlugin,
        ]);
    }

    public function testAddFailed()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'add']);

        $this->_data['slug'] = 'admin';
        $this->post($url, [
            'params'    => '',
            'parent_id' => null,
            'action'    => 'save',
            'name'      => 'Custom',
            'slug'      => 'admin'
        ]);

        $this->assertNoRedirect();
        $this->assertResponseSuccess();
        $this->assertResponseContains(__d('community', 'The group could not be saved. Please, try again.'));
    }

    public function testAddResponseSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'add']);
        $this->get($url);
        $this->assertResponseOk();
    }

    public function testAddSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'add']);

        $this->post($url, $this->_data);
        $this->assertRedirect([
            'prefix'     => 'admin',
            'plugin'     => $this->_corePlugin,
            'controller' => 'Groups',
            'action'     => 'index',
        ]);
    }

    public function testDown()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $id  = 2;
        $url = $this->_getUrl(['action' => 'down', $id]);

        /** @var GroupsTable $table */
        $table  = TableRegistry::get('Community.Groups');
        /** @var Group $entity */
        $entity = $table->get($id);

        self::assertSame(2, $entity->lft);
        self::assertSame(3, $entity->rght);

        $this->get($url);
        /** @var GroupsController $controller */
        $controller = $this->_controller;
        /** @var Group $entity */
        $entity = $controller->Groups->get($id);

        self::assertSame(4, $entity->lft);
        self::assertSame(5, $entity->rght);
    }

    public function testEditFail()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'edit', 2]);

        $this->post($url);
        $this->assertNoRedirect();
        $this->assertResponseSuccess();
        $this->assertResponseContains(__d('community', 'The group could not be updated. Please, try again.'));
    }

    public function testEditResponseSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'edit', 2]);

        $this->get($url);
        $this->assertNoRedirect();
        $this->assertResponseSuccess();
    }

    public function testEditSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'edit', 2]);

        $this->post($url, [
            'id'        => 2,
            'parent_id' => 1,
            'name'      => 'Registered',
            'slug'      => 'registered-update',
        ]);

        $this->assertRedirect([
            'prefix'     => 'admin',
            'plugin'     => $this->_corePlugin,
            'controller' => 'Groups',
            'action'     => 'index',
        ]);
    }

    public function testIndexSuccess()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'index']);
        $this->get($url);
        $this->assertResponseOk();
    }

    /**
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function testProcessDelete()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $url = $this->_getUrl(['action' => 'process']);
        $data = [
            'group' => [
                1 => [
                    'id' => 0
                ],
                2 => [
                    'id' => 1
                ]
            ],
            'action' => 'delete'
        ];

        $this->post($url, $data);

        $this->assertRedirect([
            'prefix'     => 'admin',
            'plugin'     => 'Community',
            'controller' => 'Groups',
            'action'     => 'index'
        ]);

        /** @var GroupsController $controller */
        $controller = $this->_controller;
        $controller->Groups->get(2);
    }

    public function testUp()
    {
        $this
            ->enableCsrfToken()
            ->enableSecurityToken()
            ->_setAuthUserData();

        $id  = 3;
        $url = $this->_getUrl(['action' => 'up', $id]);

        /** @var GroupsTable $table */
        $table  = TableRegistry::get('Community.Groups');
        /** @var Group $entity */
        $entity = $table->get($id);

        self::assertSame(4, $entity->lft);
        self::assertSame(5, $entity->rght);

        $this->get($url);
        /** @var GroupsController $controller */
        $controller = $this->_controller;
        /** @var Group $entity */
        $entity = $controller->Groups->get($id);

        self::assertSame(2, $entity->lft);
        self::assertSame(3, $entity->rght);
    }
}
