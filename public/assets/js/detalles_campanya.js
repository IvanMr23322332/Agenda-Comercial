function formato(n){
    var val = Math.round(Number(n) *100) / 100;
    var parts = val.toString().split(".");
    var num = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (parts[1] ? "," + parts[1] : "");

    return num;
}

function add_linea() {

    var flag = false;
    var soporte          = document.getElementById('sop');
    var tarifa           = document.getElementById('tar');
    var num_cun          = document.getElementById('ncu');
    var duracion         = document.getElementById('dur');
    var fechaini         = document.getElementById('fechaini');
    var fechafin         = document.getElementById('fechafin');
    var facturacionAnual = document.getElementById('factAnual');
    var antiguedad       = document.getElementById('antig');

    if (soporte.value.length == 0) {
        document.getElementById('err_sop').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_sop').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (tarifa.value.length == 0) {
        document.getElementById('err_tar').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_tar').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (num_cun.value.length == 0 || num_cun.value <= 0) {
        document.getElementById('err_ncu').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_ncu').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (duracion.value.length == 0) {
        document.getElementById('err_dur').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_dur').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (facturacionAnual.value.length == 0) {
        document.getElementById('err_fact').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_fact').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (antiguedad.value.length == 0) {
        document.getElementById('err_antig').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_antig').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (fechaini.value.length == 0) {
        document.getElementById('err_ini').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_ini').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (fechafin.value.length == 0) {
        document.getElementById('err_fin').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_fin').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (fechaini.value >= fechafin.value) {
        document.getElementById('err_ini').style = "display: block; font-size: 0.75rem; color: red;";
        document.getElementById('err_fin').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_ini').style = "display: none; font-size: 0.75rem; color: red;";
        document.getElementById('err_fin').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (flag) {
        return;
    }


    var numLineas = document.getElementById('numSop').value;
    numLineas ++;
    document.getElementById('numSop').value = numLineas;
    var contador = document.getElementById('contador').value;
    contador ++;
    document.getElementById('true_cont').value = parseInt(document.getElementById('true_cont').value, 10) + 1;
    document.getElementById('contador').value = contador;
    document.getElementById('opt_empty_list').innerHTML += "<input type='number' class='form-control' style='display: none;' id='opt_empty"+contador+"' name='opt_empty"+contador+"' value='1'>"
    var linea_tabla = "<tr class='filasTabla' id=fila" + contador + ">";
    linea_tabla += "<td><input id=soporte" + contador + " name=soporte" + contador + " data-id='" + soporte.options[soporte.selectedIndex].getAttribute('name') + "' type='text' readonly style='border: none; width: 100%' value='" + soporte.value + "'><input type='number' name='sop_id"+contador+"' value='" + soporte.options[soporte.selectedIndex].getAttribute('name') + "' style='display: none;'></td>";
    linea_tabla += "<td><input id=tarifa"  + contador + " name=tarifa"  + contador + " data-id='" + tarifa.options[tarifa.selectedIndex].getAttribute('name') +"' type='text' readonly style='border: none; width: 100%' value='" + tarifa.value + "'><input type='number' name='tar_id"+contador+"' value='" + tarifa.options[tarifa.selectedIndex].getAttribute('name') + "' style='display: none;'></td>";
    linea_tabla += "<td><input id=ncunya" + contador + " name=ncunya" + contador + " type='text' readonly style='border: none; width: 100%' value='" + num_cun.value + "'></td>";
    linea_tabla += "<td><input id=duracion" + contador + " name=duracion" + contador + " data-id='"+ duracion.options[duracion.selectedIndex].getAttribute('name') +"' type='text' readonly style='border: none; width: 100%' value='" + duracion.value + "'><input type='number' name='dur_id"+contador+"' value='" + duracion.options[duracion.selectedIndex].getAttribute('name') + "' style='display: none;'></td>";
    linea_tabla += "<td><input id=fechaini" + contador + " name=fechaini" + contador + " type='text' readonly style='border: none; width: 100%' value='" + fechaini.value + "'></td>";
    linea_tabla += "<td><input id=fechafin" + contador + " name=fechafin" + contador + " type='text' readonly style='border: none; width: 100%' value='" + fechafin.value + "'></td>";
    linea_tabla += "<td><input id=desc" + contador + " name=desc" + contador + " type='text' readonly style='border: none; width: 100%' value='Sin Datos'></td>";
    linea_tabla += "<td><input id=neto" + contador + " name=neto" + contador + " type='text' readonly style='border: none; width: 100%' value='Sin Datos'></td>";
    linea_tabla += "<td><img onclick='editar(" + contador + "," + soporte.options[soporte.selectedIndex].getAttribute('name') + ")' class='icono_opciones edit_line' style='margin-right:30px' src='/assets/img/lapiz.png' width='30px' height='30px' alt='Modificar Linea' title='Modificar Linea'> <img class='icono_opciones edit_line' style='margin-right:30px' data-toggle='modal' data-target='.sop"+soporte.options[soporte.selectedIndex].getAttribute('name')+"' src='/assets/img/optico.png' width='30px' height='30px' alt='Ver Óptico' title='Ver Óptico'> <img onclick='cambiarTarget(" + contador + ", "+ soporte.options[soporte.selectedIndex].getAttribute('name') +")' class='icono_opciones edit_line' data-toggle='modal' data-target='#basicModal' src='/assets/img/cubo.png' width='30px' height='30px' alt='Eliminar Linea' title='Eliminar Linea'> </td>";
    linea_tabla += "</tr><input type='number' id='total_cunyas"+contador+"' value='"+num_cun.value+"' style='display: none;'>";
    document.getElementById('inter_tabla').innerHTML += linea_tabla;


    first_mes_opt(contador, soporte.options[soporte.selectedIndex].getAttribute('name'), tarifa.options[tarifa.selectedIndex].getAttribute('name'));
    modificarDescuento();

    document.getElementById('sop').selectedIndex = 0;
    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('ncu').value = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('fechaini').value = 0;
    document.getElementById('fechafin').value = 0;
    document.getElementById('des').value = 0;
    document.getElementById('net').value = 0;

    var tar_array = document.getElementsByClassName('tar_presupuestos');
    var dur_array = document.getElementsByClassName('dur_presupuestos');

    for(var i = 0; i < tar_array.length; i++){
        tar_array[i].style.display = 'none';
    }
    dur_array[0].style.display = 'none';
    dur_array[1].style.display = 'none';
    dur_array[2].style.display = 'none';
    dur_array[3].style.display = 'none';
    dur_array[4].style.display = 'none';
    dur_array[5].style.display = 'none';
    dur_array[6].style.display = 'none';

    calcularDescuento();
}


function cambiarTarget(contador, id_sop){
    document.getElementById('target').value = contador;
    document.getElementById('targetSop').value = id_sop;
}

function eliminar(){
    var contador = document.getElementById('target').value;
    var id_sop = document.getElementById('targetSop').value;
    var elem = document. getElementById("fila" + contador). remove();
    var total = document.getElementById("total_cunyas" + contador).remove();
    document.getElementById('opt_empty'+contador).remove();
    var numLineas = document.getElementById('numSop').value;
    numLineas --;

    var tabla = document.getElementById('opt_tabla'+id_sop).rows;
    for(var i = 0; i < tabla.length; i++){
        if(tabla[i].getAttribute('data-linea')==contador){
            if(tabla[i].id.includes("val")){
                document.getElementById('opt_cont'+id_sop).value = parseInt(document.getElementById('opt_cont'+id_sop).value, 10) - 1;
                document.getElementById(tabla[i].id).remove();
            }
        }
    }

    var a_borrar = [];

    for(var i = 0; i < tabla.length; i++){
        if(tabla[i].id.includes("mes") && tabla[i+1] === undefined){

            a_borrar.push(tabla[i].id);
        }
        else if(tabla[i].id.includes("mes") && tabla[i+1].id.includes("mes")){

            a_borrar.push(tabla[i].id);
        }

    }
    for(var i = 0; i < a_borrar.length; i++){
        document.getElementById('opt_cont'+id_sop).value = parseInt(document.getElementById('opt_cont'+id_sop).value, 10) - 1;
        document.getElementById(a_borrar[i]).remove();
    }

    document.getElementById('contador_cunyas_restantes'+contador).remove();

    document.getElementById('true_cont').value = parseInt(document.getElementById('true_cont').value, 10) - 1;

    var tabla = document.getElementById('opt_tabla'+id_sop).rows;
    if (tabla.length == 0){
        document.getElementById('contSop').value--;
        calcularDescuento();
    }
    modificarDescuento();
}

function cancel_edit(){
    if(document.getElementById('load_button')){
        document.getElementById('load_button').hidden = false;
    }
    document.getElementById('add_button').hidden = false;
    document.getElementById('botonEdit').hidden = true;

    document.getElementById('sop').selectedIndex = 0;
    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('ncu').value = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('fechaini').value = 0;
    document.getElementById('fechafin').value = 0;
    document.getElementById('des').value = 0;
    document.getElementById('net').value = 0;

    var lineas = document.getElementsByClassName("edit_line");
    for (let i = 0; i < lineas.length; i++) {
      lineas[i].hidden = false;
    }

    document.getElementById('isEdit').value = 1;

    calcularDescuento();
}

function save_edit(){
    var contador = document.getElementById('target').value;
    var soporte = document.getElementById('targetSop').value;

    if(document.getElementById('load_button')){
        document.getElementById('load_button').hidden = false;
    }
    document.getElementById('add_button').hidden = false;
    document.getElementById('botonEdit').hidden = true;

    document.getElementById('soporte' + contador).value     = document.getElementById('sop').value;
    document.getElementById('tarifa' + contador).value      = document.getElementById('tar').value;
    document.getElementById('ncunya' + contador).value      = document.getElementById('ncu').value;
    document.getElementById('duracion' + contador).value    = document.getElementById('dur').value;
    document.getElementById('fechaini' + contador).value    = document.getElementById('fechaini').value;
    document.getElementById('fechafin' + contador).value    = document.getElementById('fechafin').value;

    document.getElementById('isEdit').value = 1;

    eliminar();
    add_linea();

    document.getElementById('sop').selectedIndex = 0;
    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('ncu').value = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('fechaini').value = 0;
    document.getElementById('fechafin').value = 0;
    document.getElementById('des').value = 0;
    document.getElementById('net').value = 0;

    var lineas = document.getElementsByClassName("edit_line");
    for (let i = 0; i < lineas.length; i++) {
      lineas[i].hidden = false;
    }

    calcularDescuento();
}

function editar(contador,soporte){
    cambiarTarget(contador,soporte);

    document.getElementById('isEdit').value = 0;

    var lineas = document.getElementsByClassName("edit_line");
    for (let i = 0; i < lineas.length; i++) {
      lineas[i].hidden = true;
    }

    if(document.getElementById('load_button')){
        document.getElementById('load_button').hidden = true;
    }
    document.getElementById('add_button').hidden = true;
    document.getElementById('botonEdit').hidden = false;

    document.getElementById('sop').value      = document.getElementById('soporte' + contador).value;
    onChangeSoporte();
    document.getElementById('tar').value      = document.getElementById('tarifa' + contador).value;
    onChangeTarifa();
    document.getElementById('ncu').value      = document.getElementById('ncunya' + contador).value;
    document.getElementById('dur').value      = document.getElementById('duracion' + contador).value;
    document.getElementById('fechaini').value = document.getElementById('fechaini' + contador).value;
    document.getElementById('fechafin').value = document.getElementById('fechafin' + contador).value;
    calcularDescuento();
}

function getWeekDay(dia, mes, anyo){
    var d = new Date(""+ mes +" "+ dia +", "+ anyo +" 01:15:00");
    var day = d.getDay();

    var weekDay = "D";
    if ( day == 1 ){
        weekDay = "L";
    }
    if ( day == 2 ){
        weekDay = "M";
    }
    if ( day == 3 ){
        weekDay = "X";
    }
    if ( day == 4 ){
        weekDay = "J";
    }
    if ( day == 5 ){
        weekDay = "V";
    }
    if ( day == 6 ){
        weekDay = "S";
    }

    return weekDay;
}

function calcularLinea(month, daysInMonth, mesini, id_tar, id_linea, anyini, year, current_day) {
    //console.log("Llamada a calc linea");
    var aux = 0, cont_rest = 0;
    var contador = parseInt(document.getElementById('contador_cunyas'+id_linea).value, 10);
    var total = document.getElementById('total_cunyas'+id_linea).value;

    var m = mesini;
    var y = anyini;
    while(document.getElementById('total'+m+id_linea+y)){
        for (var i = 1; i <= daysInMonth; i++) {
            if(document.getElementById(m+'val'+i+id_linea)){
                if(current_day != i && !isNaN(parseInt(document.getElementById(m+'val'+i+id_linea).value, 10))){
                    cont_rest = cont_rest + parseInt(document.getElementById(m+'val'+i+id_linea).value, 10);
                }
            }
        }
        if(m == 11){
            m = 0;
            y++;
        }
        else{
            m++;
        }
    }
    //console.log("Cont_rest: "+cont_rest);

    var cont_fin = total - cont_rest;
    //console.log(current_day);
    for (var i = 1; i <= daysInMonth; i++) {
        if(document.getElementById(month+'val'+i+id_linea)){
            if(Number.isInteger(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10))) {
                if(current_day == i){
                    //console.log("prueba 1");
                    if(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) <= cont_fin){
                        //console.log("entra");
                        aux += parseInt(document.getElementById(month+'val'+i+id_linea).value, 10);
                    } else {
                        //console.log("no entra");
                        document.getElementById(month+'val'+i+id_linea).value = 0;
                    }
                } else {
                    aux += parseInt(document.getElementById(month+'val'+i+id_linea).value, 10);
                }
            }
        }
    }

    // for (var i = 1; i <= daysInMonth; i++) {
    //     if(document.getElementById(month+'val'+i+id_linea)){
    //         if(Number.isInteger(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10))) {
    //             if(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) > 99 && parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) <= cont_fin){
    //                 if(current_day == i){
    //                     document.getElementById(month+'val'+i+id_linea).value = 99;
    //                 }
    //                 aux += 99;
    //
    //             }
    //             else if(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) > 99 && parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) > cont_fin && cont_fin > 99){
    //                 if(current_day == i){
    //                     document.getElementById(month+'val'+i+id_linea).value = 99;
    //                 }
    //                 aux += 99;
    //
    //             }
    //             else if(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) > 99 && parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) > cont_fin && cont_fin <= 99){
    //                 if(current_day == i){
    //                     document.getElementById(month+'val'+i+id_linea).value = cont_fin;
    //                     aux = aux + cont_fin;
    //                 } else {
    //                     aux = aux + parseInt(document.getElementById(month+'val'+i+id_linea).value, 10);
    //                 }
    //
    //             }
    //             else if(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) <= 99 && parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) > cont_fin){
    //                 if(current_day == i){
    //                     document.getElementById(month+'val'+i+id_linea).value = cont_fin;
    //                     aux = aux + cont_fin;
    //                 } else {
    //                     aux = aux + parseInt(document.getElementById(month+'val'+i+id_linea).value, 10);
    //                 }
    //
    //             }
    //             else if(parseInt(document.getElementById(month+'val'+i+id_linea).value, 10) < 0){
    //                 if(current_day == i){
    //                     document.getElementById(month+'val'+i+id_linea).value = 0;
    //                 }
    //
    //             }
    //             else{
    //                 aux += parseInt(document.getElementById(month+'val'+i+id_linea).value, 10);
    //
    //             }
    //         }
    //     }
    // }
    //console.log("Aux = " + aux);
    document.getElementById('total'+month+id_linea+year).value = aux;
    var m = mesini;
    var y = anyini;
    var sumatotal = 0;
    while(document.getElementById('total'+m+id_linea+y)){
        sumatotal += parseInt(document.getElementById('total'+m+id_linea+y).value, 10);
        if(m == 11){
            m = 0;
            y++;
        }
        else{
            m++;
        }
    }
    if(sumatotal == total) {
        document.getElementById('opt_empty'+id_linea).value = 0;
    } else {
        document.getElementById('opt_empty'+id_linea).value = 1;
    }
    //console.log("La suma total es de " + sumatotal);
    document.getElementById('contador_cunyas'+id_linea).value = total - sumatotal;
}

function getMonthESP(month) {
    var act_mes = "a";

    if(month == 0) {
        act_mes = "ENERO";
    }
    if(month == 1) {
        act_mes = "FEBRERO";
    }
    if(month == 2) {
        act_mes = "MARZO";
    }
    if(month == 3) {
        act_mes = "ABRIL";
    }
    if(month == 4) {
        act_mes = "MAYO";
    }
    if(month == 5) {
        act_mes = "JUNIO";
    }
    if(month == 6) {
        act_mes = "JULIO";
    }
    if(month == 7) {
        act_mes = "AGOSTO";
    }
    if(month == 8) {
        act_mes = "SEPTIEMBRE";
    }
    if(month == 9) {
        act_mes = "OCTUBRE";
    }
    if(month == 10) {
        act_mes = "NOVIEMBRE";
    }
    if(month == 11) {
        act_mes = "DICIEMBRE";
    }

    return act_mes;
}

function getMonthENG(month) {
    var act_mes_eng = "a";

    if(month == 0) {
        act_mes_eng = "JANUARY";
    }
    if(month == 1) {
        act_mes_eng = "FEBRUARY";
    }
    if(month == 2) {
        act_mes_eng = "MARCH";
    }
    if(month == 3) {
        act_mes_eng = "APRIL";
    }
    if(month == 4) {
        act_mes_eng = "MAY";
    }
    if(month == 5) {
        act_mes_eng = "JUNE";
    }
    if(month == 6) {
        act_mes_eng = "JULY";
    }
    if(month == 7) {
        act_mes_eng = "AUGUST";
    }
    if(month == 8) {
        act_mes_eng = "SEPTEMBER";
    }
    if(month == 9) {
        act_mes_eng = "OCTOBER";
    }
    if(month == 10) {
        act_mes_eng = "NOVEMBER";
    }
    if(month == 11) {
        act_mes_eng = "DECEMBER";
    }

    return act_mes_eng;
}

function first_mes_opt(id_linea, id_sop, id_tar) {

    var i, x, y, linea;

    var fechaini = document.getElementById('fechaini'+id_linea).value;
    var fechafin = document.getElementById('fechafin'+id_linea).value;
    var partsIni =fechaini.split('-');
    var partsFin =fechafin.split('-');
    var dateini = new Date(partsIni[0], partsIni[1] - 1, partsIni[2]);
    var datefin = new Date(partsFin[0], partsFin[1] - 1, partsFin[2]);

    var tabla = document.getElementById('opt_tabla'+id_sop).rows;
    if (tabla.length == 0){
        document.getElementById('contSop').value++;
        if(document.getElementById('acc_name')){
            calcularDescuentoAccCom();
        } else {
            calcularDescuento();
        }
    }

    document.getElementById('contadores'+id_sop).innerHTML += "<div id='contador_cunyas_restantes"+id_linea+"' class='table-responsive' style='float: right; width: 172px; text-align: center;'><table class='table table-bordered'><thead style='background-color: #27e397;'><th><b>Nº Cuñas Restantes "+document.getElementById('tarifa'+id_linea).value+"</b></th></thead><tbody><tr><td align='center'><input id='contador_cunyas"+id_linea+"' type='number' style='width: 30px; border: 0;' value='"+document.getElementById('ncunya' + id_linea).value+"' readonly></td></tr></tbody></table></div>";


    for (i = dateini.getMonth(), x = dateini.getFullYear(); i <= datefin.getMonth() || x < datefin.getFullYear(); i++) {
        if( i == 12 ){
            i = 0;
            x++;
        }
        act_mes = getMonthESP(i);
        act_mes_eng = getMonthENG(i);

        var daysInMonth = new Date(x, i+1, 0).getDate();

        if (document.getElementById('mes' + x + i + id_sop)){
            document.getElementById('opt_cont'+id_sop).value = parseInt(document.getElementById('opt_cont'+id_sop).value, 10) + 1;
            var doc = document.getElementById('mes' + x + i + id_sop);

            var min_linea = 99999;

            var tabla = document.getElementById('opt_tabla'+id_sop).rows;

            for(var k = 0; k < tabla.length; k++){
                if(tabla[k].id.includes('val'+i)){
                    if(tabla[k].getAttribute('data-linea') < min_linea){
                        min_linea = tabla[k].getAttribute('data-linea');
                    }
                }
            }

            y = min_linea;

            var aux = 0;
            while(aux < id_linea){
                if(document.getElementById('val'+i+"_"+x+"_"+aux+"_"+id_sop) && y < aux){
                    y = aux;
                }
                aux++;
            }
            var tarifa = document.getElementById('tarifa'+id_linea);
            var duracion = document.getElementById('duracion'+id_linea)
            linea = "<tr id=val"+i+"_"+x+"_"+id_linea+"_"+id_sop+" data-linea='"+id_linea+"' data-anyo='"+x+"' data-mes='"+i+"'><input type='number' class='form-control' style='display: none;' name='id_lin"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' value='"+id_linea+"'><td><input type='text' id='matricula"+i+id_linea+"' name='matricula"+i+"_"+x+"_"+id_linea+"' style='width: 100px; border: 0;' readonly></td><td><input type='text' name='dur"+i+id_linea+"' id='dur"+i+id_linea+"' style='width: 60px; border: 0; text-align: center;' value='"+document.getElementById('duracion'+id_linea).value+"' readonly><input type='number' name='dur_opt_id"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' value='" + duracion.getAttribute('data-id') + "' style='display: none;'></td><td><input type='text' id='tar"+i+id_linea+"' name='tar"+i+id_linea+"' style='width: 100px; border: 0; text-align: center;' value='"+document.getElementById('tarifa'+id_linea).value+"' readonly><input type='number' name='tar_opt_id"+i+"_"+x+"_"+id_linea+"' value='" + tarifa.getAttribute('data-id') + "' style='display: none;'></td><td><input type='text' id='hora"+i+id_linea+"' name='hora"+i+"_"+x+"_"+id_linea+"' style='width: 40px; border: 0;'></td>";
            for (var j = 1; j <= 31; j++) {
                if(j <= daysInMonth) {
                    if(i == dateini.getMonth() && x == dateini.getFullYear() && j>=dateini.getDate()){
                        linea = linea + "<td style='padding: 0;' align='center'><input type='number' id='"+i+"val"+j+id_linea+"' name='val"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' onchange='calcularLinea("+i+" ,"+daysInMonth+" ,"+dateini.getMonth()+" ,"+id_tar+" ,"+id_linea+" ,"+dateini.getFullYear()+" ,"+x+" ,"+j+")' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'></td>";
                    }
                    else if(i == dateini.getMonth() && x == dateini.getFullYear() && j<dateini.getDate()){
                        linea = linea + "<td style='padding: 0; background-color: #c7c7c7;' align='center'></td>";
                    }
                    else if(i == datefin.getMonth() && x == datefin.getFullYear() && j<=datefin.getDate()){
                        linea = linea + "<td style='padding: 0;' align='center'><input type='number' id='"+i+"val"+j+id_linea+"' name='val"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' onchange='calcularLinea("+i+" ,"+daysInMonth+" ,"+dateini.getMonth()+" ,"+id_tar+" ,"+id_linea+" ,"+dateini.getFullYear()+" ,"+x+" ,"+j+")' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'></td>";
                    }
                    else if(i == datefin.getMonth() && x == datefin.getFullYear() && j>datefin.getDate()){
                        linea = linea + "<td style='padding: 0; background-color: #c7c7c7;' align='center'></td>";
                    }
                    else{
                        linea = linea + "<td style='padding: 0;' align='center'><input type='number' id='"+i+"val"+j+id_linea+"' name='val"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' onchange='calcularLinea("+i+" ,"+daysInMonth+" ,"+dateini.getMonth()+" ,"+id_tar+" ,"+id_linea+" ,"+dateini.getFullYear()+" ,"+x+" ,"+j+")' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'></td>";
                    }
                }
                else{
                    linea = linea + "<td> </td>";
                }
            }
            linea = linea + "<td><input id='total"+i+id_linea+x+"' name='total"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' type='number' style='width: 30px; border: 0; text-align: center;' value=0 readonly></td></tr>";

            document.getElementById('val'+i+"_"+x+"_"+y+"_"+id_sop).insertAdjacentHTML('afterend', linea);
        }
        else{

            document.getElementById('opt_cont'+id_sop).value = parseInt(document.getElementById('opt_cont'+id_sop).value, 10) + 2;

            linea = "<tr id=mes" + x + i + id_sop +" data-linea='"+id_linea+"' data-anyo='"+x+"' data-mes='"+i+"' style='background-color: #a0dec5'><td colspan='4' style='padding-left: 10px;' ><input type='text' id='mes_name"+i+"_"+x+"_"+id_sop+"' name='mes_name"+i+"_"+x+"_"+id_sop+"' value='"+act_mes+"' readonly style='border: none; background-color: #a0dec5; padding: none;'></td>";
            for (var j = 1; j <= 31; j++) {
                if(j <= daysInMonth) {
                    var weekDay = getWeekDay(j, act_mes_eng, x);
                    if(weekDay == "S" || weekDay == "D"){
                        linea = linea + "<td style='background-color: #decda0; padding: 2px;' align='center'><input type='text' id='dia"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' name='dia"+j+"_"+i+"_"+x+"_"+id_sop+"' value='"+weekDay+"' readonly style='border: none; background-color: #decda0; text-align: center; width: 30px; padding: none;'></td>";
                    }
                    else{
                        linea = linea + "<td style='padding: 2px;' align='center'><input type='text' id='dia"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' name='dia"+j+"_"+i+"_"+x+"_"+id_sop+"' value='"+weekDay+"' readonly style='border: none; background-color: #a0dec5; text-align: center; width: 30px; padding: none;'></td>";
                    }
                }
                else{
                    linea = linea + "<td> </td>";
                }
            }
            linea = linea + "<td> </td></tr>";

            var tarifa = document.getElementById('tarifa'+id_linea);
            var duracion = document.getElementById('duracion'+id_linea)
            linea += "<tr id=val"+i+"_"+x+"_"+id_linea+"_"+id_sop+" data-linea='"+id_linea+"' data-anyo='"+x+"' data-mes='"+i+"'><input type='number' class='form-control' style='display: none;' name='id_lin"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' value='"+id_linea+"'><td><input type='text' id='matricula"+i+id_linea+"' name='matricula"+i+"_"+x+"_"+id_linea+"' style='width: 100px; border: 0;' readonly></td><td><input type='text' id='dur"+i+id_linea+"' style='width: 60px; border: 0; text-align: center;' value='"+ document.getElementById('duracion'+id_linea).value +"' readonly><input type='number' name='dur_opt_id"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' value='" + duracion.getAttribute('data-id') + "' style='display: none;'></td><td><input type='text' id='tar"+i+id_linea+"' style='width: 100px; border: 0; text-align: center;' value='"+document.getElementById('tarifa'+id_linea).value+"' readonly><input type='number' name='tar_opt_id"+i+"_"+x+"_"+id_linea+"' value='" + tarifa.getAttribute('data-id') + "' style='display: none;'></td><td><input type='text' id='hora"+i+id_linea+"' name='hora"+i+"_"+x+"_"+id_linea+"' style='width: 40px; border: 0;'></td>";
            for (var j = 1; j <= 31; j++) {
                if(j <= daysInMonth) {
                    if(i == datefin.getMonth() && x == datefin.getFullYear() && j>datefin.getDate()){
                        linea = linea + "<td style='padding: 0; background-color: #c7c7c7;' align='center'></td>";
                    }
                    else if(i == dateini.getMonth() && x == dateini.getFullYear() && j<dateini.getDate()){
                        linea = linea + "<td style='padding: 0; background-color: #c7c7c7;' align='center'></td>";
                    }
                    else if(i == datefin.getMonth() && x == datefin.getFullYear() && j<=datefin.getDate()){
                        linea = linea + "<td style='padding: 0;' align='center'><input type='number' id='"+i+"val"+j+id_linea+"' name='val"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' onchange='calcularLinea("+i+" ,"+daysInMonth+" ,"+dateini.getMonth()+" ,"+id_tar+" ,"+id_linea+" ,"+dateini.getFullYear()+" ,"+x+" ,"+j+")' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'></td>";
                    }
                    else if(i == dateini.getMonth() && x == dateini.getFullYear() && j>=dateini.getDate()){
                        linea = linea + "<td style='padding: 0;' align='center'><input type='number' id='"+i+"val"+j+id_linea+"' name='val"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' onchange='calcularLinea("+i+" ,"+daysInMonth+" ,"+dateini.getMonth()+" ,"+id_tar+" ,"+id_linea+" ,"+dateini.getFullYear()+" ,"+x+" ,"+j+")' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'></td>";
                    }
                    else{
                        linea = linea + "<td style='padding: 0;' align='center'><input type='number' id='"+i+"val"+j+id_linea+"' name='val"+j+"_"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' onchange='calcularLinea("+i+" ,"+daysInMonth+" ,"+dateini.getMonth()+" ,"+id_tar+" ,"+id_linea+" ,"+dateini.getFullYear()+" ,"+x+" ,"+j+")' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'></td>";
                    }
                }
                else{
                    linea = linea + "<td> </td>";
                }
            }
            linea = linea + "<td><input id='total"+i+id_linea+x+"' name='total"+i+"_"+x+"_"+id_sop+"_"+id_linea+"' type='number' style='width: 30px; border: 0; text-align: center;' value=0 readonly></td></tr>";

            var arry = [];
            var tabla = document.getElementById('opt_tabla'+id_sop).rows;

            for(var k = 0; k < tabla.length; k++){
                arry.push([parseInt(tabla[k].getAttribute('data-anyo'),10),parseInt(tabla[k].getAttribute('data-mes'),10)]);
            }

            arry.push([x,i]);

            arry.sort(function(a,b){
                if (a[0] < b[0]) return -1;
                if (a[0] > b[0]) return  1;
                if (a[1] > b[1]) return  1;
                if (a[1] < b[1]) return -1;
            });

            for(var k = 0; k < arry.length; k++){
                if(arry[k][0] == x && arry[k][1] == i){
                    break;
                }
            }

            if(tabla[k] == null){
                document.getElementById('opt_tabla'+id_sop).innerHTML += linea;
            }
            else{

                if(k==0){
                    document.getElementById(tabla[k].id).insertAdjacentHTML('beforebegin', linea);
                }
                else{
                    document.getElementById(tabla[k].id).insertAdjacentHTML('beforebegin', linea);
                }
            }
        }
    }
}

function onChangeSoporte(){

    var sop = document.getElementById('sop');
    var sop_id = sop.options[sop.selectedIndex].getAttribute('name');

    var tar, tar_id;
    var tar_array = document.getElementsByClassName('tar_presupuestos');

    for(var i = 0; i < tar_array.length; i++){
        if(tar_array[i].dataset.sop == sop_id){
            tar_array[i].style.display = 'block';
        }
        else{
            tar_array[i].style.display = 'none';
        }
    }

    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('net').value = "";

    calcularDescuento();
}

function onChangeTarifa(){

    var tar = document.getElementById('tar');
    var tar_id = tar.options[tar.selectedIndex].getAttribute('name');
    var tar_sop = tar.options[tar.selectedIndex].getAttribute('data-sop');

    var dur, dur_id;
    var dur_array = document.getElementsByClassName('dur_presupuestos');

    switch (tar_sop) {
        case '1':
            switch (tar_id) {
                case '1':
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'block';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
                default:
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
            }
            break;
        case '2':
            switch (tar_id) {
                case '13':
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'block';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
                default:
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
            }
            break;
        case '3':
            dur_array[0].style.display = 'none';
            dur_array[1].style.display = 'none';
            dur_array[2].style.display = 'none';
            dur_array[3].style.display = 'none';
            dur_array[4].style.display = 'none';
            dur_array[5].style.display = 'none';
            dur_array[6].style.display = 'none';
            dur_array[7].style.display = 'block';
            break;
        case '4':
            switch (tar_id) {
                case '24':
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'none';
                    dur_array[2].style.display = 'none';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
                case '25':
                    dur_array[0].style.display = 'none';
                    dur_array[1].style.display = 'none';
                    dur_array[2].style.display = 'none';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'block';
                    dur_array[6].style.display = 'block';
                    dur_array[7].style.display = 'none';
                    break;
                default:
                    dur_array[0].style.display = 'none';
                    dur_array[1].style.display = 'none';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
            }
            break;
        default:
            dur_array[0].style.display = 'none';
            dur_array[1].style.display = 'none';
            dur_array[2].style.display = 'none';
            dur_array[3].style.display = 'none';
            dur_array[4].style.display = 'none';
            dur_array[5].style.display = 'none';
            dur_array[6].style.display = 'none';
            dur_array[7].style.display = 'none';
            break;
    }

    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('net').value = "";

    calcularDescuento();
}

function calcularDescuento(){
    var fact_anu   = document.getElementById('factAnual').value;
    var antig      = document.getElementById('antig').value;
    var pront_pago = document.getElementById('prontoPago');
    var cont_sop   = parseInt(document.getElementById('contSop').value, 10);
    var edit_sop   = parseInt(document.getElementById('isEdit').value, 10);

    var desc_anu = 0;
    var desc_ant = 0;
    var desc_pro = 0;
    var desc_sop = 0;

    if(fact_anu >= 2500 && fact_anu < 5000){
        desc_anu = 5;
    }
    else if(fact_anu >= 5000 && fact_anu < 7500){
        desc_anu = 7;
    }
    else if(fact_anu >= 7500 && fact_anu < 15000){
        desc_anu = 8;
    }
    else if(fact_anu >= 15000){
        desc_anu = 10;
    }

    if(antig >= 2 && antig < 4){
        desc_ant = 3;
    }
    else if(antig >= 4){
        desc_ant = 5;
    }

    if(pront_pago.checked){
        desc_pro = 5;
    }

    if(cont_sop == 2){
        desc_sop = 4;
    }
    else if(cont_sop == 3){
        desc_sop = 6;
    }
    else if(cont_sop >= 4){
        desc_sop = 8;
    }

    var dto1 = 0;
    var dto2 = desc_ant + desc_anu + desc_pro + desc_sop;

    var sop = document.getElementById('sop');
    if(sop.value != 0){
        var dur = document.getElementById('dur');
        if(dur.value != 0){
            var dur_id = dur.options[dur.selectedIndex].getAttribute('name');
            var tar = document.getElementById('tar');
            var tar_id = tar.options[tar.selectedIndex].getAttribute('name');
            var sop_id = sop.options[sop.selectedIndex].getAttribute('name');
            var precio = parseFloat(document.getElementById('precio'+tar_id+dur_id).innerText);
            dto1 = parseFloat(document.getElementById('desc'+sop_id+dur_id).innerText);
        }
    }

    dto1 = (100 - dto1)/100;
    dto2 = (100 - dto2)/100;

    var ncunyas = document.getElementById('ncu').value;
    var descuento = (1 - (dto1 * dto2)) * 100;
    var precio_final = precio*ncunyas - ((precio*ncunyas)*descuento/100);
    document.getElementById('des').value = descuento.toFixed(2);
    if(!isNaN(precio_final)){
        document.getElementById('net').value = (precio_final*1.21).toFixed(2);
    }
    else{
        document.getElementById('net').value = "";
    }
}

function modificarDescuento(){
    var tabla = document.getElementById('inter_tabla').rows;
    for(var i=0; i<tabla.length; i++){
        var id = tabla[i].id.replace("fila","");
        var fact_anu   = document.getElementById('factAnual').value;
        var antig      = document.getElementById('antig').value;
        var pront_pago = document.getElementById('prontoPago');
        var cont_sop   = document.getElementById('contSop').value;

        var desc_anu = 0;
        var desc_ant = 0;
        var desc_pro = 0;
        var desc_sop = 0;

        if(fact_anu >= 2500 && fact_anu < 5000){
            desc_anu = 5;
        }
        else if(fact_anu >= 5000 && fact_anu < 7500){
            desc_anu = 7;
        }
        else if(fact_anu >= 7500 && fact_anu < 15000){
            desc_anu = 8;
        }
        else if(fact_anu >= 15000){
            desc_anu = 10;
        }

        if(antig >= 2 && antig < 4){
            desc_ant = 3;
        }
        else if(antig >= 4){
            desc_ant = 5;
        }

        if(pront_pago.checked){
            desc_pro = 5;
        }

        if(cont_sop == 2){
            desc_sop = 4;
        }
        else if(cont_sop == 3){
            desc_sop = 6;
        }
        else if(cont_sop >= 4){
            desc_sop = 8;
        }

        var dto2 = desc_ant + desc_anu + desc_pro + desc_sop;

        var this_sop_id = document.getElementById('soporte'+id).getAttribute('data-id');
        var this_tar_id = document.getElementById('tarifa'+id).getAttribute('data-id');
        var this_dur_id = document.getElementById('duracion'+id).getAttribute('data-id');
        var precio = parseFloat(document.getElementById('precio'+this_tar_id+this_dur_id).innerText);
        var dto1 = parseFloat(document.getElementById('desc'+this_sop_id+this_dur_id).innerText);

        dto1 = (100 - dto1)/100;
        dto2 = (100 - dto2)/100;

        var descuento = (1 - (dto1 * dto2)) * 100;
        var ncunyas = parseInt(document.getElementById('ncunya'+id).value,10);
        var precio_final = precio*ncunyas - ((precio*ncunyas)*descuento/100);
        document.getElementById('desc'+id).value = descuento.toFixed(2);
        document.getElementById('neto'+id).value = (precio_final*1.21).toFixed(2);
    }

    calcularTotal();
}

function calcularTotal(){
    var auxbrut = 0;
    var totalbrut = 0;
    var totalneto = 0;
    var arrayFilas = document.getElementsByClassName('filasTabla');
    for(var i = 0; i < arrayFilas.length; i++){
        totalneto += parseFloat(arrayFilas[i].children[7].children[0].value);
        totalbrut += parseFloat((arrayFilas[i].children[7].children[0].value/1.21)) / ( 1 - (parseFloat(arrayFilas[i].children[6].children[0].value)/100));
        auxbrut += parseFloat(arrayFilas[i].children[7].children[0].value) / ( 1 - (parseFloat(arrayFilas[i].children[6].children[0].value)/100));
    }
    document.getElementById('totalbrut').value = formato(totalbrut.toFixed(2)) + " €";
    document.getElementById('totalneto').value = formato(totalneto.toFixed(2)) + " €";
    document.getElementById('totaldesc').value = (100 - (totalneto / auxbrut * 100)).toFixed(2) + " %";
}



function submitForm(input) {

    validar_pago();
    calcularTotal();

    var flag = false;
    var razon_social     = document.getElementById('razon_social');
    var emisora          = document.getElementById('emisora');
    var cliente          = document.getElementById('cliente_anunciante');
    var facturacionAnual = document.getElementById('factAnual');
    var antiguedad       = document.getElementById('antig');
    var accion_com       = document.getElementById('acc');

    if(input.id == "finish") {
        if (razon_social.value.length == 0) {
            $.jGrowl("Por Favor, indique la Razón Social en la SECCION 1 para poder crear el presupuesto", { header: 'ERROR: Información insuficiente', theme: 'failure' }, 6000);
            flag = true;
        }
        if (emisora.value.length == 0) {
            $.jGrowl("Por Favor, indique la Emisora en la SECCION 1 para poder crear el presupuesto", { header: 'ERROR: Información insuficiente', theme: 'failure' }, 6000);
            flag = true;
        }
        if (cliente.value.length == 0) {
            $.jGrowl("Por Favor, indique el Anunciante en la SECCION 2 para poder crear el presupuesto", { header: 'ERROR: Información insuficiente', theme: 'failure' }, 6000);
            flag = true;
        }
        if (!document.getElementById(cliente.value)) {
            $.jGrowl("Por Favor, indique un Anunciante en la SECCION 2 que sea válido para crear el presupuesto", { header: 'ERROR: Información errónea', theme: 'failure' }, 6000);
            flag = true;
        }
        if (facturacionAnual.value.length == 0) {
            document.getElementById('err_fact').style = "display: block; font-size: 0.75rem; color: red;";
            flag = true;
        }
        else {
            document.getElementById('err_fact').style = "display: none; font-size: 0.75rem; color: red;";
        }
        if (antiguedad.value.length == 0) {
            document.getElementById('err_antig').style = "display: block; font-size: 0.75rem; color: red;";
            flag = true;
        }
        else {
            document.getElementById('err_antig').style = "display: none; font-size: 0.75rem; color: red;";
        }
        if (document.getElementById('true_cont').value == 0) {
            document.getElementById('err_tabla').style = "display: block; font-size: 0.75rem; color: red;";
            flag = true;
        }
        else {
            document.getElementById('err_tabla').style = "display: none; font-size: 0.75rem; color: red;";
        }

        if (!flag) {
            document.guardar_presupuesto.submit();
        }
    }
}

function add_linea_acccom() {

    var flag = false;
    var soporte          = document.getElementById('sop');
    var tarifa           = document.getElementById('tar');
    var num_cun          = document.getElementById('ncu');
    var duracion         = document.getElementById('dur');
    var fechaini         = document.getElementById('fechaini');
    var fechafin         = document.getElementById('fechafin');

    if (soporte.value.length == 0) {
        document.getElementById('err_sop').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_sop').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (tarifa.value.length == 0) {
        document.getElementById('err_tar').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_tar').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (num_cun.value.length == 0 || num_cun.value <= 0) {
        document.getElementById('err_ncu').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_ncu').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (duracion.value.length == 0) {
        document.getElementById('err_dur').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_dur').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (fechaini.value.length == 0) {
        document.getElementById('err_ini').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_ini').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (fechafin.value.length == 0) {
        document.getElementById('err_fin').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_fin').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (fechaini.value >= fechafin.value) {
        document.getElementById('err_ini').style = "display: block; font-size: 0.75rem; color: red;";
        document.getElementById('err_fin').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_ini').style = "display: none; font-size: 0.75rem; color: red;";
        document.getElementById('err_fin').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (flag) {
        return;
    }


    var numLineas = document.getElementById('numSop').value;
    numLineas ++;
    document.getElementById('numSop').value = numLineas;
    var contador = document.getElementById('contador').value;
    contador ++;
    document.getElementById('true_cont').value = parseInt(document.getElementById('true_cont').value, 10) + 1;
    document.getElementById('contador').value = contador;
    var linea_tabla = "<tr class='filasTabla' id=fila" + contador + ">";
    linea_tabla += "<td><input id=soporte" + contador + " name=soporte" + contador + " data-id='" + soporte.options[soporte.selectedIndex].getAttribute('name') + "' type='text' readonly style='border: none; width: 100%' value='" + soporte.value + "'><input type='number' name='sop_id"+contador+"' value='" + soporte.options[soporte.selectedIndex].getAttribute('name') + "' style='display: none;'></td>";
    linea_tabla += "<td><input id=tarifa"  + contador + " name=tarifa"  + contador + " data-id='" + tarifa.options[tarifa.selectedIndex].getAttribute('name') +"' type='text' readonly style='border: none; width: 100%' value='" + tarifa.value + "'><input type='number' name='tar_id"+contador+"' value='" + tarifa.options[tarifa.selectedIndex].getAttribute('name') + "' style='display: none;'></td>";
    linea_tabla += "<td><input id=ncunya" + contador + " name=ncunya" + contador + " type='text' readonly style='border: none; width: 100%' value='" + num_cun.value + "'></td>";
    linea_tabla += "<td><input id=duracion" + contador + " name=duracion" + contador + " data-id='"+ duracion.options[duracion.selectedIndex].getAttribute('name') +"' type='text' readonly style='border: none; width: 100%' value='" + duracion.value + "'><input type='number' name='dur_id"+contador+"' value='" + duracion.options[duracion.selectedIndex].getAttribute('name') + "' style='display: none;'></td>";
    linea_tabla += "<td><input id=fechaini" + contador + " name=fechaini" + contador + " type='text' readonly style='border: none; width: 100%' value='" + fechaini.value + "'></td>";
    linea_tabla += "<td><input id=fechafin" + contador + " name=fechafin" + contador + " type='text' readonly style='border: none; width: 100%' value='" + fechafin.value + "'></td>";
    linea_tabla += "<td><input id=desc" + contador + " name=desc" + contador + " type='text' readonly style='border: none; width: 100%' value='Sin Datos'></td>";
    linea_tabla += "<td><input id=neto" + contador + " name=neto" + contador + " type='text' readonly style='border: none; width: 100%' value='Sin Datos'></td>";
    linea_tabla += "<td><img onclick='editarAccCom(" + contador + "," + soporte.options[soporte.selectedIndex].getAttribute('name') + ")' class='icono_opciones edit_line' style='margin-right:30px' src='/assets/img/lapiz.png' width='30px' height='30px' alt='Modificar Linea' title='Modificar Linea'><img onclick='cambiarTarget(" + contador + ", "+ soporte.options[soporte.selectedIndex].getAttribute('name') +")' class='icono_opciones edit_line' data-toggle='modal' data-target='#basicModal' src='/assets/img/cubo.png' width='30px' height='30px' alt='Eliminar Linea' title='Eliminar Linea'> </td>";
    linea_tabla += "</tr><input type='number' id='total_cunyas"+contador+"' value='"+num_cun.value+"' style='display: none;'>";
    document.getElementById('inter_tabla').innerHTML += linea_tabla;

    var tabla = document.getElementById('opt_tabla'+soporte.options[soporte.selectedIndex].getAttribute('name'));
    if (tabla.value == 0){
        document.getElementById('contSop').value++;
        calcularDescuentoAccCom();
    }

    first_mes_opt(contador, soporte.options[soporte.selectedIndex].getAttribute('name'), tarifa.options[tarifa.selectedIndex].getAttribute('name'));
    modificarDescuentoAccCom();

    document.getElementById('sop').selectedIndex = 0;
    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('ncu').value = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('fechaini').value = 0;
    document.getElementById('fechafin').value = 0;
    document.getElementById('des').value = 0;
    document.getElementById('net').value = 0;

    var tar_array = document.getElementsByClassName('tar_presupuestos');
    var dur_array = document.getElementsByClassName('dur_presupuestos');

    for(var i = 0; i < tar_array.length; i++){
        tar_array[i].style.display = 'none';
    }
    dur_array[0].style.display = 'none';
    dur_array[1].style.display = 'none';
    dur_array[2].style.display = 'none';
    dur_array[3].style.display = 'none';
    dur_array[4].style.display = 'none';
    dur_array[5].style.display = 'none';
    dur_array[6].style.display = 'none';

    calcularDescuentoAccCom();
}

function onChangeSoporteAccCom(){

    var sop = document.getElementById('sop');
    var sop_id = sop.options[sop.selectedIndex].getAttribute('name');

    var tar, tar_id;
    var tar_array = document.getElementsByClassName('tar_presupuestos');

    for(var i = 0; i < tar_array.length; i++){
        if(tar_array[i].dataset.sop == sop_id){
            tar_array[i].style.display = 'block';
        }
        else{
            tar_array[i].style.display = 'none';
        }
    }

    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('net').value = "";

    calcularDescuentoAccCom();
}

function onChangeTarifaAccCom(){

    var tar = document.getElementById('tar');
    var tar_id = tar.options[tar.selectedIndex].getAttribute('name');
    var tar_sop = tar.options[tar.selectedIndex].getAttribute('data-sop');

    var dur, dur_id;
    var dur_array = document.getElementsByClassName('dur_presupuestos');

    switch (tar_sop) {
        case '1':
            switch (tar_id) {
                case '1':
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'block';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
                default:
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
            }
            break;
        case '2':
            switch (tar_id) {
                case '13':
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'block';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
                default:
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'block';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
            }
            break;
        case '3':
            dur_array[0].style.display = 'none';
            dur_array[1].style.display = 'none';
            dur_array[2].style.display = 'none';
            dur_array[3].style.display = 'none';
            dur_array[4].style.display = 'none';
            dur_array[5].style.display = 'none';
            dur_array[6].style.display = 'none';
            dur_array[7].style.display = 'block';
            break;
        case '4':
            switch (tar_id) {
                case '24':
                    dur_array[0].style.display = 'block';
                    dur_array[1].style.display = 'none';
                    dur_array[2].style.display = 'none';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
                case '25':
                    dur_array[0].style.display = 'none';
                    dur_array[1].style.display = 'none';
                    dur_array[2].style.display = 'none';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'block';
                    dur_array[6].style.display = 'block';
                    dur_array[7].style.display = 'none';
                    break;
                default:
                    dur_array[0].style.display = 'none';
                    dur_array[1].style.display = 'none';
                    dur_array[2].style.display = 'block';
                    dur_array[3].style.display = 'none';
                    dur_array[4].style.display = 'none';
                    dur_array[5].style.display = 'none';
                    dur_array[6].style.display = 'none';
                    dur_array[7].style.display = 'none';
                    break;
            }
            break;
        default:
            dur_array[0].style.display = 'none';
            dur_array[1].style.display = 'none';
            dur_array[2].style.display = 'none';
            dur_array[3].style.display = 'none';
            dur_array[4].style.display = 'none';
            dur_array[5].style.display = 'none';
            dur_array[6].style.display = 'none';
            dur_array[7].style.display = 'none';
            break;
    }

    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('net').value = "";

    calcularDescuentoAccCom();
}

function calcularDescuentoAccCom(){
    var cont_sop   = parseInt(document.getElementById('contSop').value, 10);
    var edit_sop   = parseInt(document.getElementById('isEdit').value, 10);

    var desc_sop = 0;

    if(cont_sop == 2){
        desc_sop = 4;
    }
    else if(cont_sop == 3){
        desc_sop = 6;
    }
    else if(cont_sop >= 4){
        desc_sop = 8;
    }

    var dto1 = 0;
    var dto2 = desc_sop;

    var sop = document.getElementById('sop');
    if(sop.value != 0){
        var dur = document.getElementById('dur');
        if(dur.value != 0){
            var dur_id = dur.options[dur.selectedIndex].getAttribute('name');
            var tar = document.getElementById('tar');
            var tar_id = tar.options[tar.selectedIndex].getAttribute('name');
            var sop_id = sop.options[sop.selectedIndex].getAttribute('name');
            var precio = parseFloat(document.getElementById('precio'+tar_id+dur_id).innerText);
            dto1 = parseFloat(document.getElementById('desc'+sop_id+dur_id).innerText);
        }
    }

    dto1 = (100 - dto1)/100;
    dto2 = (100 - dto2)/100;

    var ncunyas = document.getElementById('ncu').value;
    var descuento = (1 - (dto1 * dto2)) * 100;
    var precio_final = precio*ncunyas - ((precio*ncunyas)*descuento/100);
    document.getElementById('des').value = descuento.toFixed(2);
    if(!isNaN(precio_final)){
        document.getElementById('net').value = (precio_final*1.21).toFixed(2);
    }
    else{
        document.getElementById('net').value = "";
    }
}

function modificarDescuentoAccCom(){
    var tabla = document.getElementById('inter_tabla').rows;
    for(var i=0; i<tabla.length; i++){
        var id = tabla[i].id.replace("fila","");
        var cont_sop   = document.getElementById('contSop').value;

        var desc_sop = 0;

        if(cont_sop == 2){
            desc_sop = 4;
        }
        else if(cont_sop == 3){
            desc_sop = 6;
        }
        else if(cont_sop >= 4){
            desc_sop = 8;
        }

        var dto2 = desc_sop;

        var this_sop_id = document.getElementById('soporte'+id).getAttribute('data-id');
        var this_tar_id = document.getElementById('tarifa'+id).getAttribute('data-id');
        var this_dur_id = document.getElementById('duracion'+id).getAttribute('data-id');
        var precio = parseFloat(document.getElementById('precio'+this_tar_id+this_dur_id).innerText);
        var dto1 = parseFloat(document.getElementById('desc'+this_sop_id+this_dur_id).innerText);

        dto1 = (100 - dto1)/100;
        dto2 = (100 - dto2)/100;

        var descuento = (1 - (dto1 * dto2)) * 100;
        var ncunyas = parseInt(document.getElementById('ncunya'+id).value,10);
        var precio_final = precio*ncunyas - ((precio*ncunyas)*descuento/100);
        document.getElementById('desc'+id).value = descuento.toFixed(2);
        document.getElementById('neto'+id).value = (precio_final*1.21).toFixed(2);
    }

    calcularTotal();
}

function eliminarAccCom(){
    var contador = document.getElementById('target').value;
    var id_sop = document.getElementById('targetSop').value;
    var elem = document. getElementById("fila" + contador). remove();
    var total = document.getElementById("total_cunyas" + contador).remove();
    var numLineas = document.getElementById('numSop').value;
    numLineas --;

    var tabla = document.getElementById('opt_tabla'+id_sop).rows;
    for(var i = 0; i < tabla.length; i++){
        if(tabla[i].getAttribute('data-linea')==contador){
            if(tabla[i].id.includes("val")){
                document.getElementById('opt_cont'+id_sop).value = parseInt(document.getElementById('opt_cont'+id_sop).value, 10) - 1;
                document.getElementById(tabla[i].id).remove();
            }
        }
    }

    var a_borrar = [];

    for(var i = 0; i < tabla.length; i++){
        if(tabla[i].id.includes("mes") && tabla[i+1] === undefined){

            a_borrar.push(tabla[i].id);
        }
        else if(tabla[i].id.includes("mes") && tabla[i+1].id.includes("mes")){

            a_borrar.push(tabla[i].id);
        }

    }
    for(var i = 0; i < a_borrar.length; i++){
        document.getElementById('opt_cont'+id_sop).value = parseInt(document.getElementById('opt_cont'+id_sop).value, 10) - 1;
        document.getElementById(a_borrar[i]).remove();
    }

    document.getElementById('contador_cunyas_restantes'+contador).remove();

    document.getElementById('true_cont').value = parseInt(document.getElementById('true_cont').value, 10) - 1;

    var tabla = document.getElementById('opt_tabla'+id_sop).rows;
    if (tabla.length == 0){
        document.getElementById('contSop').value--;
        calcularDescuentoAccCom();
    }
    modificarDescuentoAccCom();
}

function cancel_editAccCom(){
    document.getElementById('add_button').hidden = false;
    document.getElementById('botonEdit').hidden = true;

    document.getElementById('sop').selectedIndex = 0;
    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('ncu').value = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('fechaini').value = 0;
    document.getElementById('fechafin').value = 0;
    document.getElementById('des').value = 0;
    document.getElementById('net').value = 0;

    var lineas = document.getElementsByClassName("edit_line");
    for (let i = 0; i < lineas.length; i++) {
      lineas[i].hidden = false;
    }

    document.getElementById('isEdit').value = 1;

    calcularDescuentoAccCom();
}

function save_editAccCom(){
    var contador = document.getElementById('target').value;
    var soporte = document.getElementById('targetSop').value;

    document.getElementById('add_button').hidden = false;
    document.getElementById('botonEdit').hidden = true;

    document.getElementById('soporte' + contador).value     = document.getElementById('sop').value;
    document.getElementById('tarifa' + contador).value      = document.getElementById('tar').value;
    document.getElementById('ncunya' + contador).value      = document.getElementById('ncu').value;
    document.getElementById('duracion' + contador).value    = document.getElementById('dur').value;
    document.getElementById('fechaini' + contador).value    = document.getElementById('fechaini').value;
    document.getElementById('fechafin' + contador).value    = document.getElementById('fechafin').value;

    document.getElementById('isEdit').value = 1;

    eliminarAccCom();
    add_linea_acccom();

    document.getElementById('sop').selectedIndex = 0;
    document.getElementById('tar').selectedIndex = 0;
    document.getElementById('ncu').value = 0;
    document.getElementById('dur').selectedIndex = 0;
    document.getElementById('fechaini').value = 0;
    document.getElementById('fechafin').value = 0;
    document.getElementById('des').value = 0;
    document.getElementById('net').value = 0;

    var lineas = document.getElementsByClassName("edit_line");
    for (let i = 0; i < lineas.length; i++) {
      lineas[i].hidden = false;
    }

    calcularDescuentoAccCom();
}

function editarAccCom(contador,soporte){
    cambiarTarget(contador,soporte);

    document.getElementById('isEdit').value = 0;

    var lineas = document.getElementsByClassName("edit_line");
    for (let i = 0; i < lineas.length; i++) {
      lineas[i].hidden = true;
    }

    document.getElementById('add_button').hidden = true;
    document.getElementById('botonEdit').hidden = false;

    document.getElementById('sop').value      = document.getElementById('soporte' + contador).value;
    onChangeSoporteAccCom();
    document.getElementById('tar').value      = document.getElementById('tarifa' + contador).value;
    onChangeTarifaAccCom();
    document.getElementById('ncu').value      = document.getElementById('ncunya' + contador).value;
    document.getElementById('dur').value      = document.getElementById('duracion' + contador).value;
    document.getElementById('fechaini').value = document.getElementById('fechaini' + contador).value;
    document.getElementById('fechafin').value = document.getElementById('fechafin' + contador).value;
    calcularDescuentoAccCom();
}

function submitFormAccCom() {

    calcularTotal();

    var flag = false;
    var acc_name = document.getElementById('acc_name');
    var acc_tipo = document.getElementById('acc_tipo');

    if (acc_name.value.length == 0) {
        document.getElementById('err_name').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_name').style = "display: none; font-size: 0.75rem; color: red;";
    }
    if (acc_tipo.value.length == 0) {
        document.getElementById('err_tipo').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_tipo').style = "display: none; font-size: 0.75rem; color: red;";
    }
    if (document.getElementById('true_cont').value == 0) {
        document.getElementById('err_tabla').style = "display: block; font-size: 0.75rem; color: red;";
        flag = true;
    }
    else {
        document.getElementById('err_tabla').style = "display: none; font-size: 0.75rem; color: red;";
    }

    if (!flag) {
        document.guardar_accion_comercial.submit();
    }

}

function actualizarsociedad(){
    id = document.getElementById('razon_social').value;

    document.getElementById('sociedad_cif').value = document.getElementById('sociedad_cif'+id).value;
    document.getElementById('sociedad_nombre').value = document.getElementById('sociedad_nombre'+id).value;
    document.getElementById('sociedad_direccion').value = document.getElementById('sociedad_direccion'+id).value;
    document.getElementById('sociedad_cp').value = document.getElementById('sociedad_cp'+id).value;
    document.getElementById('sociedad_provincia').value = document.getElementById('sociedad_provincia'+id).value;

}

function check(cosa) {
    if(cosa.innerText == "Next") {
        document.getElementById('page').value = parseInt(document.getElementById('page').value, 10) + 1;
    } else if (cosa.innerText == "Previous") {
        document.getElementById('page').value = parseInt(document.getElementById('page').value, 10) - 1;
    }

    var content = document.getElementsByClassName("content clearfix");
    if(document.getElementById('page').value == 4) {
        content[0].style.height = "795px";

    } else {
        content[0].style.height = "500px";
    }

}

function isVisible(elem) {
    if (!(elem instanceof Element)) throw Error('DomUtil: elem is not an element.');
    const style = getComputedStyle(elem);
    if (style.display === 'none') return false;
    if (style.visibility !== 'visible') return false;
    if (style.opacity < 0.1) return false;
    if (elem.offsetWidth + elem.offsetHeight + elem.getBoundingClientRect().height +
        elem.getBoundingClientRect().width === 0) {
        return false;
    }
    const elemCenter   = {
        x: elem.getBoundingClientRect().left + elem.offsetWidth / 2,
        y: elem.getBoundingClientRect().top + elem.offsetHeight / 2
    };
    if (elemCenter.x < 0) return false;
    if (elemCenter.x > (document.documentElement.clientWidth || window.innerWidth)) return false;
    if (elemCenter.y < 0) return false;
    if (elemCenter.y > (document.documentElement.clientHeight || window.innerHeight)) return false;
    let pointContainer = document.elementFromPoint(elemCenter.x, elemCenter.y);
    do {
        if (pointContainer === elem) return true;
    } while (pointContainer = pointContainer.parentNode);
    return false;
}


function Rellenar(){
    //03/05/2022 https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
    //Llamada mediante fetch() para extraer los datos del anunciante y rellenarlos automaticamente

    var nombre = document.getElementById('cliente_anunciante').value;
    const data = { nombre_anunciante: nombre };

    fetch('/datos_anunciante', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {

        document.getElementById('cliente_razon_social').value   = "" ;
        document.getElementById('cliente_cif').value            = "" ;
        document.getElementById('cliente_domicilio').value      = "" ;
        document.getElementById('cliente_provincia').value      = "" ;
        document.getElementById('cliente_cp').value             = "" ;
        document.getElementById('cliente_poblacion').value      = "" ;
        document.getElementById('cliente_telefono1').value      = "" ;
        document.getElementById('cliente_telefono2').value      = "" ;
        document.getElementById('cliente_mail1').value          = "" ;
        document.getElementById('cliente_mail2').value          = "" ;
        document.getElementById('cliente_contacto').value       = "" ;
        document.getElementById('iban').value                   = "" ;
        document.getElementById('iban').removeAttribute('readonly');
        document.getElementById('formPago').value                   = "" ;
        document.getElementById('formPago').removeAttribute('readonly');
        document.getElementById('observaciones_pago').value                   = "" ;

        document.getElementById('cliente_razon_social').value   = data[0]['cli_nom'];
        document.getElementById('cliente_cif').value            = data[0]['cli_cif'];
        document.getElementById('cliente_domicilio').value      = data[0]['cli_dir'];
        document.getElementById('cliente_provincia').value      = data[0]['cli_pro'];
        document.getElementById('cliente_cp').value             = data[0]['cli_cp' ];
        document.getElementById('cliente_poblacion').value      = data[0]['cli_loc'];
        document.getElementById('cliente_telefono1').value      = data[0]['cli_tel1'];
        document.getElementById('cliente_telefono2').value      = data[0]['cli_tel2'];
        document.getElementById('cliente_mail1').value          = data[0]['cli_mail1'];
        document.getElementById('cliente_mail2').value          = data[0]['cli_mail2'];
        document.getElementById('cliente_contacto').value       = data[0]['cli_cont_nom'];
        if(data[0]['cli_iban']){
            document.getElementById('iban').value                   = data[0]['cli_iban'];
            document.getElementById('iban').setAttribute('readonly','true');
        }

        if(data[0]['cli_met_pago']){
            document.getElementById('formPago').value                   = document.getElementById('met_pago'+data[0]['cli_met_pago']).value;
            document.getElementById('formPago').setAttribute('readonly','true');
        }

        if(data[0]['cli_obs_pago']){
            document.getElementById('observaciones_pago').value                   = data[0]['cli_obs_pago'];
            // document.getElementById('observaciones_pago').setAttribute('readonly','true');
        }

        validar_pago();

    })
    .catch((error) => {

    });
}

function validar_pago(){
    var metodo = document.getElementById('formPago');
    var iban = document.getElementById('iban');

    if(metodo.value=="" || iban.value==""){
        document.getElementById('pago_valido').value = 0;
    }
    else{
        document.getElementById('pago_valido').value = 1;
    }
}

window.onload = function() {
    if(!document.getElementById('controlador_pago')){

    }
    else if(document.getElementById('controlador_pago').value == 0){
        var btn = document.getElementById('next')
        btn.click();
        btn.click();
    }
    else if(document.getElementById('mod_id') || document.getElementById('nueva_copia')){
        var btn = document.getElementById('next')
        btn.click();
        btn.click();
        btn.click();
    }
    validar_pago();
};
