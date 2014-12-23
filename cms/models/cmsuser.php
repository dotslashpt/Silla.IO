<?php
/**
 * CMS User Model.
 *
 * @package    Silla
 * @subpackage CMS\Models
 * @author     Plamen Nikolov <plamen@athlonsofia.com>
 * @copyright  none
 * @licence    GPL http://www.gnu.org/copyleft/gpl.html
 */

namespace CMS\Models;

use Core;
use Core\Base;
use Core\Modules\Crypt\Crypt;
use Core\Modules\DB\Decorators\Interfaces;

/**
 * Class CMSUser definition.
 */
class CMSUser extends Base\Model implements Interfaces\TimezoneAwareness
{
    /**
     * Table storage name.
     *
     * @var string
     */
    public static $tableName = 'cms_users';

    /**
     * Has many relation definition.
     *
     * @var array
     */
    protected $belongsTo = array(
        'role' => array(
            'table' => 'cms_userroles',
            'key' => 'role_id',
            'relative_key' => 'id',
            'class_name' => 'CMS\Models\CMSUserRole'
        ),
    );

    /**
     * Definition of the timezone aware fields.
     *
     * @static
     *
     * @return array
     */
    public static function timezoneAwareFields()
    {
        return array('created_on', 'updated_on', 'login_on');
    }

    /**
     * After validate actions.
     *
     * @return void
     */
    public function afterValidate()
    {
        if (!$this->isNewRecord()) {
            if (!$this->current_password) {
                $this->errors['current_password'] = 'not_empty';
            } else {
                $user = Core\Registry()->get('current_user');
                $user = self::find()->where('id = ?', array($user->id))->first();
                $passwordsMatch = Crypt::hashCompare($user->password, $this->current_password);

                if (!$passwordsMatch) {
                    $this->errors['current_password'] = 'mismatch';
                }
            }
        }
        if ($this->password !== $this->password_confirm) {
            $this->errors['password_confirm'] = 'mismatch';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'invalid_format';
        }

        if (!$this->isNewRecord() && isset($this->errors['password'])) {
            unset($this->errors['password'], $this->password);
        }
    }

    /**
     * Before save actions.
     *
     * @return void
     */
    public function beforeSave()
    {
        if ($this->password && !in_array(Core\Router()->request->action(), array('login', 'reset'), true)) {
            $this->password = Crypt::hash($this->password);
        }
    }
}
