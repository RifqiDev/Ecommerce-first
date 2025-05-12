<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Your E-commerce</title>
<link rel="stylesheet" href="css\styles.css">
</head>
<body>

<div class="login-container">
  <h2>Login</h2>
  @if($errors->any())
  <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div>
@endif

  <form action="{{ url('login') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="email">Email/Username:</label>
      <input type="text" value="{{ old('email') }}" id="email" name="email" >
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" value="{{ old('password') }}" id="password" name="password" >
    </div>
    <button type="submit">Login</button>
  </form>
  <div class="options">
    <a href="#">Forgot Password?</a>
    <span>or</span>
    <a href="{{ url('register ') }}">Create an Account</a>
  </div>
</div>
</body>
</html>
