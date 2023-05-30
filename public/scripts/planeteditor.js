function addBlock(type, rate) {
    blocksNumber = Math.floor((blocklist.children.length) / 4)+1;
    let slct = document.createElement('select');
    slct.name = `block-${blocksNumber}-type`;
    slct.required = true;
    for (const block of allblocks) {
        let opt = document.createElement('option');
        let blname = block.name;
        opt.value = blname;
        opt.innerHTML = blname;
        if (blname == type) {
            opt.selected = true;
        }
        slct.appendChild(opt);
    }
    blocklist.appendChild(slct);

    let rateSlider = document.createElement('input');
    rateSlider.type = "range";
    rateSlider.name = `block-${blocksNumber}-rate`;
    rateSlider.min = 0;
    rateSlider.max = maxRateSlider.value;
    rateSlider.value = rate ?? Math.floor(maxRateSlider.value / 2);
    blocklist.appendChild(rateSlider);

    let rateLabel = document.createElement('label');
    rateLabel.id = `${rateSlider.name}-label`;
    rateLabel.innerHTML = maxRateSlider.value;
    rateLabel.className = "flex flex-row items-center";
    blocklist.appendChild(rateLabel);

    let delBtn = document.createElement('x-danger-button');
    delBtn.id = "btn-delblock";
    delBtn.className = "text-center text-2xl font-bolder inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150";
    delBtn.type = 'button';
    delBtn.innerHTML = '-';
    blocklist.appendChild(delBtn);
    updateOneSlider(rateSlider);
}
function updateBlocks() {
    let sliders = document.querySelectorAll(`input[type='range'][name^='block']`);
    for (const sl of sliders) {
        sl.max = maxRateSlider.value;
    }
}
function updateOneSlider(slider){
    let label = blocklist.querySelector(`label[id^='${slider.name}']`)
    label.innerHTML = slider.value;
}
let blocklist = document.querySelector('#blocklist');
let addBlockBtn = document.querySelector('#btn-addblock');
let maxRateSlider = document.querySelector('#blocks-maxrate');
let blocksNumber = 0;

if (planetblocks.length == 0) {
    addBlock('Air', 50);
}
for (const bl of planetblocks) {
    let rate = bl.pivot.rate
    addBlock(bl.name, rate);
    if (rate > maxRateSlider.value) {
        maxRateSlider.value = rate;
    }
}
addBlockBtn.addEventListener('click', (e)=>{
    addBlock('Air', 50);
    updateBlocks();
});
blocklist.addEventListener('input', (e)=>{
    const targ = e.target;
    if (targ.type == 'range') {
        updateOneSlider(targ);
    }
});
maxRateSlider.addEventListener('change', (e)=>{
    updateBlocks();
});
/*
<x-danger-button id="btn-delblock"
    class="text-center text-2xl font-bolder"
    type="button"
>{{ __('-') }}</x-danger-button>
*/
