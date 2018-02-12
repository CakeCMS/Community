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

use Core\ORM\Table;
use Cake\Validation\Validator;
use Community\Model\Entity\User;

/**
 * Class UsersTable
 *
 * @package Community\Model\Table
 * @method filterParams(array $query = [])
 * @method User get($primaryKey, $options = [])
 * @property GroupsTable $Groups
 */
class UsersTable extends Table
{

    /**
     * Initialize a table instance. Called after the constructor.
     *
     * @param array $config
     * @return void
     * @throws \RuntimeException
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
     * Default validation rules.
     *
     * @param Validator $validator
     * @return Validator
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
}
