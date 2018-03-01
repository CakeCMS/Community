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

namespace Community\Event;

use Cake\Event\Event;
use JBZoo\Utils\Filter;
use Community\Notify\Email;
use Community\Model\Entity\User;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventListenerInterface;

/**
 * Class UserEventHandler
 *
 * @package Community\Event
 */
class UserEventHandler implements EventListenerInterface
{

    /**
     * Returns a list of events this object is implementing.
     *
     * @return  array
     */
    public function implementedEvents()
    {
        return [
            'Model.User.afterSave'             => 'onModelAfterSave',
            'Model.User.beforeSave'            => 'onModelBeforeSave',
            'Controller.Users.successActivate' => 'onSuccessActivate'
        ];
    }

    /**
     * On success user activation profile.
     *
     * @param Event $event
     *
     * @return void
     */
    public function onSuccessActivate(Event $event)
    {
    }

    /**
     * Global before save user data.
     *
     * @param   Event $event
     *
     * @return  void
     */
    public function onModelBeforeSave(Event $event)
    {
        /** @var User $user */
        $user = $event->getData('user');
    }

    /**
     * Global after save user data.
     *
     * @param   Event $event
     *
     * @return  void
     *
     * TODO : Use return when send message?
     */
    public function onModelAfterSave(Event $event)
    {
        /** @var User|bool $user */
        $user = $event->getData('user');

        if ($user instanceof EntityInterface) {
            if ($user->isNew() && Filter::bool($user->get('notify'))) {
                $this->_getMailer($user)->sendCreateMessage();
            }
        }
    }

    /**
     * Get mailer object.
     *
     * @param   EntityInterface $entity
     * @return  Email
     */
    protected function _getMailer(EntityInterface $entity)
    {
        return new Email($entity);
    }
}
