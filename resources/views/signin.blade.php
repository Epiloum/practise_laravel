<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in</title>
<style>
    label {
        display: inline-block;
        width: 80px;
    }
</style>
</head>
<body>
<h1>Sign in</h1>
@if ($errors->any())
    <div class="alert">
        <h2>Errors Occurred</h2>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" action="/signin/proc">
    {{ csrf_field() }}
    <div>
        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" value="" />
        @error('email')
            <span>{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="pw" value="" />
        @error('pw')
        <span>{{ $message }}</span>
        @enderror
    </div>
    <div>
        <input type="submit" value="Sign in" />
    </div>
</form>
</body>
</html>
