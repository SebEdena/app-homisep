$('#contactCGU').on('click', (event)=>{
    displayModal('#modalCGU');
});

$('#contentCGU').css({'overflow-y' : 'scroll' , 'height' : '400px'});


$('#contactPolitique').on('click', (event)=>{
    displayModal('#modalPolitique');
});

$('#contentPolitique').css({'overflow-y' : 'scroll' , 'height' : '400px'});

$('#contactMention').on('click', (event)=>{
    displayModal('#modalMention');
});

$('#contentMention').css({'overflow-y' : 'scroll' , 'height' : '400px'});

$(".cbx").on('click', (event)=>{
  if(event.target.hasAttribute("href")){
      event.preventDefault();
      return false;
  }
});
