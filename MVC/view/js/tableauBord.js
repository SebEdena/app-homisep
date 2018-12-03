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
            for (data of formatted) {
                $('.tabcontent').append(build_piece(data));
            }
        },
        error: function(error){
            console.log(error);
            alert("Une erreur est survenue : " + error);
        }
    });
}

function build_piece(data){
    return `
        <div class="accord-piece" data-piece-id=${data['id']}>
            <input type="checkbox" id="title">
            <label for="title">${data['nom']}</label>
            <div id="piece-content">
                <h1>Bijour</h1>
            </div>
        </div>
    `;
}

$("#house-select").on('change', recupDonnéesMaison);
$("#house-select").trigger('change');
