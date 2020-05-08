/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//para crear docente-paralelo
$(function(){
    $('.modalButton').click(function(){
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));

    });

});

//para modificar docente-paralelo
$(function(){    
    $('.modalButtonM').click(function(){
        $('#modalM').modal('show')
                .find('#modalContentM')
                .load($(this).attr('value'));
    });
    
});

//para crear dia-hora-aula
$(function(){    
    $('.modalButtonH').click(function(){
        $('#modalH').modal('show')
                .find('#modalContentH')
                .load($(this).attr('value'));
    });
    
});

//para modificar dia-hora-aula
$(function(){    
    $('.modalButtonMH').click(function(){
        $('#modalMH').modal('show')
                .find('#modalContentMH')
                .load($(this).attr('value'));
    });
    
});
