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
  console.log(event.target);
  if(event.target !== this){
      event.preventDefault();
      return false;
  }
});
