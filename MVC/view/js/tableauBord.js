const order = ['temp', 'lum', 'shut'];
let count = null;

function recupDonnéesMaison(event){
    let idMaison = parseInt(event.target.value);
    if(isNaN(idMaison))
    {
      return;
    }
    console.log(idMaison);
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
            displayGeneralView(retour.pieces, retour.context);
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
                inflate_capteur(true, piece.id, data, categorie, 'int');
            }
            if(data.context[piece.id][categorie]['ext']!=null){
                inflate_capteur(true, piece.id, data, categorie, 'ext');
            }
        }
    }
    for (cemac of data.cemacs) {
        inflate_capteur(false, cemac.id, cemac, cemac.typeCapteur.categorie, cemac.typeCapteur.categorie.exterieur);
    }
}

function inflate_capteur(grouped, id, data, categorie, ext){
    let isGrouped = (grouped == true);
    if(isGrouped == true){
        let context = data.context[id][categorie][ext];
        let hasActionneurs = (context.actionneur.length != 0);
        let hasCapteurs = (context.capteur.length != 0);
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
        cemacGrouped.data('idPiece', id);
        $("#tabpage-"+categorie).find('.piece[data-piece-id=' + id +'] > .accord-content > h2').remove();
        $("#tabpage-"+categorie).find('.piece[data-piece-id=' + id +'] > .accord-content').append(cemacGrouped);
    }else{
        let isCapteur = (data.typeCapteur.type==='capteur');
        let cemac = $(`
            <div class="capt-solo" data-capt-id=${id}>
                <div class="capt-title">${isCapteur?'Capteur':'Actionneur'} ${data.numeroSerie}</div>
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
        if(data.statut){cemac.find('.capt-status').removeClass('capt-error');}
        cemac.data('cemac', data);
        $("#tabpage-"+categorie).find('.piece[data-piece-id=' + data.idPiece +'] > .accord-content').append(cemac);
    }
}

function openAccordions(event){
    $($('.tabpage')[$(this).index()]).find('.piece:not(.accord-opened) label').trigger('click');
}

function displayGeneralView(pieces, context){
    const links = { lumint: 'lightbulb.png', lumext: 'lightbulb.png', tempint: 'thermometer.png', tempext: 'thermometer.png', shutint: 'blinds.png'}
    count = {lumint: null, lumext: null, tempint: null, tempext: null, shut: null};
    const countOrder=['lumint', 'lumext', 'tempint', 'tempext', 'shut'];

    for(let piece of pieces){
        for(let categ of order){
            let data = context[piece['id']][categ]['int'];
            if(data != null && count.hasOwnProperty(categ+'int')){
                if(count[categ+'int'] == null){
                    count[categ+'int'] = {capteur: data.capteur, actionneur: data.actionneur, libelle: data.libelleGroupBy};
                }else{
                    count[categ+'int'].capteur.push.apply(count[categ+'int'].capteur, data.capteur);
                    count[categ+'int'].actionneur.push.apply(count[categ+'int'].actionneur, data.actionneur);
                }
            }
            data = context[piece['id']][categ]['ext'];
            if(data != null && count.hasOwnProperty(categ+'ext')){
                if(count[categ+'ext'] == null){
                    count[categ+'ext'] = {capteur: data.capteur, actionneur: data.actionneur, libelle: data.libelleGroupBy};
                }else{
                    count[categ+'ext'].capteur.push.apply(count[categ+'ext'].capteur, data.capteur);
                    count[categ+'ext'].actionneur.push.apply(count[categ+'ext'].actionneur, data.actionneur);
                }
            }
        }
    }

    for(let order of countOrder){
        if(count[order] != null){
            let summary = $(`
                <div class="data-summary" id="${order}">
                    <div class="summary-left">
                        <img src="./view/img/${links[order]}"></img>
                        <p>${count[order].libelle}</p>
                    </div>
                    <div class="summary-right">
                        <p>Moyenne : </p>
                        <p>Capteurs : ${count[order].capteur.length}</p>
                        <p>Actionneurs : ${count[order].actionneur.length}</p>
                    </div>
                </div>
            `);
            summary.data('cemacs', count[order]);
            console.log(summary);
            console.log(document.getElementById("tabgen-content") == undefined);
            if(document.getElementById("tabgen-content") == undefined)
            {
              let divTabgen = document.createElement('div');
              divTabgen.id = 'tabgen-content';
              $("#tabpage-gen").append(divTabgen);
            }
            $("#tabgen-content").append(summary);
        }
    }
}

$("#house-select").on('change', recupDonnéesMaison);
$("#house-select").trigger('change');
$('.tablink').on('click', openAccordions);
