<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('videos') }}">List</a></li>
        <li><a href="{{ URL::to('videos/create') }}">Upload a video</a>
        <li><a href="{{ URL::to('liked-videos') }}">Liked videos</a>
    </ul>
</nav>