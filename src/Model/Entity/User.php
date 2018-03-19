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

use Cake\Routing\Router;
use Cake\I18n\FrozenTime;
use Core\ORM\Entity\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Class User
 *
 * @package Community\Model\Entity
 *
 * @property int        $id
 * @property int        $group_id
 * @property Group      $group
 * @property string     $login
 * @property string     $name
 * @property string     $slug
 * @property string     $email
 * @property string     $password
 * @property string     $token
 * @property bool       $status
 * @property FrozenTime $last_login
 * @property FrozenTime $last_action
 * @property FrozenTime $modified
 * @property FrozenTime $created
 * @property string     activation_url  Virtual field.
 */
class User extends Entity
{

    /**
     * List of computed or virtual fields that **should** be included in JSON or array
     * representations of this Entity. If a field is present in both _hidden and _virtual
     * the field will **not** be in the array/json versions of the entity.
     *
     * @var array
     */
    protected $_virtual = [
        'activation_url',
        'setup_password_url'
    ];

    /**
     * Get current user edit profile url.
     *
     * @param   bool $backend   Backend or frontend point.
     * @return  string
     */
    public function getEditUrl($backend = false)
    {
        $url = [
            'action'     => 'edit',
            'controller' => 'Users',
            'plugin'     => 'Community'
        ];

        if ($backend) {
            $url['prefix'] = 'admin';
            $url[] = $this->id;
        }

        return Router::url($url);
    }

    /**
     * Set virtual field activation_url.
     *
     * @return  string
     */
    protected function _getActivationUrl()
    {
        return Router::url([
            'controller' => 'Users',
            'action'     => 'activate',
            'plugin'     => 'Community',
            $this->id,
            $this->token
        ], true);
    }

    /**
     * set virtual field setup_password_url
     *
     * @return string
     */
    protected function _getSetupPasswordUrl()
    {
        return Router::url([
            'controller' => 'Users',
            'plugin'     => 'Community',
            'action'     => 'setupPassword',
            $this->id,
            $this->token
        ], true);
    }

    /**
     * Setup password.
     *
     * @param   string $password    User password for create hashed.
     * @return  null|string
     */
    protected function _setPassword($password)
    {
        if ($password !== null) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return null;
    }
}
