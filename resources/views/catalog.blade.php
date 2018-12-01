@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Артикул</th>
                        <th scope="col">Название</th>
                        <th scope="col">Цена 0</th>
                        <th scope="col">Цена 1</th>
                        <th scope="col">Цена 2</th>
                        <th scope="col">Цена 3</th>
                        <th scope="col">Цена 4</th>
                        <th scope="col">Цена 5</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($catalog as $item)
                        <tr>
                            <th scope="row">{{ $item->article }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price_0 }}</td>
                            <td>{{ $item->price_1 }}</td>
                            <td>{{ $item->price_2 }}</td>
                            <td>{{ $item->price_3 }}</td>
                            <td>{{ $item->price_4 }}</td>
                            <td>{{ $item->price_5 }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection