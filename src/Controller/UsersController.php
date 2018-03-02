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

namespace Community\Controller;

use Core\Event\EventManager;
use Community\Model\Entity\User;
use Community\Model\Table\UsersTable;
use Cake\Network\Exception\BadRequestException;

/**
 * Class UsersController
 *
 * @package     Community\Controller
 * @property    UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Activation user profile action.
     *
     * @param   null|int $id            User id.
     * @param   null|string $token      User activation token.
     * @return  \Cake\Http\Response|null
     */
    public function activate($id = null, $token = null)
    {
        $user = $this->_getUser($id, $token);

        if ($user === null) {
            throw new BadRequestException(__d('community', 'User was not found'));
        }

        if ($user->status) {
            $this->Flash->error(__d(
                'community',
                '«{0}», you have already activated your profile before.',
                sprintf('<strong>%s</strong>', $user->name)
            ));
        } else {
            $user
                ->set('token', null)
                ->set('status', true);

            $result = $this->Users->save($user);
            if ($result) {
                EventManager::trigger('Controller.Users.successActivate', $this, ['user' => $result]);
                $this->Flash->success(__d(
                    'community',
                    '«{0}», you profile has been activate successfully.',
                    sprintf('<strong>%s</strong>', $user->name)
                ));
            } else {
                $this->Flash->error(__d(
                    'community',
                    'An error has occurred. Please, try again.',
                    sprintf('<strong>%s</strong>', $user->name)
                ));
            }
        }

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Login action.
     *
     * @return void
     */
    public function login()
    {
    }

    /**
     * Setup password action.
     *
     * @param   null|int $id        User id.
     * @param   null|string $token  User activation token.
     * @return  \Cake\Http\Response|null
     */
    public function setupPassword($id = null, $token = null)
    {
        $user = $this->_getUser($id, $token);

        if ($user === null) {
            throw new BadRequestException(__d('community', 'User was not found'));
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $entity = $this->Users->patchEntity($user, $this->request->getData());
            if ($user->status) {
                $entity->set('token', null);
            }

            /** @var User $result */
            $result = $this->Users->save($user);
            if ($result) {
                $this->Flash->success(__d(
                    'community',
                    '«{0}», You have successfully changed your password.',
                    sprintf('<strong>%s</strong>', $user->get('name'))
                ));

                if (!$user->status && $result->token !== null) {
                    return $this->redirect([
                        'action' => 'activate',
                        $user->id,
                        $user->token
                    ]);
                }

                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__d('community', 'An error has occurred. Please, try again.'));
            }
        }

        $this
            ->set('user', $user)
            ->set('page_title', __d('community', 'Setup new password'));
    }

    /**
     * Get user by id and activation token.
     *
     * @param   int $id         User id.
     * @param   string $token   User activation token.
     * @return  array|User|null
     */
    private function _getUser($id, $token)
    {
        return $this->Users->find()
            ->where([
                'id'    => $id,
                'token' => $token
            ])
            ->first();
    }
}
