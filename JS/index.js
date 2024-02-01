var pass_Input = document.getElementById('user-password');
var message = document.getElementById('message');
var lower = document.getElementById('lower');
var upper = document.getElementById('upper');
var number = document.getElementById('number');
var special = document.getElementById('special');
var length = document.getElementById('length');

console.log(pass_Input.tagName);
pass_Input.onfocus = function()
{
    message.classList.remove('hidden');
}

pass_Input.onblur = function()
{
    message.classList.add('hidden');
}

// console.log(pass_Input.nodeValue);
pass_Input.onkeyup = function()
{
    
    var lowerCase = '/[a-z]*/';
    // if()
    // {
    //     lower.classList.remove('invalid');
    //     lower.classList.add('valid');
    // }
    // else
    // {
    //     lower.classList.remove('valid');
    //     lower.classList.add('invalid');
    // }
}