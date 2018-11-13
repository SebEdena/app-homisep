var modal_bg = $(".modal-bg")[0];
var modals = $(".modal");

$(window).on('click', function(event) {
    if(event.target == modal_bg) {
        hideModal();
    }
});

$(".modal-close").on('click', function(event){
    if($(event.target).parent().parent().hasClass('modal')){
        hideModal();
    }
});

let displayModal = function(id){
    if($(id).length == 1){
        $(modals).css("display","none");
        $(id).css("display","block");
        $(modal_bg).css("display","block");
    }
}

let hideModal = function(){
    $(modals).css("display","none");
    $(modal_bg).css("display","none");
}
