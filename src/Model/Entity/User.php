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

namespace Community\Model\Entity;

use Cake\I18n\FrozenTime;
use Core\ORM\Entity\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Class User
 *
 * @package Community\Model\Entity
 * @property int $id
 * @property int $group_id
 * @property Group $group
 * @property string $login
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string $password
 * @property string $token
 * @property bool $status
 * @property FrozenTime $last_login
 * @property FrozenTime $last_action
 * @property FrozenTime $modified
 * @property FrozenTime $created
 */
class User extends Entity
{

    /**
     * Setup password.
     *
     * @param string $password
     * @return null|string
     */
    protected function _setPassword($password)
    {
        if ($password !== null) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return null;
    }
}
