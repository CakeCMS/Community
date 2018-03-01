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
     * Setup password action.
     *
     * @param   null|int $id
     * @param   null|string $token
     * @return  \Cake\Http\Response|null
     */
    public function setupPassword($id = null, $token = null)
    {
        /** @var User $user */
        $user = $this->Users->find()
            ->where([
                'id'    => $id,
                'token' => $token
            ])
            ->first();

        if ($user === null) {
            throw new BadRequestException(__d('community', 'Invalid user id or token'));
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
                        'id'     => $user->id,
                        'action' => 'activate',
                        'token'  => $user->token
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
}
