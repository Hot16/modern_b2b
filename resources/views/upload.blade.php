@extends('layouts.app')

@section('content')
{{--    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Загрузка файла</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                                {{ session('price') }}
                                @if(session('status') != 'Импорт завершен')
                                <a href="{{ route('import') }}" class="btn bg-success">{{ __('Импортировать') }}</a>
                                @endif
                            </div>
                        @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {!! Form::open(['url' => '/upload', 'files' => true]) !!}
                            {!! Form::file('price'); !!}
                            {!! Form::submit('Загрузить') !!}
                            {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <upload-form></upload-form>
@endsection
