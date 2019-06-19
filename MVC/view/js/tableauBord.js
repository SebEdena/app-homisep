const order = ['temp', 'lum', 'shut'];
let count = null;

  /**
   * fonction peremttant de récupérer les données de la maison (pièces, toutes les informations des CeMacs)
   * @param event évènement déclancheur
   */
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
            $('.tablink.active').trigger('click');
        },
        error: function(error){
            console.error(error);
            alert("Une erreur est survenue : " + error.message);
        }
    });
}

  /**
   * fonction peremttant de créer la vue des pièces
   * @param data données des pièces
   */
function build_pieces(data){
    deleteAccordions();
    piecesMaison = {};
    $(".tabpage").html((data.length === 0)?"<h2>Pas de pièce.</h2>":"");
    for (piece of data) {
        inflate_piece(piece);
    }
    updateAccordions();
}

  /**
   * fonction peremttant de créer la vue des pièces
   * @param data données des pièces
   */
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

  /**
   * fonction permettant de créer la vue pour les CeMacs
   * @param data données des CeMacs
   */
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
        inflate_capteur(false, null, cemac.id, cemac, cemac.typeCapteur.categorie, cemac.typeCapteur.exterieur);
    }
}

  /**
   * fonction permettant de créer le code pour le html pour les CeMacs
   * @param grouped booléen CeMac groupé (actionneur et capteur) ou simple (actionneur ou capteur)
   * @param target noeud html parent du capteur
   * @param id identifiant de la pièce
   * @param context données du CeMac
   * @param categorie catégorie de CeMac (luminosité/température/volet)
   * @param ext Cemac exterieur ou intérieur
   * @param hasActionneurs booléen pour dire s'il y a des actionneurs
   * @param hasCapteurs booléen pour dire s'il y a des capteurs
   */
function inflate_capteur(grouped, target, id, context, categorie, ext, hasActionneurs=null, hasCapteurs=null){
    let isGrouped = (grouped == true);
    if(isGrouped == true){
        let moyA = approxMean(context.moyActionneur, context.grandeur);
        let moyC = approxMean(context.moyCapteur, context.grandeur);
        let cemacGrouped = $(`
            <div class="capt-gen ${categorie + ext}">
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
                        <div class="capt-value">${wrapNullValue(moyA) + context.grandeur.symbole}</div>
                    </div>
                    <div class="capt-data-real">
                        <div class="capt-dr-label">Actuel</div>
                        <div class="capt-value">${wrapNullValue(moyC) + context.grandeur.symbole}</div>
                    </div>
                    <div class="capt-buttons">
                        <button class="btnUp"><img class="btnUp" src="./view/img/chevron-arrow-up.png"></button>
                        <button class="btnDown"><img class="btnDown" src="./view/img/chevron-arrow-down.png"></button>
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
        cemacGrouped.data('cemac', context);
        cemacGrouped.data('valeur', moyA);
        cemacGrouped.data('grandeur', context.grandeur);
        cemacGrouped.find('.capt-buttons button').on('click', (event) => updateValue(cemacGrouped, true, (event.target.classList.contains('btnUp'))));
        if(id !== null){
            cemacGrouped.data('idPiece', id);
            $("#tabpage-"+categorie).find('.piece[data-piece-id=' + id +'] > .accord-content > h2').remove();
            $("#tabpage-"+categorie).find('.piece[data-piece-id=' + id +'] > .accord-content').append(cemacGrouped);
        }else{
            cemacGrouped.addClass('gen-view');
            target.append(cemacGrouped);
        }
    }else{
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
                            <div class="capt-value">${wrapNullValue(context.typeCapteur.valeur) + context.typeCapteur.grandeur.symbole}</div>
                        </div>
                    </div>
                    <div class="capt-data-real">
                        <div class="capt-dr-label">Actuel</div>
                        <div class="capt-value">${wrapNullValue(context.typeCapteur.valeur) + context.typeCapteur.grandeur.symbole}</div>
                    </div>
                    <div class="capt-buttons">
                        <button class="btnUp"><img class="btnUp" src="./view/img/chevron-arrow-up.png"></button>
                        <button class="btnDown"><img class="btnDown" src="./view/img/chevron-arrow-down.png"></button>
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
        cemac.data('valeur', context.typeCapteur.valeur);
        cemac.data('grandeur', context.typeCapteur.grandeur);
        cemac.find('.capt-buttons button').on('click', (event) => updateValue(cemac, false, (event.target.classList.contains('btnUp'))));

        $("#tabpage-"+categorie).find('.piece[data-piece-id=' + context.idPiece +'] > .accord-content > .capt-gen.'+categorie+ext).after(cemac);
        //.addAfter(cemac);
    }
}

  /**
   * fonction perttant de déplier le contenu de l'accordéon
   * @param évènement déclancheur
   */
function openAccordions(event){
    $($('.tabpage')[$(this).index()]).find('.piece:not(.accord-opened) label').trigger('click');
}

  /**
   * fonction permettant d'afficher les CeMacs dans le tableau de bord
   * @param pieces liste des pièces
   * @param context données
   * @param cemacs liste des cemacs
   */
function displayGeneralView(pieces, context, cemacs){
    const links = { lumint: 'lightbulb.png', lumext: 'lightbulb.png', tempint: 'thermometer.png', tempext: 'thermometer.png', shut: 'blinds.png'}
    count = {lumint: null, lumext: null, tempint: null, tempext: null, shut: null};
    const countOrder=['lumint', 'lumext', 'tempint', 'tempext', 'shut'];

    for(let cemac of cemacs){
        let aggreg = cemac.typeCapteur.categorie;
        if(cemac.typeCapteur.categorie !== "shut"){
            aggreg += cemac.typeCapteur.exterieur;
        }
        if(count[aggreg] == null){
            count[aggreg] = {capteur:[], actionneur:[], cemacs:[], moyActionneur: null, moyCapteur: null, typeCapteur:cemac.typeCapteur, libelleGroupBy:cemac.typeCapteur.libelleGroupBy, grandeur: cemac.typeCapteur.grandeur, valeur: null, status:true};
            if(cemac.typeCapteur.type === "actionneur") count[aggreg].moyActionneur = cemac.typeCapteur.valeur;
            if(cemac.typeCapteur.type === "capteur") count[aggreg].moyCapteur = cemac.typeCapteur.valeur;
        }else{
            if(cemac.typeCapteur.type === "actionneur") count[aggreg].moyActionneur += cemac.typeCapteur.valeur;
            if(cemac.typeCapteur.type === "capteur") count[aggreg].moyCapteur = cemac.typeCapteur.valeur;
        }
        count[aggreg][cemac.typeCapteur.type].push(cemac.id);
        count[aggreg].cemacs.push(cemac.id);
        count[aggreg].status = count[aggreg].status && cemac.statut;
    }

    for(let order of countOrder){
        if(count[order] != null){
            if(count[order].actionneur.length !== 0){
                count[order].moyActionneur = approxMean(count[order].moyActionneur/count[order].actionneur.length, count[order].grandeur);
            }
            if(count[order].capteur.length !== 0){
                count[order].moyCapteur = approxMean(count[order].moyCapteur/count[order].capteur.length, count[order].grandeur);
            }
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
            gen_status.append(summary);
            inflate_capteur(true, gen_status, null, count[order], order, "", count[order].actionneur.length !== 0, count[order].capteur.length !== 0);
            $("#tabpage-gen").append(gen_status);
        }
    }
}

  /**
   * fonction permettant de sauvegarder les modifications faites par l'utilisateur
   */
function saveActionneurChanges(){
    let values = [];
    $(".gen-view").each((i, elt) => {
        if($(elt).data('cemac').actionneur.length > 0){
            for(let act of $(elt).data('cemac').actionneur){
                values.push({idCemac:act, valeur: $(".capt-solo[data-capt-id="+ act +"]").data('valeur')});
            }
        }
    });
    $.ajax({
        url: "index.php?control=relationClient&action=updateActionneurs",
        type: "POST",
        dataType: "json",
        data: {
            valeurs: values
        },
        success: function(retour){
            console.log(retour);
            alert("Les changements ont été enregistrés.");
        },
        error: function(error){
            console.error(error);
            alert("Une erreur est survenue : " + JSON.parse(JSON.stringify(error)).message);
        }
    });
}

  /**
   * fonction permettant la mise à jour d'une donnée
   * @param cemac noeud html du cemac
   * @param grouped booléen si le CeMac a des fonctions multiples
   * @param up booléen si la valeur est supérieure à la précédente ou inférieure
   */
function updateValue(cemac, grouped, up){
    let grandeur = cemac.data('grandeur');
    let actualValue = cemac.data('valeur');
    let categ = null;
    if(grouped && !cemac.hasClass('gen-view')){
        categ = cemac.data('cemac').typeCapteur;
    } else {
        categ = cemac.data('cemac').typeCapteur.categorie + cemac.data('cemac').typeCapteur.exterieur;
    }
    if(grouped){
        let value = computeValue(actualValue + (up?(1):(-1))*grandeur.pas, up, grandeur);
        cemac.data('valeur', value);
        cemac.find('.capt-data-desired .capt-value').text(wrapNullValue(cemac.data('valeur')) + grandeur.symbole);
        for(let id of cemac.data('cemac').actionneur){
            let act = $(".capt-solo[data-capt-id=" + id + "]");
            act.data('valeur', value);
            act.find('.capt-data-desired .capt-value').text(value + grandeur.symbole);
        }
        if(cemac.hasClass("gen-view")) {
            $(".capt-gen." + categ).each((index, elt)=>computeMean($(elt)));
        }else{
            computeMean($(".gen-view.capt-gen." + categ));
        }
    }else{
        cemac.data('valeur', computeValue(actualValue + (up?(1):(-1))*grandeur.pas, up, grandeur));
        cemac.find('.capt-data-desired .capt-value').text(wrapNullValue(cemac.data('valeur')) + grandeur.symbole);
        computeMean(cemac.parent().find('.capt-gen.'+categ));
        computeMean($(".gen-view.capt-gen." + categ));
    }
}

  /**
   * fonction permettant de calculer la nouvelle valeur
   * @param value la valeur
   * @param up booléen si la valeur est supérieure à la précédente ou inférieure
   * @param grandeur unité de la valeur
   */
function computeValue(value, up, grandeur){
    if(up){
        if(value >= grandeur.borneSup){
            return grandeur.borneSup;
        }else{
            return value;
        }
    }else{
        if(value <= grandeur.borneInf){
            return grandeur.borneInf;
        }else{
            return value;
        }
    }
}

  /**
   * fonction permettant de calculer la moyenne
   * @param cemac noeud html des CeMacs
   */
function computeMean(cemac){
    let mean = 0;
    let actionneurs = cemac.data('cemac').actionneur;
    if(actionneurs.length > 0){
        for(cemacId of actionneurs){
            mean += $(".capt-solo[data-capt-id=" + cemacId + "]").data('valeur')
        }
        mean = approxMean(mean/(actionneurs.length), cemac.data('grandeur'));
        cemac.data('valeur', mean);
        cemac.find('.capt-data-desired .capt-value').text(wrapNullValue(mean) + cemac.data('grandeur').symbole);
    }
}

  /**
   * fonction permettant de calculer une approximation de la moyenne
   * @param valeur la valeur
   * @param grandeur unité physique de la valeur
   */
function approxMean(valeur, grandeur){
    let times = Math.floor(valeur / grandeur.pas)
    let delta = (valeur - times*grandeur.pas);
    if(delta < (grandeur.pas/2)){
        return times*grandeur.pas;
    }else{
        return (times+1)*grandeur.pas;
    }
}

function wrapNullValue(value) {
    if(isNaN(value) || value==null){
        return "--";
    } else {
        return value;
    }
}

$("#house-select").on('change', recupDonnéesMaison);
$("#house-select").trigger('change');
$("#save-tdb").on('click', saveActionneurChanges);
$('.tablink').on('click', openAccordions);
