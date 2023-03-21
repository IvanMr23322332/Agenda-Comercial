
function editarAdmin(id_sop){
    var arrayCampos = document.getElementsByClassName('editarTarifa'+id_sop);
    for(var i=0; i<arrayCampos.length; i++){
        if(arrayCampos[i].tagName.toLowerCase() === 'input'){
            arrayCampos[i].removeAttribute("readonly");
        }
        else{
            arrayCampos[i].style.display = 'block';
        }
    }
    document.getElementById('editar'+id_sop).style.display = 'none';
    document.getElementById('home'+id_sop).style = "padding-bottom: 30px;";
}

function cancelarAdmin(id_sop){
    window.location.reload();
}

function calcularTotalDTO(id_sop, id_dur){
    var array = document.getElementsByClassName('totalClass'+id_sop+id_dur);
    if(document.getElementById('desc'+id_sop+'_'+id_dur).value < 0){
        document.getElementById('desc'+id_sop+'_'+id_dur).value = 0;
    }
    else if (document.getElementById('desc'+id_sop+'_'+id_dur).value > 100) {
        document.getElementById('desc'+id_sop+'_'+id_dur).value = 100;
    }
    for(var i = 0; i < array.length; i++){
        var id_tar = array[i].getAttribute('data-tar');
        var aux = document.getElementById('prec'+id_tar+'_'+id_dur+'_'+id_sop).value - (document.getElementById('prec'+id_tar+'_'+id_dur+'_'+id_sop).value * document.getElementById('desc'+id_sop+'_'+id_dur).value / 100);
        array[i].value = aux.toFixed(2);
    }
}

function calcularTotalTAR(id_tar, id_dur, id_sop){
    var aux1 = document.getElementById('prec'+id_tar+'_'+id_dur+'_'+id_sop).value;
    if(aux1 < 0){
        aux1 = 0;
    }
    var aux2 = aux1 - (aux1 * document.getElementById('desc'+id_sop+'_'+id_dur).value / 100);
    document.getElementById('prec'+id_tar+'_'+id_dur+'_'+id_sop).value = parseFloat(aux1).toFixed(2);
    document.getElementById('total'+id_tar+id_dur).value = aux2.toFixed(2);
}
