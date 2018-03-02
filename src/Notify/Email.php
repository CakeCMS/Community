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

namespace Community\Notify;

use JBZoo\Data\Data;
use Extensions\Plugin;
use Core\Utility\Macros;
use Community\Model\Entity\User;
use Core\Notify\Email as CoreEmail;

/**
 * Class Email
 *
 * @package  Community\Notify
 * @property User $_data
 */
class Email extends CoreEmail
{

    /**
     * Plugin params.
     *
     * @var Data
     */
    protected $_params;

    /**
     * Send user message when have success activation profile.
     *
     * @return  array
     */
    public function sendActivationMessage()
    {
        $macros  = new Macros($this->_data);
        $message = $this->_params->get('msg_account_activate_msg');
        $message = $macros->text($message);
        $subject = $this->_params->get('msg_account_activate_subject');

        return $this->send($subject, $message, $this->_data->email, null, $this->_getFromMail());
    }

    /**
     * Send user create account profile message / set password.
     *
     * @return  array
     */
    public function sendCreateMessage()
    {
        $macros  = new Macros($this->_data);
        $message = $this->_params->get('msg_account_create_msg');
        $message = $macros->text($message);
        $subject = $this->_params->get('msg_account_create_subject');

        return $this->send($subject, $message, $this->_data->email, null, $this->_getFromMail());
    }

    /**
     * Constructor hook method.
     *
     * @return  void
     */
    protected function _initialize()
    {
        $this->_params = Plugin::getParams('Community');
    }

    /**
     * Get from email - global settings.
     *
     * @return  string
     */
    protected function _getFromMail()
    {
        return Plugin::getParams('Core')->get('admin_email');
    }
}
