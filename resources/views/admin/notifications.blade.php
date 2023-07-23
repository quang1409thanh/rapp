@extends('layouts.app')

@section('content')
    <h1>Notifications</h1>

    @if($notifications->isEmpty())
        <p>No notifications.</p>
    @else
        <ul>
            @foreach($notifications as $notification)
                <li>{{ $notification->data['subject'] }} - {{ $notification->created_at }}</li>
            @endforeach
        </ul>
    @endif
@endsection
