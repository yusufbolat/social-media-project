<!--
<div class="container mt-3">
<h5>Media Object</h5>
<p>Create a media object without .media and .media-body classes (BS5):</p>
<div class="d-flex border p-3">
    <img src="https://cdn.pixabay.com/photo/2016/11/18/23/38/child-1837375_960_720.png" alt="John Doe"
         class="flex-shrink-0 me-3 mt-3 rounded-circle" style="width:60px;height:60px;">
    <div>
        <h4>John Doe <small>Posted on February 19, 2016</small></h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua.</p>
    </div>
</div>
</div>
-->

<div class="mt-3 col-6 ms-0">
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
