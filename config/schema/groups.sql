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
-- Create groups table structure
--
CREATE TABLE IF NOT EXISTS `groups` (
  `id`        int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `name`      varchar(100) NOT NULL,
  `slug`      varchar(100) NOT NULL,
  `params`    longtext,
  `lft`       int(10) DEFAULT NULL,
  `rght`      int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
