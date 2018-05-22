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

namespace Community\Model\Table;

use Cake\ORM\Query;
use Core\ORM\Table;
use Core\Event\EventManager;
use Cake\Validation\Validator;
use Community\Model\Entity\User;
use Cake\Datasource\EntityInterface;

/**
 * Class UsersTable
 *
 * @method      filterParams(array $query = [])
 * @method      User get($primaryKey, $options = [])
 * @property    GroupsTable $Groups
 *
 * @package     Community\Model\Table
 */
class UsersTable extends Table
{

    /**
     * Initialize a table instance. Called after the constructor.
     *
     * @param   array $config Configuration options passed to the constructor.
     * @return  void
     *
     * @throws  \RuntimeException
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this
            ->setPrimaryKey('id')
            ->setTable(CMS_TABLE_USERS)
            ->setDisplayField('name');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->addAssociations([
            'belongsTo' => [
                'Groups' => [
                    'foreignKey' => 'group_id',
                    'className'  => 'Community.Groups'
                ]
            ]
        ]);
    }

    /**
     * Persists an entity based on the fields that are marked as dirty and
     * returns the same entity after a successful save or false in case
     * of any error.
     *
     * @param   \Cake\Datasource\EntityInterface $entity the entity to be saved
     * @param   array|\ArrayAccess $options The options to use when saving.
     * @return  \Cake\Datasource\EntityInterface|false
     */
    public function save(EntityInterface $entity, $options = [])
    {
        EventManager::trigger('Model.User.beforeSave', $this, [
            'user' => $entity
        ]);

        $success = parent::save($entity, $options);

        EventManager::trigger('Model.User.afterSave', $this, [
            'user'    => $entity,
            'success' => $success
        ]);

        return $success;
    }

    /**
     * Default validation rules.
     *
     * @param   Validator $validator The validator that can be modified to add some rules to it.
     * @return  Validator
     *
     * @throws  \Aura\Intl\Exception
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('login', 'create')
            ->notEmpty('login', __d('community', 'Login could not be empty.'))
            ->add('login', 'unique', [
                'provider' => 'table',
                'rule'     => 'validateUnique',
                'message'  => __d('community', 'User with this login already exists.')
            ])
            ->add('login', 'length', [
                'rule'    => ['minLength', MIN_LENGTH_LOGIN],
                'message' => __d('community', 'The minimum login length must be {0} characters', MIN_LENGTH_LOGIN)
            ]);

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug', __d('community', 'Alias could not be empty.'))
            ->add('slug', 'unique', [
                'provider' => 'table',
                'rule'     => 'validateUnique',
                'message'  => __d('community', 'User with this alias already exists.')
            ])
            ->add('slug', 'length', [
                'rule'    => ['minLength', MIN_LENGTH_LOGIN],
                'message' => __d('community', 'The minimum alias length must be {0} characters', MIN_LENGTH_LOGIN)
            ]);

        $validator
            ->requirePresence('group_id', 'create')
            ->notEmpty('group_id', __d('community', 'Please, choose user group.'))
            ->notEmpty('name', __d('community', 'Please, enter you full name.'));

        $validator
            ->notEmpty('email', __d('community', 'Please, enter you email.'))
            ->add('email', 'unique', [
                'provider' => 'table',
                'rule'     => 'validateUnique',
                'message'  => __d('community', 'User with this email already exists.')
            ])
            ->add('email', 'valid', [
                'rule'    => 'email',
                'message' => __d('community', 'Please enter valid email.')
            ]);

        $validator
            ->notEmpty('password', __d('community', 'Please, enter you password.'))
            ->add('password', 'minLength', [
                'rule'    => ['minLength', MIN_LENGTH_PASS],
                'message' => __d('community', 'The minimum password length is {0}', MIN_LENGTH_PASS)
            ]);

        $validator
            ->notEmpty('password_confirm', __d('community', 'Please, confirm you password.'))
            ->add('password_confirm', 'no-misspelling', [
                'rule'    => ['compareWith', 'password'],
                'message' => __d('community', 'Passwords are not equal')
            ]);

        return $validator;
    }

    /**
     * Find auth user.
     *
     * @param   Query $query
     * @param   array $options
     *
     * @return  \Cake\ORM\Query
     */
    public function findAuth(Query $query, array $options)
    {
        return $query->where(['Users.status' => 1]);
    }
}
