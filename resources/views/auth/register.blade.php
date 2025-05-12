<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Your E-commerce</title>
<link rel="stylesheet" href="css\styles2.css">
</head>
<body>
<div class="register-container">
  <h2>Register</h2>
  <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>

    <button type="submit">Register</button>
  </form>
</div>
</body>
</html>
