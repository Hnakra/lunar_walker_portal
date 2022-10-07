<h1 style="padding-top: 100px">@yield('title')</h1>
@foreach($users as $user)
    <div>{{$user->name}}</div>
@endforeach
<br>
