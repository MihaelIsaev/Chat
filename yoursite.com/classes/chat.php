<?php

/**
 * Chat
 * @author Mihael Isaev
 */
class chat {
    
    /**
     * Function for check username in session
     * if is empty set to anonymous 
     */
    static function checkUserName(){
        if(!$_SESSION['userName'] || $_SESSION['userName']=='')
            $_SESSION['userName'] = 'anonymous';
    }
    
    /**
     * Function for get username from session variable
     * @return String username 
     */
    static function getUserName(){
        self::checkUserName();
        return $_SESSION['userName'];
    }
    
    /**
     * Function for insert new message to DB
     * @param String $text
     * @param int    $date
     * @param String $userName
     * @param md5    $sessionId
     * @return int message id
     */
    function insertMessageToDB($text, $date, $userName, $sessionId){
        $db = new mysqliDB();
        $db->insert("INSERT INTO `chat`.`messages` (`Text`, `Date`, `UserName`, `SessionId`) VALUES (?, ?, ?, ?)", $text, $date, $userName, $sessionId);
        return $db->queryInfo['insert_id'];
    }
    
    /**
     * Function for delete message from DB by id
     * @param int $id message id
     * @param md5 $sessionId
     * @return boolean true/false
     */
    function deleteMessage($id, $sessionId){
        $db = new mysqliDB();
        $db->select("SELECT * FROM `chat`.`messages` WHERE Id=? AND SessionId=?", $id, $sessionId);
        if($db->queryInfo['num_rows']>0){
            $db->delete("DELETE FROM `chat`.`messages` WHERE Id=?", $id);
            return true;
        }else
            return false;
    }
    
    /**
     * Function for set like on message
     * if like already setted - unset like
     * @param int $id message id
     * @param md5 $sessionId
     * @return int size of likes for this message
     */
    function likeMessage($id, $sessionId){
        $db = new mysqliDB();
        $db->select("SELECT * FROM `chat`.`likes` WHERE IdMessage=? AND SessionId=?", $id, $sessionId);
        if($db->queryInfo['num_rows']>0)
            $db->delete("DELETE FROM `chat`.`likes` WHERE IdMessage=? AND SessionId=?", $id, $sessionId);
        else
            $db->insert("INSERT INTO `chat`.`likes` (`IdMessage`, `SessionId`) VALUES (?, ?)", $id, $sessionId);
        $db->select("SELECT * FROM `chat`.`likes` WHERE IdMessage=?", $id);
        return $db->queryInfo['num_rows'];
    }
    
    /**
     * Function for get size likes for message
     * @param int $id message id
     * @return int size of likes for this message
     */
    function getLikesForMessage($id){
        $db = new mysqliDB();
        $db->select("SELECT * FROM `chat`.`likes` WHERE IdMessage=?", $id);
        return $db->queryInfo['num_rows'];
    }
}

?>
