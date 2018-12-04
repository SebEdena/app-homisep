function toggleAccordion(event){
    let accord = $(event.target).parent('.accord');
    accord.toggleClass('accord-opened');
    $("body, html").stop().animate({scrollTop:accord.offset().top},
    1000, 'swing');
}

function updateAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord label').on('click', toggleAccordion);
}

function deleteAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord').remove();
}
