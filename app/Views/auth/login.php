<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

    <!-- Auth Tabs -->
    <div class="auth-tabs">
      <a href="<?= url_to('login') ?>" class="auth-tab active" id="tab-login">Masuk</a>
      <a href="<?= url_to('register') ?>" class="auth-tab auth-tab-register" id="tab-register">Daftar</a>
    </div>

    <!-- Login Form -->
    <form action="<?= url_to('login') ?>" method="post" class="auth-form" style="margin-top: 20px;">
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

        <?php if (session('message') !== null) : ?>
            <div class="alert alert-success" role="alert" style="margin-bottom: 20px; font-size: 0.95rem; line-height: 1.5; font-weight: 600; text-align: left;"><?= esc(session('message')) ?></div>
        <?php endif ?>

        <!-- Email -->
        <div class="auth-group">
            <label class="auth-label" for="floatingEmailInput"><?= lang('Auth.email') ?></label>
            <input type="email" class="auth-input" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="nama@email.com" value="<?= old('email') ?>" required>
        </div>

        <!-- Password -->
        <div class="auth-group">
            <label class="auth-label" for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
            <input type="password" class="auth-input" id="floatingPasswordInput" name="password" autocomplete="current-password" placeholder="••••••••" required>
        </div>

        <!-- Remember me -->
        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
            <div class="form-check mb-4" style="text-align: left; padding-left: 24px; margin-top: -10px;">
                <input type="checkbox" name="remember" class="form-check-input" id="rememberMeCheck" <?php if (old('remember')): ?> checked<?php endif ?>>
                <label class="form-check-label small text-muted" for="rememberMeCheck">
                    <?= lang('Auth.rememberMe') ?>
                </label>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-terracotta" style="width: 100%; margin-top: 10px;"><?= lang('Auth.login') ?></button>

        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
            <p class="text-center small" style="margin-top: 15px; margin-bottom: 0;"><a href="<?= url_to('magic-link') ?>" class="text-decoration-none text-success" style="color: var(--accent-dark) !important; font-weight: 600;"><?= lang('Auth.useMagicLink') ?></a></p>
        <?php endif ?>

    </form>

<?= $this->endSection() ?>
