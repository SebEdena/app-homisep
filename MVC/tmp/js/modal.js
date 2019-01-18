let modal_bg = document.querySelector(".modal-bg");
let modals = document.getElementsByClassName("modal");
let modal_closers = document.getElementsByClassName("modal-close");

window.onclick = function(event) {
    if(event.target == modal_bg) { hideModal(); }
}

for(let i = 0; i < modal_closers.length; i++){
    modal_closers[i].onclick = function(event){
        if(event.target.parentNode.parentNode.classList.contains('modal')){
            hideModal();
        }
    }
}

let displayModal = function(id){
    var displayedModal = document.querySelector(id);
    if(id != null){
        for (let i = 0; i < modals.length; i++) {
            modals[i].style.display = "none";
        }
        displayedModal.style.display = "block";
        modal_bg.style.display = "block";
    }
}

let hideModal = function(){
    for (let i = 0; i < modals.length; i++) {
        modals[i].style.display = "none";
    }
    modal_bg.style.display = "none";
}
