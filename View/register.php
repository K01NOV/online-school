<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/registration.css">
</head>
<body>
    <form action="/register" method="POST">
        <h3>Registration</h3>
        <input type="text" placeholder="name" name="name">
        <input type="email" placeholder="email" name="email">
        <select name="account_type" id="">
            <option value="Личный аккаунт">Личный аккаунт</option>
            <option value="Ученик">Ученик</option>
            <option value="Учитель">Учитель</option>
            <option value="Родитель">Родитель</option>
        </select>
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
    <form action="/login" method="POST">
        <h3>Authorization</h3>
        <input type="email" placeholder="email" name="email">
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
</body>
</html>