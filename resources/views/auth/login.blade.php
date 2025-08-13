<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Full-page background with a soft dark overlay */
    body.login-bg{
      min-height: 100vh;
      background-image:
        linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)),
        url('{{ asset('images/login-bg.webp') }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    /* Translucent card with subtle blur */
    .glass-card{
    background: rgba(255,255,255,.60);
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.25);
    }
    /* Make the Login button use #FF9B00 */
    .btn-primary{
        background-color:#FF9B00 !important;
        border-color:#FF9B00 !important;
        color:#fff;
    }
    .btn-primary:hover,
    .btn-primary:focus{
        background-color:#e68c00 !important; /* slightly darker on hover/focus */
        border-color:#e68c00 !important;
    }
    .btn-primary:active,
    .btn-primary.active{
        background-color:#cc7d00 !important; /* pressed state */
        border-color:#cc7d00 !important;
    }
    .btn-primary:focus-visible{
        box-shadow:0 0 0 .25rem rgba(255,155,0,.35) !important; /* accessible focus ring */
    }
    .btn-primary:disabled{
        background-color:#FFB24D !important;
        border-color:#FFB24D !important;
    }
  </style>
</head>
<body class="login-bg">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="navbar-nav ms-auto">
      <a class="nav-link" href="{{ route('register') }}">Register</a>
    </div>
  </div>
</nav>

<!-- Center the card below the navbar -->
<main class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 56px);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
        <div class="card shadow-lg glass-card border-0">
          <div class="card-body p-4 p-sm-5">
            <h1 class="h4 mb-3 text-center">Sign In</h1>

            @if($errors->any())
              <div class="alert alert-danger">Invalid email or password.</div>
            @endif

            <form method="post" action="{{ route('login.attempt') }}" class="mt-2">
              @csrf

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
              </div>

              <button class="btn btn-primary w-100">Login</button>
            </form>

            <div class="text-center mt-3">
              <small class="text-muted">Don’t have an account?</small>
              <a href="{{ route('register') }}" class="small ms-1">Register</a>
            </div>
          </div>
        </div>

        <!-- brand/footer text under the card -->
        <p class="text-center text-white-50 mt-3 mb-0 small">
          &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
      </div>
    </div>
  </div>
</main>

</body>
</html>
