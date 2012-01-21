/**
 * Javascript class for Chat
 * visual
 * Created by Mihael Isaev
 */

visual = {}
/**
 * Show progress bar
 */
visual.showProgressBar = function() {
    if($('.progressBar').css('display')=='none')
        $('.progressBar').fadeIn('fast');
    if($('.modalBackground').css('display')=='none')
        $('.modalBackground').fadeIn('fast');
}

/**
 * Hide progress bar
 */
visual.hideProgressBar = function() {
    if($('.progressBar').css('display')=='block')
        $('.progressBar').fadeOut('fast');
    if($('.modalBackground').css('display')=='block')
        $('.modalBackground').fadeOut('fast');
}