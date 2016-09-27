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
 */

namespace Community\Test\TestCase;

use Core\TestSuite\TestCase;
use Community\Controller\Admin\AppController;

/**
 * Class AppControllerTest
 *
 * @package Community\Test\TestCase
 */
class AppControllerTest extends TestCase
{

    public function testClassName()
    {
        $controller = new AppController();
        $this->assertInstanceOf('Community\Controller\Admin\AppController', $controller);
    }
}
