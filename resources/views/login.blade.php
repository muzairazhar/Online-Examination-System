@extends('layout.layout-common')

@section('space-work')

<div class="row">
    <div class="col-md-6 offset-3 mt-4">
        <h3 class="text-center">Login</h3>
        @if ($errors->any())
            @foreach ($errors->all() as  $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              
            @endforeach
        @endif

        @if(session('success'))
        <div class="alert alert-success append mt-3
         alert-dismissible fade show"  role="alert">
          <strong>{{ session('success') }}  </strong> 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

<form action="{{ route('userlogin') }}" method="post" autocomplete="off">
    @csrf

    <label for="" class="form-label" class="form-label">Email</label>
    <br>
    <input type="email" name="email" placeholder="Enter your Email" class="form-control">
    <br>
    <label for="" class="form-label" class="form-label">Password</label>
    <br>
    <input type="password" name="password" placeholder="Enter your password"  class="form-control">
    <br>
    <input type="submit" value="submit" class="btn btn-primary">
</form> 
{{-- <br> --}}
<a href="/forget-password"  class="mt-2" style="text-decoration: none">Forget Password?</a>
{{-- <a href="{{ url('/register') }}"  class="mt-3 ms-2" style="text-decoration: none">Register</a> --}}
<br>
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">

    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    {{Session::get('error')  }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
@endif
</div>
</div>
@endsection