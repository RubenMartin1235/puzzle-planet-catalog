
const delModalForm = document.querySelector("#del-popup-modal form");
const plIdInput = delModalForm.querySelector("input[name='planet_id']");
document.body.addEventListener('click', (e)=>{
    const targ = e.target;
    //console.log(targ.dataset);
    if (targ.dataset.planet) {
        plIdInput.value = targ.dataset.planet;
    }
    let hide = document.querySelectorAll(`[id*='${targ.dataset.modalHide}']`);
    let show = document.querySelectorAll(`[id*='${targ.dataset.modalShow}']`);
    for (const elem of hide) {
        if (!elem.classList.contains('hidden')) {
            elem.classList.add('hidden');
        }
    }
    for (const elem of show) {
        elem.classList.remove('hidden');
    }
    //console.log(hide);
    //console.log(show);
});
