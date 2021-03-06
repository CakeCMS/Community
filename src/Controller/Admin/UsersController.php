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

namespace Community\Controller\Admin;

use Community\Token;
use JBZoo\Utils\Filter;
use Community\Model\Entity\User;
use Community\Model\Table\UsersTable;
use Community\Controller\Component\AuthComponent;
use Cake\ORM\Exception\RolledbackTransactionException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;

/**
 * Class UsersController
 *
 * @package     Community\Controller\Admin
 *
 * @property    AuthComponent $Auth
 * @property    UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Add action.
     *
     * @return  \Cake\Http\Response|null
     *
     * @throws  \Aura\Intl\Exception
     * @throws  \Cake\ORM\Exception\RolledbackTransactionException
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if (Filter::bool($user->get('notify'))) {
                $user->set('token', Token::generate());
            }

            $result = $this->Users->save($user);
            if ($result) {
                $this->Flash->success(__d('community', 'The user {0} has been saved.', sprintf(
                    '<strong>«%s»</strong>',
                    $result->get('login')
                )));

                return $this->App->redirect(['apply' => ['action' => 'edit', $result->id]]);
            } else {
                $this->Flash->error(__d('community', 'User could not be updated. Please, try again.'));
            }
        }

        $groups = $this->Users->Groups->getTreeList();

        $this
            ->set(compact('user', 'groups'))
            ->set('page_title', __d('community', 'Profiles: Add new user'));
    }

    /**
     * Change user password action.
     *
     * @param   null|int $id User id.
     * @return  \Cake\Http\Response|null
     *
     * @throws  \Aura\Intl\Exception
     */
    public function changePassword($id = null)
    {
        $user = $this->Users->get($id, ['contain' => []]);
        $user->set('password', null);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($result = $this->Users->save($user)) {
                $this->Flash->success(__d('community', 'Password has been updated.'));
                return $this->App->redirect(['apply' => ['action' => 'edit', $result->id]]);
            } else {
                $this->Flash->error(__d('community', 'Password could not be updated. Please, try again.'));
            }
        }

        $this
            ->set(compact('user'))
            ->set('page_title', __d('community', 'Profiles: {0} - change password', $user->name));
    }

    /**
     * Edit action.
     *
     * @param   null|int $id User id.
     * @return  \Cake\Http\Response|null
     *
     * @throws  \Aura\Intl\Exception
     * @throws  RecordNotFoundException
     * @throws  InvalidPrimaryKeyException
     * @throws  RolledbackTransactionException
     */
    public function edit($id = null)
    {
        /** @var User $user */
        $user = $this->Users->get($id);
        $groups = $this->Users->Groups->getTreeList();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($result = $this->Users->save($user)) {
                $this->Flash->success(__d('community', 'The user {0} has been saved.', sprintf(
                    '<strong>«%s»</strong>',
                    $result->get('login')
                )));
                return $this->App->redirect([
                    'apply' => ['action' => 'edit', $result->id]
                ]);
            } else {
                $this->Flash->error(__d('community', 'User could not be updated. Please, try again.'));
            }
        }

        $this
            ->set(compact('user', 'groups'))
            ->set('page_title', __d('community', 'Profiles: Edit user - {0}', $user->name));
    }

    /**
     * Index action.
     *
     * @return  void
     *
     * @throws  \Aura\Intl\Exception
     * @throws  \RuntimeException
     */
    public function index()
    {
        $query = $this->Users
            ->find('search', $this->Users->filterParams($this->request->getQueryParams()))
            ->contain('Groups');

        $this
            ->set('users', $this->paginate($query))
            ->set('page_title', __d('community', 'Profiles: User list'));
    }

    /**
     * Initialization hook method. Implement this method to avoid having to overwrite the constructor and call parent.
     *
     * @return  void
     *
     * @throws  \JBZoo\Utils\Exception
     * @throws  \Cake\Core\Exception\Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->Security->setConfig('unlockedFields', ['password', 'password_confirm']);
    }

    /**
     * Login action.
     *
     * @return  \Cake\Http\Response|null
     *
     * @throws  \Aura\Intl\Exception
     */
    public function login()
    {
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user !== false) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error(__d('community', 'Login or password is incorrect'));
        }

        $this->set('page_title', __d('community', 'Authorize profile'));
    }

    /**
     * Logout action.
     *
     * @return  \Cake\Http\Response|null
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Process action.
     *
     * @return  \Cake\Http\Response|null
     *
     * @throws  \Aura\Intl\Exception
     */
    public function process()
    {
        list($action, $ids) = $this->Process->getRequestVars($this->name);
        return $this->Process->make($this->Users, $action, $ids);
    }
}
