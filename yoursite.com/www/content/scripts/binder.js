/**
 * Javascript class for Chat
 * binder for pages
 * Created by Mihael Isaev
 */


binder = {}

/**
 * Global binder for chat elements
 */
binder.chat = function() {
    $('.settings .buttonSave').click(function(){
        chat.changeName();
    });
    $('.settings .buttonCancel').click(function(){
        chat.hideSettings();
    });
    $('.chatWindow .newMessage .buttonSend').click(function(){
        chat.send();
    });
    $('.settings .userName').keypress(function(event){
        if(event.keyCode == 13)
            chat.changeName();
    });
    $('.chatWindow .newMessage textarea').keypress(function(event){
        if(event.keyCode == 13)
            chat.send();
    });
    $('.chatWindow .newMessage .buttonSettings').click(function(){
        chat.showSettings();
    });
    $(window).resize(function(){
        system.positionSettings();
    });
    $(window).focus(function(){
        chat.checkState();
    });
    window.onbeforeunload = function(){
        chat.disconnect();
    };
};

/**
 * Binder for new added messages
 */
binder.chatMessage = function(id){
    //Delete
    $('#mess'+id+' .delete').click(function(){
        chat.remove(id);        
    });
    
    $('#mess'+id).mouseover(function(){
        $('#mess'+id+' .delete').show();
    });
    
    $('#mess'+id).mouseleave(function(){
        $('#mess'+id+' .delete').hide();
    });
    
    //Like
    $('#mess'+id+' .heart').click(function(){
        chat.like(id);        
    });
    
    $('#mess'+id).mouseover(function(){
        $('#mess'+id+' .heart').show();
    });
    
    $('#mess'+id).mouseleave(function(){
        $('#mess'+id+' .heart').hide();
    });
    
    $('#mess'+id).mouseover(function(){
        $('#mess'+id+' .likes').show();
    });
    
    $('#mess'+id).mouseleave(function(){
        $('#mess'+id+' .likes').hide();
    });
}