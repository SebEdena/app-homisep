function toggleAccordion(event){
    let accord = $(event.target).parent('.accord');
    let content = accord.find('.accord-content')[0];
    accord.toggleClass('accord-opened');
    console.log('here');
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
    let accords = $('.accord.accord-opened');
    accords.removeClass('accord-opened');
    $('.accord .accord-content').css('max-height', '0px');
    accords.find('label').trigger("click");

    // $.each($('.accord.accord-opened .accord-content'), (key, content)=>{
    //     content.style.maxHeight = content.scrollHeight + "px";
    // });

    // for(accordion in $('.accord.accord-opened .accord-content')){
    //     accordion[i].style.maxHeight = accordion[0].scrollHeight+"px";
    // }
}

function deleteAccordions(){
    $('.accord label').off('click', toggleAccordion);
    $('.accord').remove();
}
