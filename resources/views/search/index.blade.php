<?php

/**
 * @var \Illuminate\Html\FormBuilder $formBuilder
 * @var \App\City[] $cities
 * @var \App\Http\Forms\SearchForm $form
 * @var \App\Vacancy[] $vacancies
 * @var Illuminate\Pagination\AbstractPaginator $paginator
 */

?>
@extends('layouts.app')
@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            {!! $formBuilder->model($form, ['action' => 'SearchController@search', 'method' => 'get']) !!}

            {!! $formBuilder->text('query') !!}

            {!! $formBuilder->select('city', $cities) !!}

            {!! $formBuilder->submit('Искать') !!}

            {!! $formBuilder->close() !!}
        </div>
    </div>
</div>

<div class="vacancies">
    @if ($vacancies !== null)
        @foreach ($vacancies as $vacancy)
            <div class="vacancy">
                <h2>{!! $vacancy->title !!}</h2>
                <span class="city">{{ $vacancy->city->name }}</span>
                <div class="description">{!! nl2br(e($vacancy->description)) !!}</div>
            </div>
        @endforeach

        {{ $paginator->render() }}
    @endif
</div>
@stop
