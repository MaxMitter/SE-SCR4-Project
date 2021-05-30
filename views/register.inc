<?php $render('partial/header', $data); ?>

    <h1>Register</h1>

<?php $beginForm('User', 'Register', method: 'post'); ?>
    <div class="mb-3">
        <label for="userName" class="form-label">User name</label>
        <input class="form-control" id="userName" name="un" value="<?php $htmlOut($data['userName']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="pwd" required>
        <label for="password2" class="form-label">Repeat Password</label>
        <input type="password" class="form-control" id="password2" name="pwd2" required>
        <?php if (isset($data['errors'])): ?>
            <p style="color: #bb2d3b"><?php $htmlOut($data['errors'][0]); ?></p>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary">Log in</button>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>