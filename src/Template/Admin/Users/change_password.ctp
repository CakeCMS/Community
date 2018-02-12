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

$user = $this->get('user');

ToolbarHelper::save();
ToolbarHelper::cancel(null, [
    'action' => 'edit',
    $user->id
]);

echo $this->Form->create($user, ['jsForm' => true, 'class' => 'jsUserAddForm']);
?>
<div class="row">
    <div class="col s8">
        <?php
        echo $this->Form->control('password', [
            'label' => __d('community', 'Password'),
        ]);
        echo $this->Form->control('password_confirm', [
            'type'  => 'password',
            'label' => __d('community', 'Confirm password'),
        ]);
        ?>
    </div>
</div>
<?php echo $this->Form->end();
