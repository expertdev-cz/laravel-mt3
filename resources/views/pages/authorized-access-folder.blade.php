@extends('layouts.app')
@section('title', $folder->title)

@section('content')
<livewire:authorized-access.downloads-list folder-slug="{{ $folder->slug }}" />
@endsection

@section('footer')
<x-footer />
@endsection
