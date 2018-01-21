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

if (!defined('MIN_LENGTH_PASS')) {
    define('MIN_LENGTH_PASS', 6);
}

if (!defined('MIN_LENGTH_LOGIN')) {
    define('MIN_LENGTH_LOGIN', 5);
}

if (!defined('CMS_TABLE_USERS')) {
    define('CMS_TABLE_USERS', 'users');
}

if (!defined('CMS_TABLE_GROUPS')) {
    define('CMS_TABLE_GROUPS', 'groups');
}

if (!defined('GROUP_ADMIN')) {
    define('GROUP_ADMIN', 4);
}
