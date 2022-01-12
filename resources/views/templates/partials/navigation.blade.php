<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand ms-5" href="/" style="font-size: 2rem; margin-right: 6rem; font-weight: 500;">Yuumi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @if (Auth::check())
            <ul class="navbar-nav me-auto my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href=" {{ route('home') }} ">Timeline</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href=" {{ route('friends.index') }} ">Friends
                        @if (Auth::user()->friendRequests()->count())
                            @if (Auth::user()->friendRequests()->count() > 9)
                                <span class="badge rounded-pill bg-danger text-light">9+</span>
                            @else
                                <span class="badge rounded-pill bg-danger text-light">{{ Auth::user()->friendRequests()->count() }}</span>
                            @endif
                        @endif
                    </a>
                </li>
            </ul>
            <form class="d-flex" role="search" action="{{ route('search.results') }}">
                <input class="form-control me-2" name="query" type="search" placeholder="Find people" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        @endif
        <ul class="navbar-nav ms-auto my-2 my-lg-0 me-5">
            @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">{{ Auth::user()->getFirstNameOrUsername() }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href=" {{ route('profile.edit') }} ">Update profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href=" {{ route('auth.signout') }} ">Sign out</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link active" href=" {{ route('auth.signup') }} ">Sign up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href=" {{ route('auth.signin') }} ">Sign in</a>
                </li>
            @endif
        </ul>

    </div>
  </div>
</nav>