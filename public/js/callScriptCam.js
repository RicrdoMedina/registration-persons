/***********************************************************
*********** Script Cam*********
************************************************************/
$(document).ready(function() {

var baseUrl = $('#base-url').attr('data-url');

    $("#webcam").scriptcam({
        showMicrophoneErrors:false,
        onError:onError,
        cornerRadius:20,
        disableHardwareAcceleration:1,
        cornerColor:'e3e5e2',
        onWebcamReady:onWebcamReady,
        uploadImage:baseUrl+'/js/ScriptCam/upload.gif',
        onPictureAsBase64:base64_tofield_and_image
    });
});

function base64_tofield() {

    $('#imageBase64').val($.scriptcam.getFrameAsBase64());
};

function base64_toimage() {

    $('#image').attr('src','data:image/png;base64,'+$.scriptcam.getFrameAsBase64());

};

function base64_tofield_and_image(b64) {

  $('#imageBase64').val(b64);
  $('#imageBase64').attr('data-photo',1);
  $('#image').attr('src','data:image/png;base64,'+b64);
};

function changeCamera() {
    $.scriptcam.changeCamera($('#cameraNames').val());
}

function onError(errorId,errorMsg) {


    $( '#btn1' ).attr( 'disabled', true );

    $( '#btn2' ).attr( 'disabled', true );

  alert(errorMsg);

}          

function onWebcamReady(cameraNames,camera,microphoneNames,microphone,volume) {

    $.each(cameraNames, function(index, text) {

        $('#cameraNames').append( $('<option></option>').val(index).html(text) )

    });

    $('#cameraNames').val(camera);



}