@section('title', 'توسعه دهنده بک اند وب')
@section('body-class', 'bg-dark')
@section('header-class', 'bg-dark')
@extends('layouts.app')
@section('content')
<main class="container-fluid">
    @include('sections.hero')
    <section class="d-flex justify-content-center">
        <img src="{{ asset('images/arrow.svg') }}" class="arrow">
    </section>
    @include('sections.skills')
    @include('sections.about')
    <div class="container-fluid px-4">
        @include('sections.blog')
    </div>
    @include('sections.contact')
</main>
@stop()