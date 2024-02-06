@extends('layouts.app')

@section('title', 'Component details')

@section('content')
    <components.show :component='@json($component)'></components.show>
@endsection
