/**
 * Javascript class for Chat
 * ajax function
 * Created by Mihael Isaev
 */

/**
 * Ajax short method
 */
ajax = {}
ajax.run = function(params) {
    var async = true;
    var dataType = 'html';
    if(params.sync) async = false;
    if(params.json) dataType = 'json';
    var aj = $.ajax({
        async: async,
        cache: false,
        type: 'POST',
        url: '/ajax.php',
        data: params.data,
        dataType: dataType,
        beforeSend:function(){
            if(params.beforeSend)
                params.beforeSend();
            if(params.showProgressBar)
                visual.showProgressBar();
        },
        success: function (data, textStatus, XMLHttpRequest) {
            if(params.fast)
                params.onSuccess(data);
            else
                setTimeout(function(){params.onSuccess(data);}, 500);
            if(params.showProgressBar)
                if(params.fast)
                    visual.hideProgressBar();
                else
                    setTimeout(function(){visual.hideProgressBar();}, 500);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            if(params.showProgressBar)
                visual.hideProgressBar();
            params.onError();
        },
        complete: function(){
            params.onComplete();
        }
    });
    return aj;
}