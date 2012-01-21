<?php
/*
 * Chat HTML-code
 */

$chat = new chat();

?>
<div id="blb" class="settings">
    <div class="titleSettings">Settings</div>
    <div class="titleUserName">Username</div>
    <input class="userName" value="<?=$chat::getUserName();?>">
    <div class="info"></div>
    <div class="buttonSave">Save</div>
    <div class="buttonCancel">Cancel</div>
</div>
<div class="chatWindow">
    <div class="title">
        <div class="text">Chat</div>
        <div class="user"><?=$chat::getUserName();?></div>
    </div>
    <div class="messages"></div>
    <div class="newMessage">
        <textarea></textarea>
        <div class="buttonSend">Send</div>
        <div class="buttonSettings">Settings</div>
        <div class="error"></div>
    </div>
</div>