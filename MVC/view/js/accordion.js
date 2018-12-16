function toggleAccordion(event){
    let accord = $(event.target).parent('.accord');
    let content = accord.find('.accord-content')[0];
    accord.toggleClass('accord-opened');
    if(content.style.maxHeight !== "0px"){
        content.style.maxHeight = "0px";
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
    }
    $("body, html").stop().animate({scrollTop:accord.offset().top},
    1000, 'swing');
}

function updateAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord label').on('click', toggleAccordion);
    $('.accord .accord-content').css('max-height', '0px');
}

function deleteAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord').remove();
}
