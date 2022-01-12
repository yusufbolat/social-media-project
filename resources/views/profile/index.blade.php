@extends('templates.default')

@section('content')

    <div class="row">
        @if (Auth::check())
            @if (Auth::user()->hasFriendRequestPending($user))
                <p class="mt-5 text-center">Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <form action=" {{ route('friend.delete', ['username' => $user->username]) }} " method="POST">
                            <input type="submit" value="Delete friend request" class="nav-link btn btn-outline-warning">
                            @csrf
                        </form>
                    </li>
                </ul>
            @elseif (Auth::user()->hasFriendRequestReceived($user))
                <p class="mt-5 text-center">Accept friend request.</p>
                <ul class="nav justify-content-center">
                    <li class="nav-item me-5">
                        <a href=" {{ route('friend.accept', ['username' => $user->username]) }} " class="nav-link btn btn-outline-primary">Accept</a>
                    </li>
                    <li class="nav-item ms-5">
                        <form action=" {{ route('friend.delete', ['username' => $user->username]) }} " method="POST">
                            <input type="submit" value="Delete friend request" class="nav-link btn btn-outline-warning">
                            @csrf
                        </form>
                    </li>
                </ul>
            @elseif (Auth::user()->isFriendsWith($user))
                <p class="mt-5 text-center">Profile of your friend {{ $user->getNameOrUsername() }}</p>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <form action=" {{ route('friend.delete', ['username' => $user->username]) }} " method="POST">
                            <input type="submit" value="Delete friend" class="nav-link btn btn-outline-primary">
                            @csrf
                        </form>
                    </li>
                </ul>

            @elseif (Auth::user()->id !== $user->id)
                <p class="mt-5 text-center">Do you know {{ $user->getNameOrUsername() }} ?</p>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a href=" {{ route('friend.add', ['username' => $user->username]) }} " class="nav-link btn btn-outline-primary">Yes, add as friend</a>
                    </li>
                </ul>
            @endif 
        @endif
        <div class="col-lg-7">
            <div class="mt-5">
                <div class="d-flex">
                    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNameOrUsername() }}"
                        class="flex-shrink-0 me-5 mt-1 mb-1 rounded-circle" style="width:100px;height:100px;">
                    <div class="ms-3 mt-1">
                        <h4 class="text-primary">{{ $user->getNameOrUsername() }}</h4>
                        @if ($user->location)
                            <p>{{ $user->location }}</p>
                        @else
                            <p>Location information not available!</p>
                        @endif
                    </div>
                </div>
            </div>
            <hr>
            @if (!$statuses->count())
                <p>{{ $user->getFirstNameOrUsername() }} hasn't posted anything yet.</p>
            @else
                @foreach ($statuses as $status)
                    <div class="card mb-3">
                        <div class="col g-0">
                            <div style="padding:0; margin:0;"class="col">
                                @if ($status->img_url)
                                    <div style="padding:0; margin:0;"class="col">
                                        <img style="max-width: 100%; max-height: 600px;" src="{{ asset("storage/images/$status->img_url") }}" class="img-fluid rounded-top" alt="...">
                                    </div>        
                                @endif
                            </div>
                            <div class="col">
                                <div class="card-body">
                                    <a style="text-decoration: none;" href="{{ route('profile.index', ['username' => $status->user->username]) }}"><h6 class="card-title">{{ $status->user->getNameOrUsername() }}</h6></a>
                                    <p style="white-space: pre-wrap;" class="card-text">{{ $status->body }}</p>
                                    <hr>
                                    <div class="d-flex align-items-center justify-content-center bd-highlight mb-3" style="margin:0 !important;">
                                        @if (Auth::check())
                                            @if ( Auth::user()->hasLikedStatus($status) )
                                                <a href="{{ route('status.like', ['statusId' => $status->id]) }}" style="width:auto;"><i style="color:red; font-size:1.3rem; margin-bottom:0 !important" class="bi bi-heart-fill p-2 bd-highlight"></i></a>
                                            @else
                                                <a href="{{ route('status.like', ['statusId' => $status->id]) }}" style="width:auto;"><i style="color:black; font-size:1.3rem; margin-bottom:0 !important" class="bi bi-heart p-2 bd-highlight"></i></a>    
                                            @endif
                                        @else
                                            <a href="{{ route('auth.signin') }}" style="width:auto;"><i style="color:black; font-size:1.3rem; margin-bottom:0 !important" class="bi bi-heart p-2 bd-highlight"></i></a>
                                        @endif
                                        <p class="text-start p-2 bd-highlight" style="font-size:0.8rem; font-weight:600; margin-bottom:0 !important">{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</p>
                                        <p class="text-end text-muted ms-auto p-2 bd-highlight" style="font-size:0.7rem; margin-bottom:0 !important">Last updated {{ $status->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            @if (Auth::check())
                                @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                                    <form action="{{ route('status.reply', ['statusId' => $status->id]) }}" role="form" method="POST">
                                        <div class="form-group d-flex align-items-center justify-content-around bd-highlight mt-2">
                                            <div class="p-2 bd-highlight flex-grow-1">
                                                <textarea name="reply-{{ $status->id }}" class="form-control" rows="1" placeholder="Reply to this status"></textarea>
                                            </div>
                                            <div class="ms-auto p-2 bd-highlight">
                                                <input type="submit" value="Reply" class="btn btn-primary btn-md">
                                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @endif
                            <div class="comments row mt-3">
                                @if (!$status->replies->count())
                                    <p style="font-size: 0.7rem; color: grey;">No comments yet.</p>
                                @endif
                                @foreach ($status->replies as $reply)
                                    <div class="mt-1">
                                        <div class="d-flex">
                                            <img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->getNameOrUsername() }}"
                                                class="flex-shrink-0 rounded-circle" style="width:30px;height:30px;">
                                            <div class="ms-3 mt-1">
                                                <p class="text-primary" style="font-size: 0.8rem;"><a style="text-decoration: none;" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a> <small style="color:black;">{{ $reply->body }}</small></p>
                                                <p style="font-size: 0.7rem; color: grey;">{{ $reply->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-4 col-lg-offset-1 ms-auto">
            <h4 class="mt-5">{{ $user->getFirstNameOrUsername() }}'s friends.</h4>

            @if (!$user->friends()->count())
                <p>{{ $user->getFirstNameOrUsername() }} has no friends.</p>
            @else
                @foreach ($user->friends() as $user)
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