<?php
/**
 * Sockets
 * @author Mihael Isaev 
 */
class sockets {
	
    /**
      * Stack of actions
      */
    static private $actions;

    /**
      * Main server function
      */
    static function run($action) {
        //Check username
        $chat = new chat();
        $chat::checkUserName();
        //Check socket files size and remove if is big
        foreach (glob(SOCKETS_PATH.DS.'*') as $sock)
            if (filesize($sock) > 2048)
                    unlink($sock);
        $action = 'action'.$action;
        if (is_callable('self::'.$action)) {
                self::$action();
                self::send();
        }
    }
    
    /**
      * Action
      * Connect to server
      * Create socket and send id to client
      */
    static function actionConnect() {
        $sock = md5(microtime().rand(1, 1000));
        $_SESSION[currentSocket] = $sock;
        fclose(fopen(SOCKETS_PATH.DS.$sock, 'a+b'));
        $currentTime = time();
        $message = array(
            'action' => 'message',
            'params' => array(
                'date' => $currentTime,
                'user' => 'system',
                'text' => $_SESSION[userName].' has joined'
            )
        );
        self::addToSock($message, $_SESSION[currentSocket]);
        self::send();
    }
    
    /**
     * Function for add action to stack
     */
    static function addToSock($message, $self = null) {
        $json = json_encode($message);
        foreach (glob(SOCKETS_PATH.DS.'*') as $s) {
            //if($self && strpos($sock, $self) !== false)
            //    continue;
            $f = fopen($s, 'a+b') or die('socket not found');
            flock($f, LOCK_EX);
            fwrite($f, $json."\r\n");
            fclose($f);
        }
    }
	
    /**
     * Function for add action to current request
     * @param $message[]
     */
    static function addToSend($message) {
        self::$actions[] = $message;
    }
	
    /**
      * Send actions stack to client
      */
    static function send() {
        if (self::$actions)
            exit(json_encode(self::$actions));
    }
    
    /**
     * Connection checker
     * and if session is empty
     * we call connect 
     */
    static function checkConnection(){
        if($_SESSION[currentSocket]!=='' && file_exists(SOCKETS_PATH.DS.$_SESSION[currentSocket]))
            return true;
        else{
            self::actionConnect();
            return true;
        }
    }
    
    /**
      * Action
      * Disctonnecting from server
      * Remove socket file
      */
    static function actionDisconnect() {
        $currentTime = time();
        $message = array(
            'action' => 'message',
            'params' => array(
                'date' => $currentTime,
                'user' => 'system',
                'text' => $_SESSION[userName].' disconnected'
            )
        );
        self::addToSock($message, $_SESSION[currentSocket]);
        unlink(SOCKETS_PATH.DS.$_SESSION[currentSocket]);
        $_SESSION[currentSocket] = '';
        $_SESSION[userName] = '';
    }
    
    /**
      * Action
      * Rename user
      */
    static function actionRename($oldName, $newName) {
        $currentTime = time();
        $message = array(
            'action' => 'message',
            'params' => array(
                'date' => $currentTime,
                'user' => 'system',
                'text' => $oldName.' renamed to '.$newName
            )
        );
        self::addToSock($message, $_SESSION[currentSocket]);
    }
	
    /**
      * Action
      * Send message to all users
      */
    static function actionSend() {
        $text = $_POST[text];
        $currentTime = time();
        if (strlen($text)) {
            $chat = new chat();
            $messageId = $chat->insertMessageToDB($text, $currentTime, $_SESSION[userName], $_SESSION[currentSocket]);
            $message = array(
                'action' => 'message',
                'params' => array(
                    'id' => $messageId,
                    'my' => 'true',
                    'date' => $currentTime,
                    'user' => $_SESSION[userName],
                    'text' => $text,
                    'sessionId' => $_SESSION[currentSocket]
                )
            );
            $status = array(
                'status' => 'ok',
                'error'  => '',
                'sessionId' => $_SESSION[currentSocket]
            );
            self::addToSock($message, $_SESSION[currentSocket]);
            self::addToSend($status);
        }
    }
	
    /**
      * Action
      * Socket listener for client
      */
    static function actionRead() {
        $sock = $_SESSION[currentSocket];
        $currentTime = time();
        while ((time() - $currentTime) < 30) {
            if ($data = file_get_contents(SOCKETS_PATH.DS.$sock)) {
                $f = fopen(SOCKETS_PATH.DS.$sock, 'r+b') or die('socket not found');
                flock($f, LOCK_EX);
                ftruncate($f, 0);
                fwrite($f, '');
                fclose($f);
                $data = trim($data, "\r\n");
                foreach (explode("\r\n", $data) as $action)
                    self::$actions[] = json_decode($action);
                self::send();
            }
            usleep(250);
        }
    }
    
    /**
      * Action
      * Delete message at all users
      */
    static function actionDelete() {
        $id = $_POST[id];
        $chat = new chat();
        if($chat->deleteMessage($id, $_SESSION[currentSocket])){
            $message = array(
                'action' => 'delete',
                'params' => array(
                    'id' => $id
                )
            );
            self::addToSock($message, $_SESSION[currentSocket]);
        }
    }
    
    /**
      * Action
      * Like message at all users
      */
    static function actionLike() {
        $id = $_POST[id];
        $chat = new chat();
        $count = $chat->likeMessage($id, $_SESSION[currentSocket]);
        $message = array(
            'action' => 'like',
            'params' => array(
                'id'    => $id,
                'count' => $count
            )
        );
        self::addToSock($message, $_SESSION[currentSocket]);
    }
}

?>