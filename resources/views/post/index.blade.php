@extends('welcome')

@section('title', 'Tabela')

@section('content')
    <div class="container">
        <table class="table table-striped table-hover">
            <tr class="table-success text-center">
                <th style="min-width: 200px;">Autor</td>
                <th>Treść</td>
            </tr>
            @foreach ($posts as $key => $value)
                <tr>
                    <td>{!! $value->user->name !!}</td>
                    <td>{!! $value->body !!}</td>
                </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
            {!! $posts->links() !!}
        </div>
    </div>
@stop
