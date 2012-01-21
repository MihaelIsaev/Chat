/**
 * Javascript class for Chat
 * Chat
 * Created by Mihael Isaev
 */


chat = {}
/**
 * Ajax request variable
 */
chat.aj = null;

/*
 * User session id
 */
chat.sessionId = null;

/**
 *  Messages listener
 */
chat.check = function() {
    chat.aj = ajax.run({
            data: ({module: 'chat', action:'check'}),
            json: true,
            fast:true,
            onSuccess: function(data){
                if(data.length>0)
                    $.each(data, function(key, mess) {
                        if(mess.action=='message'){
                            var my = false;
                            if(chat.sessionId == mess.params.sessionId)
                                my = true;
                            chat.addToWall(mess.params.id, mess.params.date, mess.params.text, mess.params.user, my);
                        }
                        if(mess.action=='delete')
                            chat.removeFromWall(mess.params.id);
                        if(mess.action=='like')
                            chat.setLikesForMessageOnWall(mess.params.id, mess.params.count);
                    });
            },
            onComplete: function(){
                chat.check();
            }
        });
}

/**
 * Function add new message to chat
 */
chat.send = function() {
    ajax.run({
        data: ({
            module: 'chat',
            action:'send',
            text:$('.chatWindow .newMessage textarea').val()}),
        json: true,
        fast:true,
        onSuccess: function(data){
            if(data[0].status == 'ok'){
                $('.chatWindow .newMessage textarea').val('');
                $('.chatWindow .newMessage .error').html('');
                $('.chatWindow .newMessage .error').html('');
                chat.sessionId = data[0].sessionId
            }else{
                $('.chatWindow .newMessage .error').html(data[0].error);
            }
        }
    });
}

/**
 * Last call to server before close window
 */
chat.disconnect = function() {
    ajax.run({
        sync: true,
        data: ({
            module: 'chat',
            action: 'disconnect'
        }),
        fast:true
    });
}

/**
 * Function for remove your message from chat
 * @param int id message
 */
chat.remove = function(id) {
    ajax.run({
        data: ({
            module: 'chat',
            action:'delete',
            id:id
        }),
        fast:true,
        onComplete: function(){
            chat.removeFromWall(mess.params.id);
        }
    });
}

/**
 * Function for remove message container by id
 * @param int id message
 */
chat.removeFromWall = function(id) {
    $('#mess'+id).remove();
}

/**
 * Function for like message by id
 * @param int id message
 */
chat.like = function(id) {
    ajax.run({
        data: ({
            module: 'chat',
            action:'like',
            id:id
        }),
        fast:true
    });
}

/**
 * Function for set size of likes fr message by id
 * @param int id message
 * @param int size of likes
 */
chat.setLikesForMessageOnWall = function(id, count) {
    $('#mess'+id+' .likes').html(count);
}

/**
 * Function for add new message to chat window
 * @param id       int     id message
 * @param date     int     date of message
 * @param test     String  text of message
 * @param userName String  username
 * @param my       boolean true/false
 */
chat.addToWall = function(id, date, text, userName, my){
    var time = new Date(date*1000);
    var day = time.getDate();
    var month = time.getMonth()+1;
    var year = time.getFullYear();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();
    
    var deleteBuffer = new StringBuffer();
    if(my)
        deleteBuffer.append('<div class="delete"></div>');
    var stringBuffer = new StringBuffer();
    stringBuffer.append('<div class="message" id="mess')
                .append(id)
                .append('">')
                .append('<div class="name">')
                .append(userName)
                .append(': </div>')
                .append(deleteBuffer.toString())
                .append('<div class="heart"></div>')
                .append('<div class="likes">0</div>')
                .append('<div class="text">')
                .append(text)
                .append('</div>')
                .append('<div class="time">')
                .append(day)
                .append('.')
                .append(month)
                .append('.')
                .append(year)
                .append(' ')
                .append(hours)
                .append(':')
                .append(minutes)
                .append(':')
                .append(seconds)
                .append('</div>')
                .append('</div>');
    $('.chatWindow .messages').prepend(stringBuffer.toString());
    binder.chatMessage(id);
}

/**
 * Chack state of check ajax request
 */
chat.checkState = function(){
    if(chat.aj.readyState!==1)
        chat.check();
}

/**
 * Settings container show
 */
chat.showSettings = function(){
    $('.settings').fadeIn();
    system.positionSettings();
}

/**
 * Settings container hide
 */
chat.hideSettings = function(){
    $('.settings').fadeOut();
}

/**
 * Call to server for change username
 */
chat.changeName = function(){
    ajax.run({
        data: ({module: 'chat', action:'changeName', name:$('.settings .userName').val()}),
        json: true,
        fast:true,
        onSuccess: function(data){
            if(data.status == 'ok'){
                var newUserName = $('.settings .userName').val();
                $('.chatWindow .title .user').html(newUserName);
                $('.settings .info').html('your username has been saved');
                setTimeout(function(){
                    $('.settings').fadeOut();
                    $('.settings .info').html('');
                },3000);
            }else
                $('.settings .info').html('Error');
        }
    });
}