<?php

/**
 * Class UserRoleModel
 *
 * This class contains everything that is related to up- and downgrading accounts.
 */
class UserRoleModel {
    public static $addPermQuery = null;
    public static $getPermsQuery = null;
    public static $getPermQuery = null;
    public static $removePermQuery = null;
    /**
     * Adding A permission!
     * @param $user_id
     * @param $new_perm
     */
    public static function addPerm($user_id, $new_perm) {
        if (self::$addPermQuery === null) {
            self::$addPermQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE users SET perms = :new WHERE user_id = :user_id");
        }
        $newset = array_push($new_perm, UserRoleModel::getPerms($user_id));
        self::$addPermQuery->execute(array(':user_id' => $user_id, ':new' => json_encode($newset)));
        Session::add('feedback_positive', 'User perm added successfully!');
    }

    /**
     * Get ALL User permissions!
     * @param $user_id
     * @return array $perms
     */
    public static function getPerms($user_id) {
        if (self::$getPermsQuery === null) {
            self::$getPermsQuery = DatabaseFactory::getFactory()->getConnection()->prepare("SELECT perms FROM users WHERE user_id = :user_id LIMIT 1");
        }
        self::$getPermsQuery->execute(array(':user_id' => $user_id));

        $perms = json_decode(self::$getPermsQuery->fetch(PDO::FETCH_ASSOC), true);
        return $perms;
    }

    /**
     * See if a user has A permission
     * @param $user_id
     * @param $perm_name
     * @return bool
     */
    public static function getPerm($user_id, $perm_name) {
        if (self::$getPermQuery === null) {
            self::$getPermQuery = DatabaseFactory::getFactory()->getConnection()->prepare("SELECT perms FROM user WHERE user_id = :user_id LIMIT 1");
        }
        self::$getPermQuery->execute(array(':user_id' => $user_id));
        //search array for the correct perm and if it exist return true
        if (in_array($perm_name, self::$getPermQuery->fetch(PDO::FETCH_ASSOC))) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Remove A user permission
     * @param $user_id
     * @param $removed_perm
     */
    public static function removePerm($user_id, $removed_perm) {
        if (self::$removePermQuery === null) {
            self::$removePermQuery = DatabaseFactory::getFactory()->getConnection()->prepare("UPDATE users SET perms = :new WHERE user_id = :user_id");
        }
        $original = UserRoleModel::getPerms($user_id);
        $being_removed = array_search($removed_perm, $original);
        unset($original[$being_removed]);
        self::$removePermQuery->execute(array(':new' => json_encode($original), ':user_id' => $user_id));
        Session::add('feedback_positive', 'Removed that permission!');
    }
}
