--
-- CakeCMS Community
--
-- This file is part of the of the simple cms based on CakePHP 3.
-- For the full copyright and license information, please view the LICENSE
-- file that was distributed with this source code.
--
-- @package   Community
-- @license   MIT
-- @copyright MIT License http://www.opensource.org/licenses/mit-license.php
-- @link      https://github.com/CakeCMS/Community
--

--
-- Create users table structure
--
CREATE TABLE IF NOT EXISTS `users` (
  `id`            int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id`      int(10) NOT NULL,
  `login`         varchar(60) NOT NULL,
  `name`          varchar(60) NOT NULL,
  `slug`          varchar(60) NOT NULL,
  `email`         varchar(50) NOT NULL,
  `password`      varchar(100) NOT NULL,
  `token`         varchar(60) NOT NULL,
  `status`        tinyint(1) NOT NULL DEFAULT '0',
  `params`        text,
  `last_login`    datetime DEFAULT '0000-00-00 00:00:00',
  `last_action`   datetime DEFAULT '0000-00-00 00:00:00',
  `modified`      datetime DEFAULT '0000-00-00 00:00:00',
  `created`       datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
