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
 * @var       \Core\View\AppView $this
 * @var       \Community\Model\Entity\User $user
 */

use Core\Toolbar\ToolbarHelper;

ToolbarHelper::add(__d('community', 'New user'));
ToolbarHelper::delete();


echo $this->Form->create(null, ['process' => true, 'jsForm' => true]);
?>
<table class="ckTableProcess striped highlight responsive-table jsProcessTable">
    <?php
    $tHeaders = $this->Html->tableHeaders([
        [$this->Form->checkAll() => ['class' => 'center ck-hide-label']],
        [__d('core', 'Id') => ['class' => 'center']],
        $this->Paginator->sort('name'),
        $this->Paginator->sort('email'),
        [$this->Paginator->sort('status', __d('core', 'Status')) => ['class' => 'center']],
        __d('community', 'Group')
    ]);

    echo $this->Html->tag('thead', $tHeaders);

    $rows = [];
    foreach ($this->get('users') as $user) {
        $editLink = $this->Html->link($user->name, ['action' => 'edit', $user->id]);

        $rows[] = [
            [$this->Form->processCheck('user', $user->id), ['class' => 'center ck-hide-label']],
            [$user->id, ['class' => 'center']],
            $editLink,
            $user->email,
            [$this->Html->status($user->status), ['class' => 'center']],
            $user->group->name
        ];
    }
    echo $this->Html->tableCells($rows);
    ?>
</table>
<?php echo $this->Form->end();
