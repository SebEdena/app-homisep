const order = ['temp', 'lum', 'shut'];
let count = null;

function recupDonnéesMaison(event){
    let idMaison = parseInt(event.target.value);
    if(isNaN(idMaison))
    {
      return;
    }
    $.ajax({
        url: "index.php?control=relationClient&action=getDonneesMaison",
        type: "POST",
        dataType: "json",
        data: {
            idMaison: idMaison
        },
        success: function(retour){
            console.log(retour);
            build_pieces(retour.pieces);
            build_capteurs(retour);
            displayGeneralView(retour.pieces, retour.context, retour.cemacs);
            // $('.tablink.active').trigger('click');
        },
        error: function(error){
            console.error(error);
            alert("Une erreur est survenue : " + error.message);
        }
    });
}

function build_pieces(data){
    deleteAccordions();
    piecesMaison = {};
    $(".tabpage").html((data.length === 0)?"<h2>Pas de pièce.</h2>":"");
    for (piece of data) {
        inflate_piece(piece);
    }
    updateAccordions();
}

function inflate_piece(data){
    let piece = $(`
        <div class="accord piece" data-piece-id=${data['id']}>
            <label>${data['nom']}</label>
            <div class="accord-content">
                <h2>Pas de capteurs.</h2>
            </div>
        </div>
    `);
    piece.data('piece', data);
    $('.tabpage:not("#tabpage-gen")').append(piece);
}

function build_capteurs(data){
    for (piece of data.pieces) {
        for (categorie of order) {
            if(data.context[piece.id][categorie]['int']!=null){
                let context = data.context[piece.id][categorie]['int'];
                let hasActionneurs = (context.actionneur.length != 0);
                let hasCapteurs = (context.capteur.length != 0);
                inflate_capteur(true, null, piece.id, context, categorie, 'int', hasActionneurs, hasCapteurs);
            }
            if(data.context[piece.id][categorie]['ext']!=null){
                let context = data.context[piece.id][categorie]['ext'];
                let hasActionneurs = (context.actionneur.length != 0);
                let hasCapteurs = (context.capteur.length != 0);
                inflate_capteur(true, null, piece.id, context, categorie, 'ext', hasActionneurs, hasCapteurs);
            }
        }
    }
    for (cemac of data.cemacs) {
        inflate_capteur(false, null, cemac.id, cemac, cemac.typeCapteur.categorie, cemac.typeCapteur.categorie.exterieur);
    }
}

function inflate_capteur(grouped, target, id, context, categorie, ext, hasActionneurs=null, hasCapteurs=null){
    let isGrouped = (grouped == true);
    if(isGrouped == true){
        let cemacGrouped = $(`
            <div class="capt-gen">
                <div class="capt-title">${context.libelleGroupBy}</div>
                <div class="capt-content">
                    <div class="capt-menu">
                        <button disabled><img src="./view/img/menu-button-3.png"></img></button>
                    </div>
                    <div class="capt-status capt-error">M</div>
                    <div class="capt-auto-manual">
                        <button disabled>Auto</button>
                    </div>
                    <div class="capt-data-desired">
                        <div class="capt-dd-label">Désiré</div>
                        <div class="capt-value">80%</div>
                    </div>
                    <div class="capt-data-real">
                        <div class="capt-dr-label">Actuel</div>
                        <div class="capt-value">78%</div>
                    </div>
                    <div class="capt-buttons">
                        <button disabled><img src="./view/img/chevron-arrow-up.png"></button>
                        <button disabled><img src="./view/img/chevron-arrow-down.png"></button>
                    </div>
                </div>
            </div>
        `);
        if(!hasActionneurs){
            cemacGrouped.find('.capt-data-desired').remove();
            cemacGrouped.find('.capt-buttons').remove();
            cemacGrouped.find('.capt-auto-manual').remove();
            cemacGrouped.find('.capt-status').text('');
        }
        if(!hasCapteurs){
            cemacGrouped.find('.capt-data-real').remove();
        }
        if(context.statut){cemacGrouped.find('.capt-status').removeClass('capt-error');}
        cemacGrouped.data('cemacGroup', context);
        if(id !== null){
            cemacGrouped.data('idPiece', id);
            $("#tabpage-"+categorie).find('.piece[data-piece-id=' + id +'] > .accord-content > h2').remove();
            $("#tabpage-"+categorie).find('.piece[data-piece-id=' + id +'] > .accord-content').append(cemacGrouped);
        }else{
            target.append(cemacGrouped);
        }
    }else{
        console.log(context);
        let isCapteur = (context.typeCapteur.type==='capteur');
        let cemac = $(`
            <div class="capt-solo" data-capt-id=${id}>
                <div class="capt-title">${isCapteur?'Capteur':'Actionneur'} ${context.numeroSerie}</div>
                <div class="capt-content">
                    <div class="capt-menu-data-container">
                        <div class="capt-menu">
                            <button disabled><img src="./view/img/menu-button-3.png"></img></button>
                        </div>
                        <div class="capt-data-desired">
                            <div class="capt-dd-label">Désiré</div>
                            <div class="capt-value">80%</div>
                        </div>
                    </div>
                    <div class="capt-data-real">
                        <div class="capt-dr-label">Actuel</div>
                        <div class="capt-value">78%</div>
                    </div>
                    <div class="capt-buttons">
                        <button disabled><img src="./view/img/chevron-arrow-up.png"></button>
                        <button disabled><img src="./view/img/chevron-arrow-down.png"></button>
                    </div>
                    <div class="capt-status capt-error"></div>
                </div>
            </div>
        `);
        if(isCapteur){
            cemac.find('.capt-data-desired, .capt-buttons').remove();
        }else{
            cemac.find('.capt-data-real').remove();
        }
        if(context.statut){cemac.find('.capt-status').removeClass('capt-error');}
        cemac.data('cemac', context);
        $("#tabpage-"+categorie).find('.piece[data-piece-id=' + context.idPiece +'] > .accord-content').append(cemac);
    }
}

function openAccordions(event){
    $($('.tabpage')[$(this).index()]).find('.piece:not(.accord-opened) label').trigger('click');
}

function displayGeneralView(pieces, context, cemacs){
    console.log("disp");
    const links = { lumint: 'lightbulb.png', lumext: 'lightbulb.png', tempint: 'thermometer.png', tempext: 'thermometer.png', shut: 'blinds.png'}
    count = {lumint: null, lumext: null, tempint: null, tempext: null, shut: null};
    const countOrder=['lumint', 'lumext', 'tempint', 'tempext', 'shut'];

    for(let cemac of cemacs){
        let aggreg = cemac.typeCapteur.categorie;
        if(cemac.typeCapteur.categorie !== "shut"){
            aggreg += cemac.typeCapteur.exterieur;
        }
        if(count[aggreg] == null){
            count[aggreg] = {capteur:[], actionneur:[], libelleGroupBy:cemac.typeCapteur.libelleGroupBy, status:true}
        }
        count[aggreg][cemac.typeCapteur.type].push(cemac.id);
        count[aggreg].status = count[aggreg].status && cemac.statut;
    }


    console.log(count);

    for(let order of countOrder){
        if(count[order] != null){
            let gen_status = $("<div class='gen-status'></div>");
            let summary = $(`
                <div class="data-summary" id="${order}">
                    <div class="summary-left">
                        <img src="./view/img/${links[order]}"></img>
                        <p>${count[order].libelleGroupBy}</p>
                    </div>
                    <div class="summary-right">
                        <p>Capteurs : ${count[order].capteur.length}</p>
                        <p>Actionneurs : ${count[order].actionneur.length}</p>
                    </div>
                </div>
            `);
            summary.data('cemacs', count[order]);
            gen_status.append(summary);
            inflate_capteur(true, gen_status, null, count[order], null, null, count[order].actionneur.length !== 0, count[order].capteur.length !== 0);
            $("#tabpage-gen").append(gen_status);
        }
    }
}

$("#house-select").on('change', recupDonnéesMaison);
$("#house-select").trigger('change');
$('.tablink').on('click', openAccordions);
