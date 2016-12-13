document.oncontextmenu = function() {
    return false;
}
document.body.oncopy = function() {
    return false;
}
document.body.onpaste = function() {
    return false;
}
document.body.oncut = function() {
    return false;
}
//ctrl+f
document.onkeydown = function(e){
    if(e.keyCode == 70 && event.ctrlKey){
        return false;
    }
}