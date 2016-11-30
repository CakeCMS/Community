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
 * @var       \App\View\AppView $this
 */

use Core\Toolbar\ToolbarHelper;

ToolbarHelper::apply();
ToolbarHelper::save();
ToolbarHelper::cancel();

$group = $this->get('group');

echo $this->Form->create($group, ['jsForm' => true]);
?>
<div class="row">
    <div class="col s6">
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('parent_id', [
            'label' => __d('community', 'Parent role'),
            'empty' => __d('community', 'Select parent role'),
        ]);
        echo $this->Form->input('name', [
            'label' => __d('core', 'Title'),
        ]);
        echo $this->Form->input('slug', [
            'label' => __d('core', 'Alias'),
        ]);
        ?>
    </div>
</div>
<?php echo $this->Form->end();
