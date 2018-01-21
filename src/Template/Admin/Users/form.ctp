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
 */

use Core\Toolbar\ToolbarHelper;

ToolbarHelper::apply();
ToolbarHelper::save();
ToolbarHelper::cancel();

$user = $this->get('user');

$this->Html->script('Community.admin/widget/form.js', ['block' => 'script_bottom']);
$this->Js->widget('.jsUserAddForm', 'JBZoo.UserAdminForm');

echo $this->Form->create($user, ['jsForm' => true, 'class' => 'jsUserAddForm']);
?>
    <div class="row">
        <div class="col s8">
            <?php
            echo $this->Form->control('id');
            echo $this->Form->control('group_id', [
                'label' => __d('community', 'User group'),
                'empty' => __d('community', '-=Choose user group=-')
            ]);
            echo $this->Form->control('login', [
                'label' => __d('community', 'Login'),
            ]);
            echo $this->Form->control('slug', [
                'label' => __d('community', 'Alias'),
            ]);
            echo $this->Form->control('name', [
                'label' => __d('community', 'Username'),
            ]);
            echo $this->Form->control('email', [
                'label' => __d('community', 'User email'),
            ]);
            echo $this->element('Community.Users/Form/password');
            ?>
        </div>
        <div class="col s4">
            <?php
            if ($this->request->getParam('action') === 'add') {
                echo $this->Form->switcher('notify', [
                    'class' => 'jsNotify',
                    'title' => __d('community', 'Send activation message'),
                ]);
            }
            echo $this->Form->switcher('status', [
                'class' => 'jsStatus',
                'title' => __d('community', 'User status')
            ])
            ?>
        </div>
    </div>
<?php echo $this->Form->end();
