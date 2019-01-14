$('#contactCGU').on('click', (event)=>{
    displayModal('#modalCGU');
});

$('#contactPolitique').on('click', (event)=>{
    displayModal('#modalPolitique');
});

$(".cbx").on('click', (event)=>{
  console.log(event.target);
  if(event.target !== this){
      event.preventDefault();
      return false;
  }
});
