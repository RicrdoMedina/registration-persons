@if(Session::has('message_error'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <ul>
  		<li>{{Session::get('message_error')}}</li>
  </ul>
</div>
@endif