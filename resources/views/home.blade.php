@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <notification-component user="{{ auth()->user() }}" notification-list-url="{{ route('notification.list') }}"
                    notification-read-all-url="{{ route('notification.read.all') }}"
                    notification-clear-all-url="{{ route('notification.clear.all') }}"></notification-component>
            </div>
        </div>
    </div>
@endsection
