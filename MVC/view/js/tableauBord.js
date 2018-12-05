function recupDonnéesMaison(event){
    let idMaison = event.target.value;

    get_pieces(idMaison, ()=>{get_capteurs(idMaison);});
}

function get_pieces(idMaison, afterHandler){
    $.ajax({
        url: "index.php?control=relationClient&action=recupPieces",
        type: "POST",
        dataType: "json",
        data: {
            idMaison: idMaison
        },
        success: function(retour){
            let formatted = JSON.parse(JSON.stringify(retour), (k,v) => {
                return (typeof v === "object" || isNaN(v)) ? v : parseInt(v, 10);
            });
            console.log(formatted);
            deleteAccordions();
            $(".tabpage").html((formatted.length === 0)?"<h2>Pas de pièce.</h2>":"");
            for (data of formatted) {
                $('.tabpage').append(build_piece(data));
            }
            updateAccordions();
            afterHandler(idMaison, null);
        },
        error: function(error){
            console.error(error);
            alert("Une erreur est survenue : " + error);
        }
    });
}

function get_capteurs(idMaison, afterHandler){
    console.log("hello");
    // $.ajax({
    //     url: "index.php?control=relationClient&action=recupCapteurs",
    //     type: "POST",
    //     dataType: "json",
    //     data: {
    //         idMaison: maison
    //     },
    //     success: function(retour){
    //         let formatted = JSON.parse(JSON.stringify(retour), (k,v) => {
    //             return (typeof v === "object" || isNaN(v)) ? v : parseInt(v, 10);
    //         });
    //         console.log(formatted);
    //         deleteAccordions();
    //         $(".tabpage").html((formatted.length === 0)?"<h2>Pas de pièce.</h2>":"");
    //         for (data of formatted) {
    //             $('.tabpage').append(build_piece(data));
    //         }
    //         updateAccordions();
    //         afterHandler(idMaison);
    //     },
    //     error: function(error){
    //         console.error(error);
    //         alert("Une erreur est survenue : " + error);
    //     }
    // });
}

function build_piece(data){
    return `
        <div class="accord" data-piece-id=${data['id']}>
            <label>${data['nom']}</label>
            <div class="accord-content">
                <h2>Pas de capteurs.</h2>
            </div>
        </div>
    `;
}

function build_capteur(solo){

}

$("#house-select").on('change', recupDonnéesMaison);
$("#house-select").trigger('change');
