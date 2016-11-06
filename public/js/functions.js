
/**
*Functions 
**/
function ajax(url,method,token,data,callback,errorcall) {
  $.ajax(
    { 
      type: method, 
      url: url,
      headers:{'X-CSRF-TOKEN': token},
      dataType: 'json', 
      data: data,
      beforeSend: function() {
        // setting a timeout
        $('.loanding-view').fadeIn(600);
      },
      success: function (data) {
        callback(data); 
      },
      error: function(xhr, status, error) {
        errorcall(xhr, status, error);
      },
      complete: function() {
        $('.loanding-view').fadeOut(600);
      }
  });
}


function selectOtro(select,value,input,otroInput,modal){
   $("#"+select).change(function(){
     var valor =$(this).val();
     if(valor == value && modal == 1){
        $("#contenedor-motivo-visitante").css('display','block');
        $("#"+input).show().css('display','block');
      }
      else if(valor == value && modal == 0){
        $("#"+input).show().css('display','inline-block');
      }
     else if(valor !== 0)
      {
        $("#"+input).hide();
        $('#'+otroInput).val('');
      }
 });
}

function soloNumeros() {
  $('.solo-numeros').keyup(function (){
    this.value = (this.value + '').replace(/[^0-9]/g, '');
  });
}

function noEspacio() {
  $('.no-spacio').keydown(function(e) {  if (e.keyCode == 32) { return false; } });
}

function soloLetras() {
    $(".solo-letras").keypress(function (key) {
    window.console.log(key.charCode)
    if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
      && (key.charCode < 65 || key.charCode > 90) //letras minusculas
      //&& (key.charCode != 45) //guion
      && (key.charCode != 241) //ñ
      && (key.charCode != 209) //Ñ
      && (key.charCode != 32) //espacio
      && (key.charCode != 0) //espacio firefox
      && (key.charCode != 225) //á
      && (key.charCode != 233) //é
      && (key.charCode != 237) //í
      && (key.charCode != 243) //ó
      && (key.charCode != 250) //ú
      && (key.charCode != 193) //Á
      && (key.charCode != 201) //É
      && (key.charCode != 205) //Í
      && (key.charCode != 211) //Ó
      && (key.charCode != 218) //Ú
    )
    return false;
  });
}

/*function comprobarCheckbox() {

  //Comprobar si la visita es formal o particular para mostrar select de empresa
  $("#comprobar-checkbox").click(function() {  
      if($("#cliente").is(':checked')) {  
        $("#contenedor-motivo-cliente").show();
        $("#contenedor-motivo-visitante").hide();
        $('#motive_visit').val('');
        $("#contenedor-indique-motivo-visitante").hide();
        $('#motive-other-visit').val('');
      }
      if($("#visita").is(':checked')) {
        $("#contenedor-motivo-cliente").hide();
        $("#contenedor-motivo-visitante").show();
        $('#motive_client').val('');
        $("#contenedor-indique-motivo-cliente").hide();
        $('#motive-other-client').val('');
      }
  });
}*/

function cortarNombreCompleto(nombreCompleto,apellidoCompleto){
    nombre = nombreCompleto.split(" ")[0];
    apellido = apellidoCompleto.split(" ")[0];
  return nombre.toLowerCase()+'-'+apellido.toLowerCase();
}

function caledario(){
  $('.input-daterange').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 0,
        language: "es",
        //clearBtn: true,
        autoclose: true,
        toggleActive: true
    });
}

function redireccionador(redirect){
  setTimeout(function() {
    window.location.href = redirect;
  },3000);
}

function validarFormUser(){
  $("#names").change(function(){
    $('#container-nombres').removeClass('has-error');
    $('#nombres').html('');
  });

  $("#lastNames").change(function(){
    $('#container-apellidos').removeClass('has-error');
    $('#apellidos').html('');
  });

  $("#roles").change(function(){
    $('#container-rol').removeClass('has-error');
    $('#rol').html('');
  });

  $("#mail").change(function(){
    $('#container-email').removeClass('has-error');
    $('#email').html('');
  });

  $("#re_password").change(function(){
   
    var pass = $("#pass").val();
    var rePass = $("#re_password").val();
    $('#pass').removeClass('invalid');
    $('#re_password').removeClass('invalid');
    validarPassword(pass,rePass);
  });

  $("#pass").change(function(){
  
    var pass = $("#pass").val();
    var rePass = $("#re_password").val();
    $('#pass').removeClass('invalid');
    $('#re_password').removeClass('invalid');
    validarPassword(pass,rePass);
  });
}

function validarPassword(pass,rePass){
   if(pass != '' && rePass != ''){
    if(pass == rePass){
      //alert('valido');
      $('#pass').addClass('valid');
      $('#re_password').addClass('valid');
      $('#container-password').removeClass('has-error');
      $('#password').html('');

      $('#container-repita_password').removeClass('has-error');
      $('#repita_password').html('');
    }else{
      //alert('invalido');
      $('#container-password').addClass('has-error');
      $('#container-repita_password').addClass('has-error');
      $('#repita_password').html('Los campos repita password y password deben coincidir.');
      $('#re_password').addClass('invalid');
    }
   }else{
      $('#pass').removeClass('valid').addClass('invalid');
      $('#re_password').removeClass('valid').addClass('invalid');
   }
   
}