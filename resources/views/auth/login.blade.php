<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ACTS') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('public/build/assets/images/smmie_logo.ico') }}" type="image/ico">
  </head>
  <style type="text/css">
    @media (min-width: 768px) {
      .gradient-form {
        height: 100vh !important;
      }
    }
  </style>
  <body>
    <section class="h-100 gradient-form bg-info">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100"> 
          <div class="col-xl-5">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-12">
                  <div class="card-body p-md-3 mx-md-4">

                    <div class="text-center">
                      <img src="{{ asset('public/build/assets/images/acts_logo_alone.jpg') }}" style="width: 95px;" alt="logo">
                      <h4 class="mt-1 mb-3 pb-1">ACTS Payroll System</h4>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                      @csrf
                      <div class="form-outline mb-3">
                        <div class="input-group">
                          <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInputGroup" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="floatingInputGroup">{{ __('Email') }}</label>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                        </div>
                      </div>

                      <div class="form-outline mb-3">
                        <div class="input-group">
                          <div class="form-floating">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingInputGroup2" placeholder="Password" required autocomplete="current-password">
                            <label for="floatingInputGroup2">{{ __('Password') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>  
                      </div>

                      <div class="text-center pt-1 mb-2 pb-1">
                        {{-- <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button> --}}
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            {{ __('Login') }}
                        </button>
                      </div>

                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
