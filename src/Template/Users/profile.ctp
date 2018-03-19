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
 * @var         \Community\Model\Entity\User $user
 */

$user = $this->get('user');
?>
<div class="profile-page section">
    <div class="profile-page-header card">
        <div class="card-image waves-effect waves-block waves-light">
            <img class="activator" src="https://pixinvent.com/materialize-material-design-admin-template/images/gallary/23.png"
                 alt="user background">
        </div>
        <figure class="card-profile-image">
            <?php
            $image = $this->Html->image('https://pixinvent.com/materialize-material-design-admin-template/images/avatar/avatar-7.png', [
                'class' => 'circle z-depth-2 responsive-img blue lighten-2'
            ]);

            echo $this->Html->link($image, $user->getEditUrl());
            ?>
        </figure>
        <div class="card-content">
            <div class="row pt-2">
                <div class="col s12 m3 offset-m2">
                    <h4 class="card-title grey-text text-darken-4">
                        <?= $this->Html->link($user->name, $user->getEditUrl()) ?>
                    </h4>
                    <p class="medium-small grey-text"><?= $user->group->name ?></p>
                </div>
                <div class="col s12 m2 center-align">
                    <h4 class="card-title grey-text text-darken-4">10+</h4>
                    <p class="medium-small grey-text">Work Experience</p>
                </div>
                <div class="col s12 m2 center-align">
                    <h4 class="card-title grey-text text-darken-4">6</h4>
                    <p class="medium-small grey-text">Completed Projects</p>
                </div>
                <div class="col s12 m2 center-align">
                    <h4 class="card-title grey-text text-darken-4">$ 1,253,000</h4>
                    <p class="medium-small grey-text">Busness Profit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-page-content row">
        <div class="col s12 m4">
            <div class="card cyan">
                <div class="card-content white-text">
                    <span class="card-title">About Me!</span>
                    <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
                </div>
            </div>
        </div>
        <div class="col s12 m8">
            <div class="card">
                <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
                </div>
            </div>
        </div>
    </div>
</div>
