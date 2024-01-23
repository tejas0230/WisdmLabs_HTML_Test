const buttonA = document.getElementByClassName("btn");

function check()
{
    buttonA.innerHTML = "hi";
}

buttonA.addEventListener("click",check);