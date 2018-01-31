/**
 * CakeCMS Community
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Community
 * @license    MIT
 * @copyright  MIT License http://www.opensource.org/licenses/mit-license.php
 * @link       https://github.com/CakeCMS/Community
 */


JBZoo.widget('JBZoo.UserAdminForm', {
    'isNotify' : false
}, {

    /**
     * Widget constructor.
     *
     * @param $this
     */
    init: function ($this) {
        $this.action = window.CMS.request.params.action;

        if (!$this.$('.jsStatus').prop('checked')) {
            $this._disablePasswordFields($this);
        }

        if ($this.action === 'add' && $this.getOption('isNotify') === true) {
            $this.$('.jsStatus').closest('.switch').hide();
        }
    },

    /**
     * On change notify.
     *
     * @param e
     * @param $this
     */
    'change .jsNotify' : function (e, $this) {
        var status = $this.$('.jsStatus');
        status.attr('checked', false);
        status.trigger('change').closest('.switch').slideToggle('fast');
    },

    /**
     * On change user status.
     *
     * @param e
     * @param $this
     */
    'change .jsStatus' : function (e, $this) {
        var el         = $(this);
        var isChecked  = el.prop('checked');
        var pwdWrapper = $this.$('.jsPasswordWrapper');

        if ($this.action === 'add') {
            if (isChecked) {
                pwdWrapper.slideDown();
                $this._enablePasswordFields($this);
            } else {
                pwdWrapper.slideUp();
                $this._disablePasswordFields($this);
            }
        }
    },

    /**
     * Disable password fields.
     *
     * @param $this
     * @private
     */
    _disablePasswordFields : function ($this) {
        $this.$('#password').attr('disabled', 'disabled');
        $this.$('#password-confirm').attr('disabled', 'disabled');
    },

    /**
     * Disable password fields.
     *
     * @param $this
     * @private
     */
    _enablePasswordFields : function ($this) {
        $this.$('#password').removeAttr('disabled', 'disabled');
        $this.$('#password-confirm').removeAttr('disabled', 'disabled');
    }
});
