@include('components.header')

{{-- <div class="container">
    <h1>User Profile</h1>

    <p><strong>Username:</strong> {{ $user->fullname }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Member Since:</strong> {{ $user->created_at->format('F d, Y') }}</p>

    <!-- If you have additional fields in the User model, display them here -->

    <a href="{{ route('home') }}" class="btn btn-primary">Edit Profile</a>
</div> --}}


<div class="container py-md-5 container--narrow">
    <h2>
      <img class="avatar-small" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" /> {{$fullname}}
      <form class="ml-2 d-inline" action="#" method="POST">
        <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
        <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
      </form>
    </h2>

    <div class="profile-nav nav nav-tabs pt-2 mb-4">
      <a href="#" class="profile-nav-link nav-item nav-link active">Posts:  </a>
      <a href="#" class="profile-nav-link nav-item nav-link">Followers: 3</a>
      <a href="#" class="profile-nav-link nav-item nav-link">Following: 2</a>
    </div>

    {{-- <div class="list-group">
      @foreach($posts as $post)
      <a href="/post/{{$post->id}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" />
        <strong>{{$post->title}}</strong> on {{$post->created_at->format('n/j/Y')}}
      </a>
      @endforeach
    </div> --}}
  </div>

@include('components.footer')
