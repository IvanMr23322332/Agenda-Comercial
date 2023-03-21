function procesar(event){
    $('#id_presupuesto').val(event.pre_id);

    $('#btnEvent').click();

}

$(document).ready(function() {
    alert("a");
    var eventos = @json($array_eventos);
    $('#calendar').fullCalendar({
        locale: 'es',
        header:{
            right: 'month, agendaWeek, agendaDay, listMonth',
            center: 'title',
            left: 'prev, next, today',
        },
        buttonText: {
           //Here I make the button show French date instead of a text.
           today: 'Hoy',
           month: 'Mes',
           week: 'Semana',
           day:    'Día',
           listMonth: "Eventos"

        },
        editable: true,
        eventDrop: function(event) {
            procesar(event);
        },
        weekends: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
        events: eventos
    });
});
