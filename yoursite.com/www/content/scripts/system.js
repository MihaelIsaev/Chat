/**
 * Javascript class for Chat
 * Created by Mihael Isaev
 */

/**
 * Include child scripts
 */
$.include('/content/scripts/visual.js');
$.include('/content/scripts/ajax.js');
$.include('/content/scripts/helper.js');
$.include('/content/scripts/binder.js');
$.include('/content/scripts/html.js');
$.include('/content/scripts/chat.js');


system = {}

/**
 * Load login html code
 */
system.loadChat = function() {
    ajax.run({
        data: ({module: 'html', action:'chat'}),
        showProgressBar: true,
        onSuccess: function(data){
            html.setMainData(data);
            $('.chatWindow').fadeIn('slow');
            binder.chat();
            chat.check();
        }
    });
}

/**
 * Settings container position corrector
 */
system.positionSettings = function() {
    var windowWidth = $(window).width();
    var settingsWidth = $('.settings').width();
    var settingsLeftPosition = (windowWidth/2)-(settingsWidth/2);
    $('.settings').css('left', settingsLeftPosition+'px');
}

/**
 * Document ready function
 */
$(document).ready(function(){
    system.loadChat();
    setInterval(function(){chat.checkState();}, 10000);
});