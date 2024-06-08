@extends('layout.layout-common')
@section('space-work')
<div class="container">
    <div class="text-center">
        <h1>Thanks for submit your Exam,{{ Auth::user()->name }}</h1>
        <p>We will review your Exam, and update you soon  by mail.</p>
        <a href="/dashboard" class="btn btn-info">Go Back</a>

    </div>
</div>
@endsection