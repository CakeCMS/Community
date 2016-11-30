<?php
/**
 * CakeCMS Community
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Community
 * @license   MIT
 * @copyright MIT License http://www.opensource.org/licenses/mit-license.php
 * @link      https://github.com/CakeCMS/Community".
 * @author    Sergey Kalistratov <kalistratov.s.m@gmail.com>
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
     * @param array $options
     * @return \Cake\ORM\Query
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
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->table(CMS_TABLE_GROUPS);
        $this->primaryKey('id');
        $this->displayField('name');
        $this->addBehavior('Tree');
        $this->addAssociations([
            'belongsTo' => [
                'ParentGroup' => [
                    'className'  => 'Community.Group',
                    'foreignKey' => 'parent_id',
                ]
            ],
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
