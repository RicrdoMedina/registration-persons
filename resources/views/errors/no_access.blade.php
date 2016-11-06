@extends('layouts.Base')

@section('content')

   @include('layouts.Heading')

        <div class="row">
            
            <div class="col-lg-12">
                <div class="jumbotron">
                    <h1><span class="error-404">Ups!</span>
                    </h1>
                    <p>@include('layouts.Message_error')</p>
                   
                </div>
            </div>

        </div>

        <hr>

@endsection