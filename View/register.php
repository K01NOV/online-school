<div class="reg-auth-container">
    <form class="reg-auth-form" action="/register" method="POST">
        <h3>Регистрация</h3>
        <?php if(isset($_SESSION['error'])): ?>
            <p style="color: #f0785d"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']);?></p>
        <?php endif?>
        <input type="text" placeholder="Имя" name="name" >
        <input type="email" placeholder="Почта" name="email">
        <input type="text" placeholder="Юзернейм" name="nick" id="nick">
        <select name="account_type" id="selector" readonly>
            <option value="Личный аккаунт">Личный аккаунт</option>
        </select>
        <input type="password" placeholder="Пароль" name="password">
        <input type="submit">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['auth_token'])?>" style="display: none">
    </form>
    <form class="reg-auth-form" action="/login" method="POST">
        <h3>Войти</h3>
        <input type="text" placeholder="Почта или Юзернейм" name="login">
        <input type="password" placeholder="Пароль" name="password">
        <input type="submit">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['auth_token'])?>" style="display: none">
    </form>
</div>


