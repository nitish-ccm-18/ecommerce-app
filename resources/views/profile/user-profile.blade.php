@extends('layouts.dashboard.main')
@section('title')
    User Profile
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ $profile[0]->profile->avatar ? url('public/Image/Users/' . $profile[0]->profile->avatar) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' }}"
                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <p class="">
                            {{ $profile[0]->name }} <br>
                            <small><i class="fa-solid fa-envelope"></i>{{ $profile[0]->email }}</small>
                        </p>

                        <p class="text-muted mb-1">Occupation : {{ $profile[0]->profile->occupation }}</p>
                        <p class="text-muted mb-4">
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $profile[0]->profile->address }}
                        </p>
                        <p class="text-muted">
                            Gender : {{ $profile[0]->profile->gender ? $profile[0]->profile->gender : 'Not Selected' }}
                        </p>
                        <div class="d-flex justify-content-center mb-2">
                            <button type="button" class="btn btn-primary">Follow</button>
                            <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
