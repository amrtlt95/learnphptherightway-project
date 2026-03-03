<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Create a user</title>
    </head>
    <body>
        <form method="post" action="/users/create">
            <label for="username">Username</label>
            <input id="username" name="username">
            </br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            </br>
            <button type="submit">Create</button>
        </form>
    </body>
</html>
