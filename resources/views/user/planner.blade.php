@extends('layouts.newuser', ['htmlclass' => 'planner-wrap'])

@section('title')
    <div class="header__title">
        <span>My Planner</span>
    </div>

    <div class="current-date{{ ( ! Auth::check()) ? ' not-logged-in' : '' }}">
        <a href="{{ $planner->previousWeekUrl($weekStartDate) }}">
            <i class="date-icon chevron--prev"><svg width="8" height="12" viewBox="0 0 8 12" xmlns="http://www.w3.org/2000/svg"><path class="icon-vector" d="M2 0L.6 1.4 5.2 6 .6 10.6 2 12l6-6-6-6z"></path></svg></i>
        </a>
        <span>{{ $planner->formatDate($weekStartDate) }}</span>
        <a href="{{ $planner->nextWeekUrl($weekStartDate) }}">
            <i class="date-icon chevron--next"><svg width="8" height="12" viewBox="0 0 8 12" xmlns="http://www.w3.org/2000/svg"><path class="icon-vector" d="M2 0L.6 1.4 5.2 6 .6 10.6 2 12l6-6-6-6z"></path></svg></i>
        </a>
    </div>
@endsection

@section('sidebar')
    <Plannerfilters></Plannerfilters>
@endsection

@section('content-header')

    <header id="planner-header" class="planner__header">
        <div class="wrapper">
            @foreach ($thisweek as $weekitem)
            <div class="header__day">
                <span>{{ $weekitem['day'] }}</span>
                <span>{{ $weekitem['date'] }}</span>
            </div>
            @endforeach
        </div>
    </header>

@endsection

@section('content')

    <Planner></Planner>

@endsection
