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
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Class GroupsTable
 *
 * @package Community\Model\Table
 */
class GroupsTable extends Table
{

    /**
     * Get tree group list.
     *
     * @param   array $options  Behavior tree options.
     *                          See https://book.cakephp.org/3.0/ru/orm/behaviors/tree.html
     * @return  \Cake\ORM\Query
     */
    public function getTreeList(array $options = [])
    {
        $options = Hash::merge([
            'lft'    => 'ASC',
            'spacer' => '|—',
        ], $options);

        return $this->find('treeList', $options);
    }

    /**
     * Initialize a table instance. Called after the constructor.
     *
     * @param   array $config Configuration options passed to the constructor.
     * @return  void
     * @throws  \RuntimeException
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this
            ->setPrimaryKey('id')
            ->setTable(CMS_TABLE_GROUPS)
            ->setDisplayField('name');

        $this->addBehavior('Tree');
        $this->addAssociations([
            'belongsTo' => [
                'ParentGroup' => [
                    'foreignKey' => 'parent_id',
                    'className'  => 'Community.Group'
                ]
            ],
            'hasMany' => [
                'Users' => [
                    'dependent' => true,
                    'className' => 'Community.Users',
                ]
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param   Validator $validator The validator that can be modified to add some rules to it.
     * @return  Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('name')
            ->notEmpty(
                'name',
                __d('community', 'Group name could not be empty.')
            )

            ->requirePresence('slug')
            ->notEmpty(
                'slug',
                __d('community', 'Group slug could not be empty.')
            )
            ->add('slug', 'unique', [
                'message'  => __d('community', 'Group with this slug already exists.'),
                'rule'     => 'validateUnique',
                'provider' => 'table',
            ]);

        return $validator;
    }
}
