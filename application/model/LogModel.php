<?php

/**
 * LogModel
 * This model handels everything that is done for the logging of a users actions.
 */
class LogModel {
    public static $getLogQuery = null;
    public static $getActivityQuery = null;

    /**
     * Get all the log enties that are in the database.
     * @param int $limit
     * @return array
     */
    public static function getLog($limit = 200) {
        $db = DatabaseFactory::getFactory()->fluentPDO();
        $query = $db->from('log')->limit($limit);
        $query->execute();
        $data = $query->fetchall('ENTRY_ID');

        return json_decode(json_encode($data), true);
    }


    /**
     * Get Activity of a single user.
     * @param int $user_id id of the specific user
     * @return object a single object (the result)
     */
    public static function getActivity($user_id) {
        if(self::$getActivityQuery === null) {
            self::$getActivityQuery = DatabaseFactory::getFactory()
                ->getConnection()
                ->prepare("SELECT * FROM log WHERE user_id = :user_id ");
        }
        self::$getActivityQuery->execute(array(':user_id' => (int) $user_id));

        return self::$getActivityQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * create a new log entry
     * @param $user_id , add user_id to log
     * @param string $action , create-comment-close-undo
     * @param string $param , addtional parameters that can be stored. (JSON)
     * @return bool feedback
     */
    public static function log($user_id, $action, $param) {
        $db = DatabaseFactory::getFactory()->fluentPDO();

        $values = array(
            'ENTRY_ID' => time(),
            'action' => $action,
            'user_id' => $user_id,
            'param' => json_encode($param)
        );

        $query = $db->insertInto('log', $values);
        $query->execute();

        return true;
    }
}
