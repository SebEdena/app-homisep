function recupDonnéesMaison(event){
    let maison = event.target.value;

    $.ajax({
        url: "index.php?control=relationClient&action=recupPieces",
        type: "POST",
        dataType: "json",
        data: {
            idMaison: maison
        },
        success: function(retour){
            let formatted = JSON.parse(JSON.stringify(retour), (k,v) => {
                return (typeof v === "object" || isNaN(v)) ? v : parseInt(v, 10);
            });
            console.log(formatted);
            deleteAccordions();
            for (data of formatted) {
                $('.tabpage').append(build_piece(data));
            }
            updateAccordions();
        },
        error: function(error){
            console.log(error);
            alert("Une erreur est survenue : " + error);
        }
    });
}

function build_piece(data){
    return `
        <div class="accord" data-piece-id=${data['id']}>
            <label>${data['nom']}</label>
            <div class="accord-content">
                <h1>Bijour</h1>
            </div>
        </div>
    `;
}

$("#house-select").on('change', recupDonnéesMaison);
$("#house-select").trigger('change');
