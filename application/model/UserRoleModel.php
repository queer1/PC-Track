<?php

/**
 * Class UserRoleModel
 *
 * This class contains everything that is related to up- and downgrading accounts.
 */
class UserRoleModel {
    /**
     * @param $user_id
     * @param $new_perm
     */
    public static function addPerm($user_id, $new_perm) {
        $newset = array_push($new_perm, UserRoleModel::getPerms($user_id));
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE users SET perms = :new WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':new' => json_encode($newset)));
    }

    /**
     * Get User permissions!
     * @param $user_id
     * @return array $perms
     */
    public static function getPerms($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT user_permissions
                FROM users WHERE user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        $perms = json_decode($query->fetch(), true);
        return $perms;
    }

    /**
     * @param $user_id
     * @param $removed_perm
     */
    public static function removePerm($user_id, $removed_perm) {
        $original = UserRoleModel::getPerms($user_id);
        $being_removed = array_search($removed_perm, $original);
        unset($original[$being_removed]);
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE users SET perms = :new WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':new' => json_encode($original), ':user_id' => $user_id));
    }
}