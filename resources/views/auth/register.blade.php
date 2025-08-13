<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Register</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Full-page background with dark overlay (same as login) */
    body.login-bg{
      min-height: 100vh;
      background-image:
        linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)),
        url('{{ asset('images/registration-bg.webp') }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    /* Translucent card with blur (match login) */
    .glass-card{
      background: rgba(255,255,255,.82);
      -webkit-backdrop-filter: blur(6px);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255,255,255,.35);
    }
    /*primary color for buttons*/
    .btn-primary{
      background-color:#FF9B00 !important;
      border-color:#FF9B00 !important;
      color:#fff;
    }
    .btn-primary:hover,
    .btn-primary:focus{
      background-color:#e68c00 !important;
      border-color:#e68c00 !important;
    }
    .btn-primary:active,
    .btn-primary.active{
      background-color:#cc7d00 !important;
      border-color:#cc7d00 !important;
    }
    .btn-primary:focus-visible{
      box-shadow:0 0 0 .25rem rgba(255,155,0,.35) !important;
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
      <a class="nav-link" href="{{ route('login') }}">Login</a>
    </div>
  </div>
</nav>

<!-- Centered translucent card like login -->
<main class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 56px);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
        <div class="card shadow-lg glass-card border-0">
          <div class="card-body p-4 p-sm-5">
            <h1 class="h4 mb-3 text-center">Create an account</h1>

            @if ($errors->any())
              <div class="alert alert-danger">Please fix the errors below.</div>
            @endif

            <form method="post" action="{{ route('register.store') }}" class="mt-2">
              @csrf

              <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" required value="{{ old('name') }}">
                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                  <option value="">-- Select Role --</option>
                  <option value="cook"    {{ old('role')==='cook'?'selected':'' }}>Cook</option>
                  <option value="cashier" {{ old('role')==='cashier'?'selected':'' }}>Cashier</option>
                  <option value="manager" {{ old('role')==='manager'?'selected':'' }}>Manager</option>
                </select>
                @error('role')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>

              <button class="btn btn-primary w-100">Register</button>
            </form>

            <div class="text-center mt-3">
              <small class="text-muted">Already have an account?</small>
              <a href="{{ route('login') }}" class="small ms-1">Sign in</a>
            </div>
          </div>
        </div>

        <!-- footer text -->
        <p class="text-center text-white-50 mt-3 mb-0 small">
          &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
      </div>
    </div>
  </div>
</main>

</body>
</html>
