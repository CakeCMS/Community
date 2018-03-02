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

use Phinx\Seed\AbstractSeed;

/**
 * Class GroupsSeed
 */
class GroupsSeed extends AbstractSeed
{

    /**
     * Table default records.
     *
     * @var array
     */
    public $records = [];

    /**
     * Run the seeder.
     *
     * @return  void
     */
    public function run()
    {
        $table = $this->table(CMS_TABLE_GROUPS);
        $table->insert($this->records)->save();
    }
}
