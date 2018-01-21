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
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Admin.Controller.User.Add.BeforeSave' => 'onAdminAddBeforeSave',
            'Admin.Controller.User.Add.AfterSave'  => 'onAdminAddAfterSave',
        ];
    }

    /**
     * On add user after save (ADMIN).
     *
     * @param Event $event
     */
    public function onAdminAddAfterSave(Event $event)
    {
    }

    /**
     * On add user before save (ADMIN).
     *
     * @param Event $event
     */
    public function onAdminAddBeforeSave(Event $event)
    {
    }
}
