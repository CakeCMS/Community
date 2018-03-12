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
 * @var         \Core\View\AppView $this
 */

echo $this->Form->create();
?>
<div class="row">
    <div class="col s12">
        <p class="center">Authorization</p>
    </div>
</div>
<?php
echo $this->Form->control('login', [
    'before' => 'icon:user'
]);
echo $this->Form->control('password', [
    'before' => 'icon:lock'
]);
?>
<div class="row">
    <?php
    echo $this->Form->button(__d('community', 'Login'), [
        'button' => true,
        'class'  => 'col s12 pink lighten-1',
        'icon'   => 'sign-in-alt'
    ]);
    ?>
</div>
<div class="row">
    <div class="input-field col s6 m6 l6">
        <p class="margin medium-small">
            <?php
            echo $this->Html->link(__d('community', 'Register Now!'), [
                'prefix'     => false,
                'action'     => 'add',
                'controller' => 'Users',
                'plugin'     => 'Community'
            ]);
            ?>
        </p>
    </div>
    <div class="input-field col s6 m6 l6">
        <p class="margin right-align medium-small">
            <?php
            echo $this->Html->link(__d('community', 'Forgot password ?'), [
                'prefix'     => false,
                'controller' => 'Users',
                'action'     => 'forgot',
                'plugin'     => 'Community'
            ]);
            ?>
        </p>
    </div>
</div>
<?php
echo $this->Form->end();
