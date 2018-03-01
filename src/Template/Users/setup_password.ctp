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

$user = $this->get('user');
?>
<div class="page-header">
    <h1 class="title">
        <?= $this->get('page_title') ?>
    </h1>
    <?php
    echo $this->Form->create($user);

    echo $this->Form->control('id');

    echo $this->Form->control('password', [
        'label' => __d('community', 'Password'),
        'type'  => 'password',
        'placeholder' => __d('community', 'Enter new password'),
    ]);

    echo $this->Form->control('password_confirm', [
        'label'       => __d('community', 'Confirm password'),
        'type'        => 'password',
        'class'       => 'form-control',
        'placeholder' => __d('community', 'Confirm new password'),
    ]);

    echo $this->Form->button(__d('community', 'Setup password'), [
        'icon'   => 'repeat',
        'button' => 'success'
    ]);

    echo $this->Form->end();
    ?>
</div>
