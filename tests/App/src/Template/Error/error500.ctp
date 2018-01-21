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
?>
<strong>Error: </strong>
<?= h($error->getMessage()) ?>
<br/>

<strong>File</strong>
<?= h($error->getFile()) ?>
<br/>
<strong>Line: </strong>
<?= h($error->getLine()) ?>
