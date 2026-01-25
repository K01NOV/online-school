<div class="reg-auth-container">
    <form class="reg-auth-form" action="/register" method="POST">
        <h3>Registration</h3>
        <?php if(isset($_SESSION['error'])): ?>
            <p style="color: #f0785d"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']);?></p>
        <?php endif?>
        <input type="text" placeholder="name" name="name" >
        <input type="email" placeholder="email" name="email">
        <input type="text" placeholder="nickname" name="nick" id="nick">
        <select name="account_type" id="selector">
            <option value="Личный аккаунт">Личный аккаунт</option>
            <option value="Ученик">Ученик</option>
            <option value="Учитель">Учитель</option>
            <option value="Родитель">Родитель</option>
        </select>
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
    <form class="reg-auth-form" action="/login" method="POST">
        <h3>Authorization</h3>
        <input type="email or nickname" placeholder="email" name="login">
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
</div>


<script src="js/nickname.js"></script>