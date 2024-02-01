var pass_Input = document.getElementById('user-password');
var message = document.getElementById('message');
var lower = document.getElementById('lower');
var upper = document.getElementById('upper');
var number = document.getElementById('number');
var special = document.getElementById('special');
var length = document.getElementById('length');

message.classList.add('hidden');    
pass_Input.onfocus = function()
{
    message.classList.remove('hidden');
}

pass_Input.onblur = function()
{
    message.classList.add('hidden');
}


pass_Input.onkeyup = function()
{
    var lowerCaseLetters = /[a-z]/g;
  if(pass_Input.value.match(lowerCaseLetters)) {
    lower.classList.remove("invalid");
    lower.classList.add("valid");
    } else {
    lower.classList.remove("valid");
    lower.classList.add("invalid");
    }

    var upperCaseLetters = /[A-Z]/g;
    if(pass_Input.value.match(upperCaseLetters)) {
        upper.classList.remove("invalid");
        upper.classList.add("valid");
        } else {
        upper.classList.remove("valid");
        upper.classList.add("invalid");
        }
    
    if(pass_Input.value.length >= 8)
    {
        length.classList.remove("invalid");
        length.classList.add("valid");
    }
    else
    {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }

    var numberCheck = /[0-9]/g;
    if(pass_Input.value.match(numberCheck)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
        } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
        }

        var specialCharacters = /[\!\@\#\$\%\^\&\*\(\)]/g;
    if(pass_Input.value.match(specialCharacters)) {
        special.classList.remove("invalid");
        special.classList.add("valid");
        } else {
        special.classList.remove("valid");
        special.classList.add("invalid");
        }
    }