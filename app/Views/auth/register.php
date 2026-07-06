<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

    <!-- Auth Tabs -->
    <div class="auth-tabs">
      <a href="<?= url_to('login') ?>" class="auth-tab" id="tab-login">Masuk</a>
      <a href="<?= url_to('register') ?>" class="auth-tab auth-tab-register active" id="tab-register">Daftar</a>
    </div>

    <!-- Register Form -->
    <form action="<?= url_to('register') ?>" method="post" class="auth-form" style="margin-top: 20px;">
        <?= csrf_field() ?>

        <?php if (session('error') !== null) : ?>
            <div class="alert alert-danger" role="alert" style="margin-bottom: 20px; font-size: 0.95rem; line-height: 1.5; font-weight: 600; text-align: left;"><?= esc(session('error')) ?></div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="alert alert-danger" role="alert" style="margin-bottom: 20px; font-size: 0.95rem; line-height: 1.5; font-weight: 600; text-align: left;">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <?= esc($error) ?><br>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= esc(session('errors')) ?>
                <?php endif ?>
            </div>
        <?php endif ?>

        <!-- Email -->
        <div class="auth-group">
            <label class="auth-label" for="floatingEmailInput"><?= lang('Auth.email') ?></label>
            <input type="email" class="auth-input" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="nama@email.com" value="<?= old('email') ?>" required>
        </div>

        <!-- Username -->
        <div class="auth-group">
            <label class="auth-label" for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
            <input type="text" class="auth-input" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="Username Anda" value="<?= old('username') ?>" required>
        </div>

        <!-- Password -->
        <div class="auth-group">
            <label class="auth-label" for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
            <input type="password" class="auth-input" id="floatingPasswordInput" name="password" autocomplete="new-password" placeholder="••••••••" required>
        </div>

        <!-- Password (Again) -->
        <div class="auth-group">
            <label class="auth-label" for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
            <input type="password" class="auth-input" id="floatingPasswordConfirmInput" name="password_confirm" autocomplete="new-password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-terracotta" style="width: 100%; margin-top: 10px;"><?= lang('Auth.register') ?></button>

    </form>

<?= $this->endSection() ?>
