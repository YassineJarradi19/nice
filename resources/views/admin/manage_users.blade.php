@extends('layouts.master')

@section('content')
<div>
    <h2>Manage Users</h2>
    @foreach($users as $user)
    <form method="POST" action="{{ route('user.update', $user) }}">
        @csrf
        <!-- User fields like name, email, role, etc. -->
        <input type="text" name="name" value="{{ $user->name }}" />
        <button type="submit">Update</button>
    </form>
    <form method="POST" action="{{ route('user.delete', $user) }}">
        @csrf
        <button type="submit">Delete</button>
    </form>
    @endforeach
</div>
@endsection
