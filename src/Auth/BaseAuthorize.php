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

namespace Community\Auth;

use Cake\Http\ServerRequest;
use Cake\Auth\BaseAuthorize as CakeBaseAuthorize;

/**
 * Class BaseAuthorize
 *
 * @package Community\Auth
 */
class BaseAuthorize extends CakeBaseAuthorize
{

    /**
     * Checks user authorization.
     *
     * @param   array|\ArrayAccess $user Active user data
     * @param   ServerRequest $request Request instance.
     * @return  bool
     */
    public function authorize($user, ServerRequest $request)
    {
        return true;
    }
}
