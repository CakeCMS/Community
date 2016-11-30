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

ToolbarHelper::add(__d('community', 'New group'));
ToolbarHelper::delete();

echo $this->Form->create(null, ['process' => true, 'jsForm' => true]);
?>
<table class="ckTableProcess striped highlight responsive-table jsProcessTable">
    <?php
    $tHeaders = $this->Html->tableHeaders([
        [$this->Form->checkAll() => ['class' => 'center ck-hide-label']],
        [__d('core', 'Id') => ['class' => 'center']],
        __d('community', 'Group name'),
        [__d('core', 'Actions') => ['class' => 'center']],
    ]);

    echo $this->Html->tag('thead', $tHeaders);

    $rows = [];
    foreach ($this->get('groups') as $id => $name) {
        $nameLink = $this->Html->link($name, ['action' => 'edit', $id], [
            'tooltip' => true,
            'title'   => __d('community', 'Edit group №{0}', $id),
        ]);

        $actions = [];
        $actions[] = $this->Html->link(null, ['action' => 'up', $id], [
            'icon'  => 'arrow-up',
            'title' => __d('community', 'Move up group: {0}', $id),
        ]);
        $actions[] = $this->Html->link(null, ['action' => 'down', $id], [
            'icon'  => 'arrow-down',
            'title' => __d('community', 'Move down group: {0}', $id),
        ]);

        $actions = $this->Html->div('ck-actions center', implode('', $actions));

        $rows[] = [
            [$this->Form->processCheck('group', $id), ['class' => 'center ck-hide-label']],
            [$id, ['class' => 'center']],
            $nameLink,
            $actions
        ];
    }
    echo $this->Html->tableCells($rows);
    ?>
</table>
<?php echo $this->Form->end();
