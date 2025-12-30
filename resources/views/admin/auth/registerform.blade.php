<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Register form</h1>

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <label for="email">Email</label>
        <input type="email" placeholder="Enter Your Email" name="email">
        <label for="password">Password</label>
        <input type="text" placeholder="Enter Your Password" name="password">

        <input type="submit">
    </form>
</body>
</html>