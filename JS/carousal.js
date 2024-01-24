const leftButton  = document.querySelector('.carousal-button-left');
const rightButton  = document.querySelector('.carousal-button-right');

const quote = document.querySelector('.review-text-container');


const quoteText = document.querySelector('.review-text-content');
const quoteAuthor = document.querySelector('.author');

const reviews = ["Erin was a wonderful teacher. She was personable, kind, organized, and great with facilitating group discussion.",
"The ambiance was cozy, the service was top-notch, and the dishes were a burst of flavors. I highly recommend trying the signature dish; it's a gastronomic masterpiece. Can't wait for my next visit!",
"I just finished reading 'Whispers in the Shadows,' and I couldn't put it down! The plot twists kept me on the edge of my seat, and the characters were so well-developed. "];

const author = ["Katy.L","A Culinary Delight","A Gripping Page-Turner"];
let id = 0;
function ShowReview(id)
{
    quote.classList.add('quote-fade');
    setTimeout(()=> {quote.classList.remove('quote-fade');},550);
    quoteText.innerHTML = reviews[id];
    quoteAuthor.innerHTML = author[id];
}

leftButton.addEventListener('click',()=>{
    id--;
    if(id<0)
    {
        id = reviews.length -1;
    }
    ShowReview(id);
});
rightButton.addEventListener('click',()=>{
    id++;
    if(id>=reviews.length)
    {
        id=0;
    }
    ShowReview(id);
});
