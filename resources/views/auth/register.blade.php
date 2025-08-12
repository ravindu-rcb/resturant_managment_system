<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Register</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="navbar-nav ms-auto">
      <a class="nav-link" href="{{ route('login') }}">Login</a>
    </div>
  </div>
</nav>
<main class="container py-4">
  <h3>Create an account</h3>
  <form method="post" action="{{ route('register.store') }}" class="mt-3">
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
        <option value="cook" {{ old('role')==='cook'?'selected':'' }}>Cook</option>
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

    <button class="btn btn-primary">Register</button>
    <a href="{{ route('login') }}" class="btn btn-link">Already have an account?</a>
  </form>
</main>
</body>
</html>
