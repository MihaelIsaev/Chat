/* 
 * Javascript class for Chat
 * Helper
 * Created by Mihael Isaev
 */

helper = {}

/**
 * StringBuffer emulator like Java StringBuffer
 */
function StringBuffer()
{
  this.buffer = [];
}

StringBuffer.prototype.append = function(string) 
{ 
  this.buffer.push(string); 
  return this; 
} 

StringBuffer.prototype.toString = function()
{ 
  return this.buffer.join(""); 
}

/**
 * Print_r() emulator like PHP print_r()
 */
function print_r(arr, level) {
    var print_red_text = "";
    if(!level) level = 0;
    var level_padding = "";
    for(var j=0; j<level+1; j++) level_padding += "    ";
    if(typeof(arr) == 'object') {
        for(var item in arr) {
            var value = arr[item];
            if(typeof(value) == 'object') {
                print_red_text += level_padding + "'" + item + "' :\n";
                print_red_text += print_r(value,level+1);
		} 
            else 
                print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        }
    } 

    else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
    return print_red_text;
}