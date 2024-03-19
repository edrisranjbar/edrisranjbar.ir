@php use Morilog\Jalali\Jalalian; @endphp
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
    @include('sections.tutorials')
    @include('sections.about')
    @include('sections.blog')
    @include('sections.contact')
</main>
@stop()