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

  /**
   * fonction permettant la mise à jour des accordéons en terme de style
   */
function updateAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord label').on('click', toggleAccordion);
    $('.accord .accord-content').css('max-height', '0px');
}

  /**
   * fonction permettant de supprimer les accordéons
   */
function deleteAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord').remove();
}

$(window).on('resize', (event) => {
    for(let accordCt of $(".accord .accord-content")){
        if(accordCt.style.maxHeight !== "0px"){
            accordCt.style.maxHeight = accordCt.scrollHeight + "px";
        }
    }
});
