$(document).ready(function() {
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
  
  $(document).on('click','.editarUsu',function(){
    alert('hdhd');
    
    
  });
});