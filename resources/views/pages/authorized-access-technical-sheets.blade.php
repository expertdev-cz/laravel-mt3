@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<livewire:authorized-access.downloads-list page-type="authorized-access-technical-sheets" />
@endsection

@section('footer')
<x-footer />
@endsection