$(document).ready(function () {


    //Si es en editar se debe poner la cantidad de precintos, sino es 1 por defecto
    localStorage.setItem('precintoCounter',1);

    $('#id_empresa').select2({ theme: 'bootstrap-5', focus: true });
    $('#instalador').select2({ theme: 'bootstrap-5', focus: true });
    $('#persona_calificada').select2({ theme: 'bootstrap-5', focus: true });
    $('#sistema_proteccion').select2({ theme: 'bootstrap-5', focus: true });
    $('#uso').select2({ theme: 'bootstrap-5', focus: true });
    // $('').select2();
    // $('').select2();


    $(document).on('keyup','.inputPrecintoRange', function () {
        var valTxt = $(this).val();
        if(valTxt=="" || valTxt.length==0){
            $(this).addClass('is-invalid');
        }else{
            $(this).removeClass('is-invalid');
        }

        var initialValue = $(this).parent().parent().find('.inputPrecintoInicial').val();
        var endValue     = $(this).parent().parent().find('.inputPrecintoFinal').val();
        var dataRanges = [];
        $('.precintosULlist li').each(function(index, value){
            console.log(this);
            dataRanges.push({
                start   : $(this).find('.inputPrecintoInicial').val(),
                end     : $(this).find('.inputPrecintoFinal').val()
            });
        });
        dataRanges.pop(); //Remove last element value that was cloned from last file

        initialValue = parseInt(initialValue.trim());
        endValue     = parseInt(endValue.trim());

        console.log('Inicial:'+initialValue+' - Final: '+endValue);

        if(initialValue>0 && endValue>0){
            console.log('Entrando aca 123');
            if(initialValue>endValue){
                $(this).parent().parent().find('.inputPrecintoInicial').addClass('is-invalid');
                $(this).parent().parent().find('.inputPrecintoFinal').addClass('is-invalid');
                console.log('Caso negativo');
                //alert('El número de precinto final no puede ser menor al inicial o igual.');
                $(this).parent().parent().parent().find('.rowPrecintoRangeError').html('El número de precinto final no puede ser menor al inicial o igual.');
                $(this).parent().parent().parent().find('.rowPrecintoRangeError').parent().parent().parent().removeClass('d-none');
                $('.btnAddPrecint').attr('disabled', true);
                $('.btnAddPrecint').addClass('disabled');

                //$('.precintosULlist li').last().find('.inputPrecintoFinal').focus();
            }else{
                    console.log('Caso positivo');
                    console.log('MIRA AQUI: .');
                    console.log($(this).parent().parent().find('.inputPrecintoInicial'));
                    console.log($(this).parent().parent().find('.inputPrecintoFinal'));
                    console.log('FIN MIRA AQUI');
                    $(this).parent().parent().find('.inputPrecintoInicial').addClass('is-invalid');
                    $(this).parent().parent().find('.inputPrecintoFinal').addClass('is-invalid');
                    $(this).parent().parent().parent().find('.rowPrecintoRangeError').html('');

                    //Valid logic range
                    if(validateRange(dataRanges,initialValue, endValue)){
                        $(this).parent().parent().parent().find('.rowPrecintoRangeError').html('');
                        $(this).parent().parent().parent().find('.rowPrecintoRangeError').parent().parent().parent().addClass('d-none');

                        $(this).parent().parent().find('.inputPrecintoInicial').removeClass('is-invalid');
                        $(this).parent().parent().find('.inputPrecintoFinal').removeClass('is-invalid');

                        $('.btnAddPrecint').attr('disabled', false);
                        $('.btnAddPrecint').removeClass('disabled');
                    }else{
                            $(this).parent().parent().parent().find('.rowPrecintoRangeError').html('No se puede realizar la operación, el rango no es valido porque ya está comprendido en otro rango');
                            $(this).parent().parent().parent().find('.rowPrecintoRangeError').parent().parent().parent().removeClass('d-none');
                            $('.btnAddPrecint').attr('disabled', true);
                            $('.btnAddPrecint').addClass('disabled');
                    }
            }
        }else{
            console.log('No entra');
            $(this).parent().parent().parent().find('.rowPrecintoRangeError').html('');
            $(this).parent().parent().parent().find('.rowPrecintoRangeError').parent().parent().parent().addClass('d-none')
            /*$('.btnAddPrecint').attr('disabled', false);
            $('.btnAddPrecint').removeClass('disabled');*/
        }


    });


    $("#sistema_proteccion").on("change", function (e) {
        console.log(e.target.value);
        if (e.target.value == 0 || e.target.value == 3) {
            $("#numero_usuarios").val(1);
        } else {
            $("#numero_usuarios").val(2);
        }
    });

    $("#marca").on("change", function (e) {
        console.log(e.target.value);
        if (e.target.value == "OTRO") {
            $("#marca_otro, #marca_otro_input").show();
            $("#marca_otro_input").attr("required", true);
        } else {
            $("#marca_otro, #marca_otro_input").hide();
            $("#marca_otro_input").removeAttr("required");
            $("#marca_otro_input").val(''); 
        }
    });

    //onchange precinto_final can't be less than precinto_inicial
    $("#precinto_final").on("change", function () {
        const precinto_inicial = parseInt($("#precinto_inicial").val());
        const precinto_final = parseInt($(this).val());
        const errorPrecintoFinal = $("#error_preciento_final");
        const guardarBtn = $("#guardar");
        console.log(precinto_inicial, precinto_final);
        if (precinto_final < precinto_inicial) {
            errorPrecintoFinal.css({ "color": "red", "display": "block" });
            $(this).css("border", "1px solid red");
            guardarBtn.prop("disabled", true);
        } else {
            errorPrecintoFinal.hide();
            $(this).css("border", "1px solid #ced4da");
            guardarBtn.prop("disabled", false);
        }
    });

    if(document.getElementById("fecha_instalacion")!=null || document.getElementById("fecha_instalacion")!=undefined){
        document.getElementById("fecha_instalacion").valueAsDate = new Date();
    }
    // let fechas = document.querySelectorAll('input[type="date"]');

    var today = new Date().toISOString().split("T")[0];

    // for (var i = 0; i < fechas.length; i++) {
    //     fechas[i].setAttribute("min", today);
    // }

    // let fecha_inspeccion = document.getElementById("fecha_inspeccion");
    // fecha_inspeccion.setAttribute("min", today);



    $(document).on('click', '.removePairActive', function() {
        //$(this).parent().parent().parent().parent().parent().parent().remove();
        $(this).parent().parent().parent().parent().parent().parent().block({ message: $('#question'), css: { width: '275px' } });
        localStorage.setItem('removeElementMTP', $(this).parent().parent().parent().parent().parent().parent().data('idtemp'));

        $(this).siblings('.editPercintActive').trigger('click');
    });


    $(document).on('click', '.editPercintActive', function() {
        $('.precintosULlist li').find('.card-bodyTMP').addClass('d-none');
        $('.precintosULlist li').find('.card-headerTMP').removeClass('card-headerCustom');


        $('.editPercint').each(function(index, value){
            $(this).addClass('d-none');
        });
        $('.editPercintActive').each(function(index, value){
            $(this).removeClass('d-none');
        });

        $(this).parent().parent().parent().parent().find('.card-bodyTMP').removeClass('d-none');
        $(this).parent().parent().parent().parent().find('.card-headerTMP').addClass('card-headerCustom');

        $(this).parent().parent().parent().parent().find('.inputPrecintoInicial').focus();

        $('.precintosULlist li .card').each(function(index, value){
            $(this).addClass('anclajeClosed');
        });

        console.log('ESTE ES ADONIS:');
        console.log($(this).parent().parent().parent().parent());
        console.log('FIN');
        $(this).parent().parent().parent().parent().parent().removeClass('anclajeClosed');
    });

    $('#yes').click(function(evt) {
        evt.preventDefault();
        var tmpID = localStorage.getItem('removeElementMTP');
        var rowTMP = $("#precintosPairList").find('li[id="fila-'+tmpID+'"]');


        rowTMP.find('.card-bodyTMP').addClass('d-none');
        rowTMP.find('.card-headerTMP').removeClass('card-headerCustom');

        // update the block message
        rowTMP.block({ message: "<h5 style='margin-left:3px!important;'><div class='spinner-border spinner-border-sm'></div> Eliminando datos...</h5>" });

        rowTMP.find('.blockMsg').removeClass('blockElement');
        rowTMP.find('.blockMsg').addClass('blockElement2');

        setTimeout(function () {
            rowTMP.remove();
            $('#precintosLabelCounter').html(parseInt($('#precintosLabelCounter').html())-1);
            reOrderPrecintosLabel();
        }, 300);
        /*$.ajax({
            url: 'wait.php',
            cache: false,
            complete: function() {
                // unblock when remote call returns
                //rowTMP.unblock();
            }
        });*/
    });

    $('#no').click(function(evt) {
        evt.preventDefault();
        var tmpID= localStorage.getItem('removeElementMTP');
        $("#precintosPairList").find('li[id="fila-'+tmpID+'"]').unblock();
        //$("#precintosPairList").find('li[id="fila-'+tmpID+'"]').unblockUI();
        /*$("#precintosPairList").find('li[id="fila-'+tmpID+'"]').unblockUI();
        return false;*/
    });


    function validateRange(dataRanges, initialValue, endValue){
        console.log("INICIO: "+ initialValue+' - FIN:'+endValue);

        initialValue = parseInt(initialValue);
        endValue     = parseInt(endValue);
        var res      = true;
        $.each(dataRanges,
            function (index, value) {
                console.log(value);
                if(
                       (initialValue==value.start || initialValue==value.end || endValue==value.start || endValue==value.end)
                    || (initialValue>=value.start && endValue<=value.end)
                    || (initialValue>=value.start && initialValue<value.end && endValue<=value.end)
                    || (initialValue>=value.start && initialValue<value.end && endValue>=value.end)
                    || (initialValue<=value.start && initialValue<value.end && endValue>value.start && endValue<=value.end)
                    || (initialValue<=value.start && initialValue<value.end && endValue>value.end)
                ){
                    console.log("Rango en que falla: "+ value.start +' - '+value.end);
                    res = false;
                }
            }
        );
        return res;
    }


    function reOrderPrecintosLabel(){
        var indice=1;
        $('.precintosULlist li .card .spanCounterLabel').each(function(index, value){
            $(this).html(indice);
            indice++;
        });
    }

    $('.btnAddPrecint').on('click', function() {
        var btn = $(this);

        var initialValue = $('.precintosULlist li').last().find('.inputPrecintoInicial').val();
        var endValue     = $('.precintosULlist li').last().find('.inputPrecintoFinal').val();

        if(initialValue=="" || endValue=="" || initialValue.length==0 || endValue.length==0) {
            alert('Usted debe llenar los datos del rango para continuar!');
            if((initialValue!="" || initialValue.length>0) && (endValue=="" || endValue.length==0)){
                $('.precintosULlist li').last().find('.inputPrecintoFinal').focus();
            }else {
                $('.precintosULlist li').last().find('.inputPrecintoInicial').focus();
            }
            if(initialValue=="" || initialValue.length==0){
                $('.precintosULlist li').last().find('.inputPrecintoInicial').addClass('is-invalid');
            }
            if(endValue=="" || endValue.length==0){
                $('.precintosULlist li').last().find('.inputPrecintoFinal').addClass('is-invalid');
            }
        }else{

                var dataRanges = [];
                $('.precintosULlist li').each(function(index, value){
                    console.log(this);
                    dataRanges.push({
                        start   : $(this).find('.inputPrecintoInicial').val(),
                        end     : $(this).find('.inputPrecintoFinal').val()
                    });
                });
                dataRanges.pop(); //Remove last element value that was cloned from last file

                initialValue = parseInt(initialValue.trim());
                endValue     = parseInt(endValue.trim());

                if(initialValue>endValue){
                    $('.precintosULlist li').last().find('.inputPrecintoInicial').addClass('is-invalid');
                    $('.precintosULlist li').last().find('.inputPrecintoFinal').addClass('is-invalid');
                    alert('El número de precinto final no puede ser menor al inicial o igual.');
                    $('.precintosULlist li').last().find('.inputPrecintoFinal').focus();
                }else{
                        //Valid logic range
                        if(validateRange(dataRanges,initialValue, endValue)){
                            $(this).find('.btnAddPrecintSVGIcon').addClass('d-none');
                            $(this).find('.btnAddPrecintSpinner').removeClass('d-none');

                            setTimeout(function () {
                                var badgeText = $('.precintosULlist li').last().find('.inputPrecintoInicial').val() + ' - ' + $('.precintosULlist li').last().find('.inputPrecintoFinal').val();
                                $('.precintosULlist li').last().find('.card-headerTMP').find('.rangeVisualData').html(badgeText);
                                $('.precintosULlist li').last().find('.card-headerTMP').find('.rangeVisualData').removeClass('d-none');

                                $('.precintosULlist li').last().find('.card-bodyTMP').addClass('d-none');
                                $('.precintosULlist li').last().find('.card-headerTMP').removeClass('card-headerCustom');

                                $('.precintosULlist li').last().clone().appendTo("#precintosPairList");
                                btn.find('.btnAddPrecintSVGIcon').removeClass('d-none');
                                btn.find('.btnAddPrecintSpinner').addClass('d-none');

                                localStorage.setItem('precintoCounter', parseInt(localStorage.getItem('precintoCounter'))+1);

                                $('.precintosULlist li').last().attr('data-idtemp', localStorage.getItem('precintoCounter'));
                                $('.precintosULlist li').last().attr('id', 'fila-'+ localStorage.getItem('precintoCounter'));
                                $('.precintosULlist li').last().find('.card-bodyTMP').removeClass('d-none');
                                $('.precintosULlist li').last().find('.card-headerTMP').addClass('card-headerCustom');
                                $('.precintosULlist li').last().find('.spanCounterLabel').html(localStorage.getItem('precintoCounter'));
                                $('.precintosULlist li').last().find('.inputPrecintoInicial').val('');
                                $('.precintosULlist li').last().find('.inputPrecintoFinal').val('');
                                $('.precintosULlist li').last().find('.inputPrecintoUbicacion').val('');
                                $('.precintosULlist li').last().find('.inputPrecintoInicial').focus();
                                $('.precintosULlist li').last().attr('data-idtemp', localStorage.getItem('precintoCounter'));

                                $('.precintosULlist li .card').each(function(index, value){
                                    $(this).addClass('anclajeClosed');
                                });

                                var counterTMP= $('.deletePrecintPair').length;
                                //if there area more than one active
                                $('.deletePrecintPair').each(function(index, value){
                                    $(this).addClass('removePairActive');
                                });
                                $('.editPercint').each(function(index, value){
                                    $(this).addClass('d-none');
                                });
                                $('.editPercintActive').each(function(index, value){
                                    $(this).removeClass('d-none');
                                });
                                $('.editPercint').last().removeClass('d-none');
                                $('.editPercintActive').last().addClass('d-none');
                                $('.precintosULlist li').last().find('.card-headerTMP').find('.rangeVisualData').addClass('d-none');
                                $('.precintosULlist li .card').last().removeClass('anclajeClosed');


                                $('#precintosLabelCounter').html(parseInt($('#precintosLabelCounter').html())+1);
                            }, 600);

                        }else{
                            alert('No se puede realizar la operación, el rango no es valido porque ya está comprendido en otro rango');
                        }

                }
        }
    });
});
