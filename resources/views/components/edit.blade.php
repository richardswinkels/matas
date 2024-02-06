@extends('layouts.app')

@section('title', 'Edit component')

@section('content')
    <components.edit :component='@json($component)'></components.edit>
@endsection
