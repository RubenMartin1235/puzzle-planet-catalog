
let cardImgInput = document.querySelector('#card-image-input');
let cardImg = document.querySelector('#card-image-view');

cardImgInput.addEventListener('change',(e)=>{
    const targ = e.target;
    let newimg = targ.files[0];
    if (!newimg.type.includes(`image/`)) {
        return;
    }
    let newsrc = URL.createObjectURL(newimg);
    cardImg.src = newsrc;
});
/*
<x-danger-button id="btn-delblock"
    class="text-center text-2xl font-bolder"
    type="button"
>{{ __('-') }}</x-danger-button>
*/
