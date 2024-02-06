@extends('layouts.app')

@section('title', 'Edit assembly')

@section('content')
    <assemblies.edit :assembly='@json($assembly)'></assemblies.edit>
@endsection
