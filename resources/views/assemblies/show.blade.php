@extends('layouts.app')

@section('title', 'Assembly details')

@section('content')
    <assemblies.show :assembly='@json($assembly)'></assemblies.show>
@endsection
