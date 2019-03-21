@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {!! Form::open(['url' => '/clients/new']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Введите имя']) !!}
                {!! Form::text('login', null, ['class' => 'form-control', 'placeholder' => 'Введите логин'])!!}
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Введите email'])!!}
                {!! Form::select('price_level', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'], null, ['class' => 'form-control']) !!}
                {!! Form::submit('Создать', ['class' => 'btn btn-outline-success']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
