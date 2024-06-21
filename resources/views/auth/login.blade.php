@extends('auth._layout')
@section('auth')
<div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-2">
        <a href="{{url('/')}}" class="navbar-brand navbar-brand-autodark"><img src="{{asset('assets/favicon.png')}}" height="128" alt="keuangan"></a>
      </div>
      <div class="card card-md">
        <div class="card-body">
            @error('notLogin')
            <div class="alert alert-danger" role="alert">
                {{$message}}
              </div>
            @enderror
          <h2 class="h2 text-center mb-4">Login to your account</h2>
          <form action="{{url('/login')}}" method="post" autocomplete="off" novalidate>
            @csrf

            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="text" class="form-control @if ($errors->get('email'))
                  is-invalid
              @endif" name="email" placeholder="Your email" autocomplete="off" value="{{old('email')}}">
              @if ($errors->get('email'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('email') as $msg)
                    {{$msg}}
                    @endforeach
                </div>
              @endif
            </div>

            <div class="mb-2">
              <label class="form-label" for="password">
                Password
              </label>
              <input type="password" class="form-control @if ($errors->get('password'))
              is-invalid
          @endif" name="password" placeholder="Your password"  autocomplete="off">
            @if ($errors->get('password'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('password') as $msg)
                    {{$msg}}
                    @endforeach
                </div>
            @endif
            </div>

            <div class="mb-2">
              <label class="form-check" for="remember_me">
                <input type="checkbox" id="remember_me" name="remember" class="form-check-input"/>
                <span class="form-check-label">Remember me on this device</span>
              </label>
            </div>

            <div class="form-footer">
              <button type="submit" class="btn btn-green w-100">Sign in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
