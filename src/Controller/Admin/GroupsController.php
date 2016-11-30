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

namespace Community\Controller\Admin;

use Community\Model\Entity\Group;
use Community\Model\Table\GroupsTable;
use Core\Controller\Component\MoveComponent;
use Core\Controller\Component\ProcessComponent;

/**
 * Class GroupsController
 *
 * @package Community\Controller\Admin
 * @property GroupsTable $Groups
 * @property MoveComponent $Move
 * @property ProcessComponent $Process
 */
class GroupsController extends AppController
{

    /**
     * Edit action.
     *
     * @return mixed
     */
    public function add()
    {
        $group = $this->Groups->newEntity();
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($result = $this->Groups->save($group)) {
                $this->Flash->success(__d('community', 'The group has been saved.'));
                return $this->App->redirect([
                    'apply' => ['action' => 'edit', $result->id],
                ]);
            } else {
                $this->Flash->error(__d('community', 'The group could not be saved. Please, try again.'));
            }
        }

        $parents = $this->Groups->getTreeList();
        $this->set(compact('group', 'parents'));
        $this->set('page_title', __d('community', 'Add new group'));
    }

    /**
     * Move down group action.
     *
     * @param int $id
     * @return \Cake\Network\Response|null
     */
    public function down($id)
    {
        return $this->Move->down($this->Groups, $id);
    }

    /**
     * Edit action.
     *
     * @param int $id
     * @return \Cake\Network\Response|null
     */
    public function edit($id)
    {
        /** @var Group $group */
        $group = $this->Groups->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($result = $this->Groups->save($group)) {
                $this->Flash->success(__d('community', 'The group has been updated.'));
                return $this->App->redirect([
                    'apply' => ['action' => 'edit', $result->id],
                ]);
            } else {
                $this->Flash->error(__d('community', 'The group could not be updated. Please, try again.'));
            }
        }

        $parents = $this->Groups->getTreeList();
        $this->set(compact('group', 'parents'));
        $this->set('page_title', __d('community', 'Edit group: {0}', $group->name));
    }

    /**
     * Index action.
     *
     * @return void
     */
    public function index()
    {
        $this->set('groups', $this->Groups->getTreeList());
        $this->set('page_title', __d('community', 'User group list'));
    }

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Move->config('messages', [
            'success' => __d('community', 'Group has been moved'),
            'error'   => __d('community', 'Group could not been moved')
        ]);
    }

    /**
     * Process action.
     *
     * @return \Cake\Network\Response|null
     */
    public function process()
    {
        list($action, $ids) = $this->Process->getRequestVars($this->name);
        return $this->Process->make($this->Groups, $action, $ids);
    }

    /**
     * Move up group action.
     *
     * @param int $id
     * @return \Cake\Network\Response|null
     */
    public function up($id)
    {
        return $this->Move->up($this->Groups, $id);
    }
}
