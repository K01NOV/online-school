<div class="mini-profile">
    <img class="mini-profile-avatar" src="/assets/avatar3.png" alt="">
    <div class="mini-profile-info">
        <p class="mini-profile-name">
            <?php echo htmlspecialchars($_SESSION['name'])?>
        </p>
        <?php if(isset($_SESSION['nickname'])): ?>
            <p class="mini-profile-nickname">
                <?php echo htmlspecialchars($_SESSION['nickname']) ?>
            </p>
        <?php endif?>
    </div>
    <form action="/logout" method="POST">
        <button class="mini-profile-logout" type="submit">Выйти ></button>
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['auth_token'])?>" style="display: none">
    </form>
</div>