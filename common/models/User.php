<?php
namespace common\models;

 /*
 * @author Carapezza Christian <carapezza.christian@gmail.com>
 */
class User extends \dektrium\user\models\User
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
}
