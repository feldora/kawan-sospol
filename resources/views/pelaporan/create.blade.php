@extends('layouts.landingpage', [
    'title' => 'Dashboard - Kesbangpol Sulteng',
    'showHeader' => true,
    'headerTitle' => 'Dashboard Kesbangpol Sulteng',
    'headerSubtitle' => 'Sistem Monitoring Konflik Sosial & Politik'
])

@section('content')
<div class="container mx-auto py-6 px-4 lg:px-6">
    <x-lapor-kawan />
</div>

@endsection
