@extends('templates.default')

@section('content')
    <div class="row mt-5">
        <div class="col-lg-5">
            <h3>Your friends</h3>
            @if (!$friends->count())
                <p class="mt-3">You have no friends.</p>
            @else
                @foreach ($friends as $user)
                    <div class="mt-3 ms-0">
                        <a style="text-decoration: none; color: black;" href="{{ route('profile.index', ['username' => $user->username]) }}">
                            <div class="d-flex border p-3">
                                <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNameOrUsername() }}"
                                    class="flex-shrink-0 me-3 mt-1 mb-1 rounded-circle" style="width:70px;height:70px;">
                                <div class="ms-3 mt-1">
                                    <h5 class="text-primary">{{ $user->getNameOrUsername() }}</h5>
                                    @if ($user->location)
                                        <p>{{ $user->location }}</p>
                                    @else
                                        <p>Location information not available!</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-5 col-lg-offset-2 ms-auto">
            <h3>Friend requests</h3>
            @if (!$requests->count())
                <p class="mt-3">You have no friend requests.</p>
            @else
                @foreach($requests as $user)
                    <div class="mt-3 ms-0">
                        <a style="text-decoration: none; color: black;" href="{{ route('profile.index', ['username' => $user->username]) }}">
                            <div class="d-flex border p-3">
                                <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNameOrUsername() }}"
                                    class="flex-shrink-0 me-3 mt-1 mb-1 rounded-circle" style="width:70px;height:70px;">
                                <div class="ms-3 mt-1">
                                    <h5 class="text-primary">{{ $user->getNameOrUsername() }}</h5>
                                    @if ($user->location)
                                        <p>{{ $user->location }}</p>
                                    @else
                                        <p>Location information not available!</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@stop