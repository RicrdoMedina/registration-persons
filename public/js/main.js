$(document).ready(function() {

  var baseUrl = $('#base-url').attr('data-url');
  var banderaFoto;
  var nombre;
  var apellidoCompleto;
  var nombreCompleto;
  var mostrar;
  var param1;
  var param2;
  var startDate;
  var endDate;
  var page;
  var redirect;
  var route;
  var user;
  var id;
  var token;

  caledario();
  selectOtro('motivo',5,'contenedor-indique-motivo-visitante','otro_motivo',0);
  selectOtro('empresa',5,'contenedor-indique-empresa','otra_empresa',0);
  soloLetras();
  soloNumeros();
  noEspacio();
  validarFormUser();

  /**
  * Vista registrar 
  * Parametro entrada: cedula del user 
  * Returna back-end 
  * Si el user esta registrado, retorna 
  * status = 1,ci,span-block, apellidos, src foto, tipo user
  * Sino retorna status = 0, ci 
  **/

  $("#buscar").click(function() {

      var validator = $("#buscar-registro").validate(
        {
          rules:{
            'cedula': { required: true, number: true }
          },
          messages:{ },
          errorPlacement: function(error, element) {
            $('#msj-error-buscar').append(error).css({'display': 'block', 'color': 'red'}).show();
          },

          submitHandler: function(form) {
            ajax(
              $("#buscar-registro").attr('action'),
              $("#buscar-registro").attr('method'),
              $("#buscar-registro #token").val(),
              $("#buscar-registro").serialize(),
              function(data) {
                //Importante setear el valor de todos los input, select, radio
                $('.clear').val('');
                $('.info-empresa').show();
                $('#info-user-empresa').hide();
                $('.disabled').prop('disabled', false);
                $('#visita').prop("checked", false).removeClass('disabled').prop('disabled',false);
                $('#cliente').prop("checked", false).removeClass('disabled').prop('disabled',false);
                $('#formal').prop("checked", false);
                $('#particular').prop("checked", false);
                
                var status = data.status;
                var cedula = data.cedula;

                //Agregar cedula a input hidden para validar en el back-end (cuando se haga el insert) si un usuario esta registrado
                $('#id').attr("value",cedula);
                      
                if(status === 1) {
                //El usuario ya esta registrado mostrar sus datos

                  $('#pasos-realizar').fadeOut();
                  $('#capturar-foto').hide();
                  $('#ci-user').hide();
                  $('.info-empresa').hide();
                  $('#info-user-empresa').show();
                  $('#datos-personales-usuario-registrado').fadeIn(1500);
                  $('#input-datos-personales').fadeIn(1500);
                  //como el usuario ya esta registrado quitar validacion de capturar foto
                  $('#imageBase64').attr("data-photo",1);
                  //Mostrar y agregar los datos correspondientes del usuario registrado
                  $('#form-registar-visitantes').fadeIn(1500);
                  $('#nombres').val(data.nombres);
                  $('#apellidos').val(data.apellidos);

                  if(data.tipo === 2){
                    $('#visita').prop("checked", true).addClass('disabled').prop('disabled', true);
                    $('#cliente').addClass('disabled').prop('disabled', true);
                  }else{
                    $('#cliente').prop("checked", true).addClass('disabled').prop('disabled', true);
                    $('#visita').addClass('disabled').prop('disabled', true);
                  }

                  if(data.empresaOtra !== '') {
                    $('#user_empresa').val(data.empresaOtra);
                  }else{
                    $('#user_empresa').val(data.empresa);
                  }

                  $('.disabled').prop('disabled', true);
                  $('#foto-usuario-registrado').attr("src",data.foto);
                }

                if(status === 0) {
                //El usuario no esta registrado
                  //imagen por defecto 
                  $('#image').attr("src",baseUrl+"/images/user-image.png");

                  $('#pasos-realizar').fadeOut();

                  $('#form-registar-visitantes').fadeIn(1500);
                  $('#capturar-foto').fadeIn(1500);
                  $('#input-datos-personales').fadeIn(1500);
                  //asignar atributo data.photo para validar captura de foto
                  $('#imageBase64').attr("data-photo",0);
                  $('#datos-personales-usuario-registrado').hide();
                }
              },
              function(xhr, status, error){
              //console.log(xhr);
              //console.log(status);
              //console.log(error);
              }
            );
          },
        }
      );
   });


  /**
  * Vista registrar 
  * Parametro entrada: datos de user y visita
  **/
  $( "#submit" ).click(function() {

      //ocultar por defecto el span con el error de captura de foto
      $('#error-captura').hide();
      //Capturar valor del atributo data-photo para validar captura de foto
      banderaFoto = $('#imageBase64').attr("data-photo");

      //Si no se ha capturado la foto
      if(banderaFoto == 0) {
        $('#error-captura').show();

        $('html,body').animate({
            scrollTop: $("#scrollToHere").offset().top
        }, 2000);

        event.preventDefault();
      }

      //Crear regla para validar solo letras en input
      jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^([a-z ñáéíóú]{2,60})$/i.test(value);
      }, "Por favor, escribe solo letras.");

        var validator = $("#form").validate(
        {
          rules:{
            'id': { required: true, number: true },
            'nombres': { required: true, lettersonly: true },
            'apellidos': { required: true, lettersonly: true},
            'motivo': { required: true},
            'otro_motivo': { required: true},
            'otra_empresa': { required: true},
            'empresa': { required: true, minlength: 1 },
            'destino': { required: true, minlength: 1 },
            'visita': { required: true, minlength: 1 },
            'tipo_usuario': { required: true, minlength: 1 }
          },
          messages:{ },
          
          errorPlacement: function(error, element) {
              element.parent().children('span').append(error);
              element.parent().addClass('has-error');
            },

          submitHandler: function(data) {
            ajax(
              $("#form").attr('action'),
              $("#form").attr('method'),
              $("#form #token").val(),
              $("#form").serialize(),
              function(data) {
                if(data.status === 1){
                  //Importante limpiar todos los input, select, radio
                  $('.clear').val('');
                  $('input:radio').attr("checked", false);

                  //despues de registrar el usuario ocultar formulario
                  $('#form-registar-visitantes').hide();

                  $('#pasos-realizar').show();

                  $('#cedula').val('').focus();

                  BootstrapDialog.show({
                    title: 'Registro de visitas',
                    message: 'El usuario ' + data.usuario + ' ha sido registrado!',
                    draggable: true
                  });
                }
              },
              function(xhr, status, error){
                //console.log(xhr);
                //console.log(status);
                //console.log(error);

                BootstrapDialog.show({
                      type: BootstrapDialog.TYPE_DANGER,
                      title: 'Ocurrio un errror!',
                      message: "<p style='color:ddd'>Si persiste el error contacte al administrador.</p>",
                      draggable: true
                }); 

                redireccionador(baseUrl+'/registrar/visita');
              }
            );
          }
        });
    });

  /**
  * Vista consultar Paginacion 
  * Parametro entrada: pagina, cantidad registros 
  * a mostrar, param1 = select tipo usuario, 
  * param2= valor de busqueda 
  * Retorna back-end 
  * html de la tabla con datos de la bd 
  **/

  $(document).on('click','.pagination a',function(e){
    e.preventDefault();
    //Select cantidad de registros a mostrar en paginador
    mostrar = $('#select-mostrar').val();
    //Select tipo usuario
    param1 = $('#select-param1').val();
    //Input text valor de busqueda en bd
    param2 = $('#param2').val();

    startDate = $('#startDate').val();

    endDate = $('#endDate').val();

    //Pagina a mostrar
    page = $(this).attr('href').split('page=')[1];
    //Url 
    route = $(this).attr('href').split('?')[0];

    $.ajax({
      url: route,
      data: {page: page,mostrar:mostrar,param1:param1,param2:param2,start:startDate,end:endDate},
      type: 'GET',
      dataType: 'json',
      success: function(data){
        //console.log(data);
        $('#clientes-visitantes').html(data);
        $('#select-mostrar option[value='+mostrar+']').prop('selected', 'selected');
        $('#param2').attr("value",param2);
        $('#startDate').attr("value",startDate);
        $('#endDate').attr("value",endDate);
        $('#select-param1 option[value='+param1+']').prop('selected', 'selected');
        caledario();
      }
    });
  });


  $(document).on('change','#select-mostrar',function(){
      mostrar = $(this).val();
      id = $('#select-mostrar').attr('data-route');
      nombreCompleto = $('#buttonEditar').attr('data-nombre');
      apellidoCompleto = $('#buttonEditar').attr('data-apellido');
      route = $('#form-buscar').attr('action');
      //Select tipo usuario
      param1 = $('#select-param1').val();
      //Input text valor de busqueda en bd
      param2 = $('#param2').val();

      startDate = $('#startDate').val();

      endDate = $('#endDate').val();

      //Si el atributo data-route es igual a 1
      //Indica que la url es dinamica usuario/{nombre del usuario}

      if(id == 1) {
        user = cortarNombreCompleto(nombreCompleto,apellidoCompleto);
        route = baseUrl+'/usuario/'+user;
      }
      $.ajax({
        url: route,
        data: {mostrar: mostrar,param1:param1,param2:param2,start:startDate,end:endDate},
        type: 'GET',
        dataType: 'json',
        success: function(data){
          $('#clientes-visitantes').html(data);
          $('#select-mostrar option[value='+mostrar+']').prop('selected', 'selected');
          $('#param2').attr("value",param2);
          $('#startDate').attr("value",startDate);
          $('#endDate').attr("value",endDate);
          $('#select-param1 option[value='+param1+']').prop('selected', 'selected');
          caledario();
        }
      });

  });


  $(document).on('click','#buscar-usuario',function(e){
    e.preventDefault();
    param2 = $('#param2').val();
    startDate = $('#startDate').val();
    endDate = $('#endDate').val();
    id = $('#select-mostrar').attr('data-route');
    var mostrarSelectTipoUsuario = $('#select-param1').val();
    nombreCompleto = $('#buttonEditar').attr('data-nombre');
    apellidoCompleto = $('#buttonEditar').attr('data-apellido');

    route = $('#form-buscar').attr('action');

    //Si el atributo data-route es igual a 1
    //Indica que la url es dinamica usuario/{nombre del usuario}
    if(id == 1){
      user = cortarNombreCompleto(nombreCompleto,apellidoCompleto);
      route = baseUrl+'/usuario/'+user;
    }

    ajax(
      route,
      $('#form-buscar').attr('method'),
      $('#form-buscar #token').val(),
      $('#form-buscar').serialize(),
      function(data) {
        console.log(data);
        $('#clientes-visitantes').html(data);
        $('#tabla-usuarios').html(data);
        $('#param2').attr("value",param2);
        $('#startDate').attr("value",startDate);
        $('#endDate').attr("value",endDate);
        $('#select-param1 option[value='+mostrarSelectTipoUsuario+']').prop('selected', 'selected');
        caledario();
      },
      function(xhr, status, error){
      //console.log(xhr);
      //console.log(status);
      //console.log(error);
      }
    );
  });


  $(document).on('click','.visitas',function(){
    nombreCompleto = $(this).attr('data-nombre');
    apellidoCompleto = $(this).attr('data-apellido');
    user = cortarNombreCompleto(nombreCompleto,apellidoCompleto);
    id = $(this).attr('data-cedula');
    route = baseUrl+'/buscar';
    token = $('#token').val();

    $.ajax({
      url: route,
      headers:{'X-CSRF-TOKEN': token},
      data: {id : id},
      type: 'POST',
      dataType: 'json',
      beforeSend: function() {
        // setting a timeout
        $('.loanding-view').fadeIn(600);
      },
      success: function(data){
        window.location.href = baseUrl+'/usuario/'+user;
      },
      error: function(xhr, status, error) {
        errorcall(xhr, status, error);
      },
      complete: function() {
        $('.loanding-view').fadeOut(600);
      }
    });
    
  });

  $(document).on('click','.editar',function(){
    nombreCompleto = $(this).attr('data-nombre');
    apellidoCompleto = $(this).attr('data-apellido');
    user = cortarNombreCompleto(nombreCompleto,apellidoCompleto);
    id = $(this).attr('data-cedula');
    page = $('.pagination .active span').text();
    view = $(this).attr('data-view');
    redirect = baseUrl+'/consultar/visitantes';
    route = baseUrl+'/editar/usuario';
    token = $('#token').val();
    $('#formUpdate').attr('action',baseUrl+'/actualizar/usuario');

    if(view == 0) {
      redirect = baseUrl+'/consultar/visitas';
      id2 = $(this).attr('data-id');
    }
    
    $.ajax({
      url: route,
      headers:{'X-CSRF-TOKEN': token},
      data: {id : id},
      type: 'POST',
      dataType: 'json',
      success: function(data){
        $('#myModalLabel').text('Editar usuario');
        $('#formEditar').html(data);
        $('#datos-personales-usuario-registrado').show();
        $('#empresa').addClass('disabled');
        $('#visita').addClass('disabled');
        $('#cliente').addClass('disabled');
        $('#otra_empresa').addClass('disabled');
        $('.disabled').prop('disabled', true);
        $('#submitModal').hide();
        $('#editar').show();
        $('#myModal').modal('show');
        selectOtro('empresa',5,'contenedor-indique-empresa','otra_empresa',1);
        soloLetras();
        soloNumeros();
        noEspacio();
        $('#editar').click(function() {
          $('.disabled').prop('disabled', false);
          $('input:radio').removeClass('disabled');
          $('#editar').hide();
          $('#submitModal').show();
        });
        $('#submitModal').click(function() {

          jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^([a-z ñáéíóú]{2,60})$/i.test(value);
          }, "Por favor, escribe solo letras.");

          var formEditar;
          formEditar = $('#formUpdate').validate({

            rules:{
              'cedula': { required: true, number: true },
              'nombres': { required: true, lettersonly: true },
              'apellidos': { required: true, lettersonly: true},
              'otra_empresa': { required: true},
              'empresa': { required: true, minlength: 1 },
              'tipo_usuario': { required: true, minlength: 1 },
              'otro_motivo': { required: true},
              'motivo': { required: true, minlength: 1 },
              'destino': { required: true, minlength: 1 },
              'visita': { required: true, minlength: 1 }
            },

            errorPlacement: function(error, element) {
              element.parent().children('span').append(error);
              element.parent().addClass('has-error');
            },

            submitHandler: function(data) {
              ajax(
                $('#formUpdate').attr('action'),
                $('#formUpdate').attr('method'),
                $('#token').val(),
                $('#formUpdate').serialize(),
                function(data) {

                    
                  if(data.status === 1) {
  
                    BootstrapDialog.show({
                        title: 'Actualización de datos',
                        message: 'El registro del usuario ' + data.usuario + ' ha sido modificado!',
                        draggable: true
                    });

                    $.ajax({
                      url: redirect,
                      data: {page: page, mostrar:mostrar},
                      type: 'GET',
                      dataType: 'json',
                      success: function(data){
                        //console.log(data);
                        $('#clientes-visitantes').html(data);
                        $('#'+id).hide().removeClass('fila-info');
                        if(view == 0) {
                          $('#'+id2).fadeIn(2000).addClass('fila-afectada');
                        }
                        $('#'+id).fadeIn(2000).addClass('fila-afectada');
                        caledario();
                      }
                    });
                    //redireccionador(redirect);
                    
                  }
                },
                function(xhr, status, error){
                  $('#myModal').hide();
 
                  BootstrapDialog.show({
                      type: BootstrapDialog.TYPE_DANGER,
                      title: 'Ocurrio un errror!',
                      message: "<p style='color:ddd'>Si persiste el error contacte al administrador.</p>",
                      draggable: true
                  });     

                  redireccionador(redirect);
                  
                }
              );
            },
           });
          formEditar.valid();
          //console.log(formEditar);
        });
      }
    });
    
  });

    $(document).on('click','.editarVisita',function(){
    nombreCompleto = $(this).attr('data-nombre');
    apellidoCompleto = $(this).attr('data-apellido');
    user = cortarNombreCompleto(nombreCompleto,apellidoCompleto);
    id = $(this).attr('data-id');
    view = $(this).attr('data-view');
    route = baseUrl+'/editar/visita';
    page = $('.pagination .active span').text();

    redirect = baseUrl+'/usuario/'+user;
    token = $('#token').val();
    $('#formUpdate').attr('action',baseUrl+'/actualizar/visita');

    if(view == 0) {
      //Si se invoca el modal consultar visitas
      //Al momento de editar redireccionar a consultar visitas
      redirect = baseUrl+'/consultar/visitas';
    }


    $.ajax({
      url: route,
      headers:{'X-CSRF-TOKEN': token},
      data: {id : id},
      type: 'POST',
      dataType: 'json',
      success: function(data){
        $('#myModalLabel').text('Editar visita');
        $('#formEditar').html(data);
        $('.clear').addClass('disabled');

        $('#formal').addClass('disabled');
        $('#particular').addClass('disabled');

        $('.disabled').prop('disabled', true);
        $('#submitModal').hide();
        $('#editar').show();
        $('#myModal').modal('show');
        $("#contenedor-motivo-visitante").css('display','block');
        selectOtro('motivo',5,'contenedor-indique-motivo-visitante','otro_motivo',1);
        $('#formUpdate').attr('action',baseUrl+'/actualizar/visita');
        
        $('#editar').click(function() {
          $('.disabled').prop('disabled', false);
          $('#formal').removeClass('disabled');
          $('#particular').removeClass('disabled')
          $('#editar').hide();
          $('#submitModal').show();
        });

        //Importante para que se ejecute el codigo dentro del click #submitModal una vez por cada secuencia que le den click al boton editar
        $( "#submitModal" ).unbind( "click" );

        $('#submitModal').click(function() {
          
          jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^([a-z ñáéíóú]{2,60})$/i.test(value);
          }, "Por favor, escribe solo letras.");

          var formEditar;

          formEditar = $('#formUpdate').validate({
            rules:{
              'cedula': { required: true, number: true },
              'nombres': { required: true, lettersonly: true },
              'apellidos': { required: true, lettersonly: true},
              'otra_empresa': { required: true},
              'empresa': { required: true, minlength: 1 },
              'tipo_usuario': { required: true, minlength: 1 },
              'otro_motivo': { required: true},
              'motivo': { required: true, minlength: 1 },
              'destino': { required: true, minlength: 1 },
              'visita': { required: true, minlength: 1 }
            },
            errorPlacement: function(error, element) {
              element.parent().children('span').append(error);
              element.parent().addClass('has-error');
              //console.log(element.parent());
            },
            submitHandler: function(data) {
              ajax(
                $('#formUpdate').attr('action'),
                $('#formUpdate').attr('method'),
                $('#token').val(),
                $('#formUpdate').serialize(),
                function(data) {
                  if(data.status === 1) {

                    BootstrapDialog.show({
                        title: 'Actualización de datos',
                        message: 'El registro del usuario ' + data.usuario + ' ha sido modificado!',
                        draggable: true
                    });

                     $.ajax({
                      url: redirect,
                      data: {page: page},
                      type: 'GET',
                      dataType: 'json',
                      success: function(data){
                        //console.log(data);
                        $('#clientes-visitantes').html(data);
                        $('#'+id).hide().removeClass('fila-info');
                        $('#'+id).fadeIn(2000).addClass('fila-afectada');
                        caledario();
                      }
                    });
                    //redireccionador(redirect);

                  }
                },
                function(xhr, status, error){
                  //console.log(xhr);
                  //console.log(xhr.status);
                  //console.log(error);
                  if(xhr.status == 422 || xhr.status == 200){
                    //Importante limpiar todos los input, select, radio
                    $('.clear').removeClass('has-error');
                    $('.error-msj').html('');
                    $.each(xhr.responseJSON, function(index, value) {
                      //console.log(index);
                      $('#container-'+index).addClass('has-error');
                      $('#'+index).html(value);
                    });
                  }else{    
                    BootstrapDialog.show({
                      type: BootstrapDialog.TYPE_DANGER,
                      title: 'Ocurrio un errror!',
                      message: "<p style='color:ddd'>No se actualizo el registro. Si persiste el error contacte al administrador.</p>",
                      draggable: true
                    }); 
                  }    
                    
                }
              );
            },
           });
          formEditar.valid();
          //console.log(formEditar);
        });
      }
    });
  });

  $(document).on('click','.refresh',function(){
    $('#startDate').val('');
    $('#endDate').val('');
    $('#param2').val('');
    view = $('#buttonEditar').attr('data-view');
    route = $('#form-buscar').attr('action');
    if(view == 1) {
      nombreCompleto = $(this).attr('data-nombre');
      apellidoCompleto = $(this).attr('data-apellido');
      user = cortarNombreCompleto(nombreCompleto,apellidoCompleto);

      route = baseUrl+'/usuario/'+user;
    }

    if ($("#refresh").length == 1) {
      $("#refresh").val(1);
    }
    
    ajax(
      route,
      $('#form-buscar').attr('method'),
      $('#form-buscar #token').val(),
      $('#form-buscar').serialize(),
      function(data) {
        $('#clientes-visitantes').html(data);
        $('#tabla-usuarios').html(data);
        if ($("#refresh").length == 1) {
          $("#refresh").val(0);
        }
        console.log(data);
        caledario();
      },
      function(xhr, status, error){
      //console.log(xhr);
      //console.log(status);
      //console.log(error);
      }
    );
  });

  totalUsuarios = $('#totalUsuarios');
  totalVisitas = $('#totalVisitas');
  route = baseUrl+'/total';

  $.get(route, function(res){
    //console.log(res);
    totalUsuarios.append(res.total_usuarios);
    totalVisitas.append(res.total_visitas);
  });

  $( "#submitRegistrarUser" ).click(function() {
    ajax(
      $("#formRegistrarUser").attr('action'),
      $("#formRegistrarUser").attr('method'),
      $("#formRegistrarUser #token").val(),
      $("#formRegistrarUser").serialize(),
      function(data) {
        $('.clear').removeClass('has-error');
        $('.clear-input').val('');
        $('.error-msj').html('');
        //console.log(data);
        BootstrapDialog.show({
          title: 'Registro de usuarios',
          message: 'El usuario ' + data.usuario + ' ha sido registrado!',
          draggable: true
        });       
      },
      function(xhr, status, error){
        //console.log(xhr.responseJSON);
        //console.log(xhr.status);
        //console.log(error);
        if(xhr.status == 422 || xhr.status == 200){
          //Importante limpiar todos los input, select, radio
          $('.clear').removeClass('has-error');
          $('.error-msj').html('');
          $.each(xhr.responseJSON, function(index, value) {
            //console.log(index);
            $('#container-'+index).addClass('has-error');
            $('#'+index).html(value);
          });
        }else{    
          BootstrapDialog.show({
            type: BootstrapDialog.TYPE_DANGER,
            title: 'Ocurrio un errror!',
            message: "<p style='color:ddd'>No se registro el usuario. Si persiste el error contacte al administrador.</p>",
            draggable: true
          }); 
        }        
      }
    );
   });
  
  $(document).on('click','.editarUsuario',function(){
    id = $(this).attr('data-id');
    page = $('.pagination .active span').text();
    redirect = baseUrl+'/consultar/usuarios';
    route = baseUrl+'/editar/user';
    token = $('#token').val();

    $.ajax({
      url: route,
      headers:{'X-CSRF-TOKEN': token},
      data: {id : id},
      type: 'POST',
      dataType: 'json',
      success: function(data){
        $('#myModalLabel').text('Editar usuario');
        $('#formEditar').html(data);
        $('.clear').addClass('disabled');
        validarFormUser();

        $('.disabled').prop('disabled', true);
        $('#submitModal').hide();
        $('#editar').show();
        $('#myModal').modal('show');
        $('#formUpdate').attr('action',baseUrl+'/actualizar/user');
        
        $('#editar').click(function() {
          $('.disabled').prop('disabled', false);
        
          $('#editar').hide();
          $('#submitModal').show().attr('type','button');
        });


        //Importante para que se ejecute el codigo dentro del click #submitModal una vez por cada secuencia que le den click al boton editar
        $( "#submitModal" ).unbind( "click" );


        $('#submitModal').click(function() {
          ajax(
            $('#formUpdate').attr('action'),
            $('#formUpdate').attr('method'),
            $('#token').val(),
            $('#formUpdate').serialize(),
            function(data) {

              BootstrapDialog.show({
                title: 'Registro de usuarios',
                message: 'Los datos de ' + data.usuario + ' han sido guardados!',
                draggable: true
              });

              $.ajax({
                  url: redirect,
                  data: {page: page},
                  type: 'GET',
                  dataType: 'json',
                  success: function(data){
                    //console.log(data);
                    $('#tabla-usuarios').html(data);
                    $('#'+id).hide().removeClass('fila-info');
                    $('#'+id).fadeIn(2000).addClass('fila-afectada');
                    caledario();
                  }
              }); 
                  
            },
            function(xhr, status, error){
              //$('#myModal').hide();

              if(xhr.status == 422 || xhr.status == 200){
                //Importante limpiar todos los input, select, radio
                $('.clear').removeClass('has-error');
                $('.error-msj').html('');
                $.each(xhr.responseJSON, function(index, value) {
                  //console.log(index);
                  $('#container-'+index).addClass('has-error');
                  $('#'+index).html(value);
                });
              }else{    
                BootstrapDialog.show({
                  type: BootstrapDialog.TYPE_DANGER,
                  title: 'Ocurrio un errror!',
                  message: "<p style='color:ddd'>No se edito el registro. Si persiste el error contacte al administrador.</p>",
                  draggable: true
                }); 
              }    
            }
          );
        });
      }
    });
      
  });


});