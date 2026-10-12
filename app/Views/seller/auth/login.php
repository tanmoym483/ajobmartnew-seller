
<div class="aj-seller-login-page">
    <div class="aj-seller-login-card">

        <!-- LEFT: SELLER BENEFITS -->
        <div class="aj-seller-login-info">

            <div class="aj-seller-login-brand">
                Ajob<span>mart</span>
            </div>

            <h1>Welcome back to your seller business.</h1>

            <p>
                Sign in to manage your products, track orders and
                grow your business with Ajobmart.
            </p>

            <ul class="aj-seller-login-benefits">
                <li>
                    <span class="aj-seller-login-check">✓</span>
                    <span>Manage products and inventory from one place.</span>
                </li>
                <li>
                    <span class="aj-seller-login-check">✓</span>
                    <span>Track customer orders and delivery status.</span>
                </li>
                <li>
                    <span class="aj-seller-login-check">✓</span>
                    <span>Monitor sales and seller account information.</span>
                </li>
                <li>
                    <span class="aj-seller-login-check">✓</span>
                    <span>Get back to growing your online store.</span>
                </li>
            </ul>

        </div>

        <!-- RIGHT: LOGIN FORM -->
        <div class="aj-seller-login-form-area">

            <h2>Seller Login</h2>

            <p class="aj-seller-login-subtitle">
                Enter your registered email and password.
            </p>

            <!-- Server-side errors -->
            <?php $loginErrors = session()->getFlashdata('errors'); ?>

            <?php if (! empty($loginErrors)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($loginErrors as $error): ?>
                        <div><?= esc($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('seller/login/authenticate') ?>"
                  method="post"
                  id="ajSellerLoginForm">

                <?= csrf_field() ?>

                <div class="mb-4">
                    <label for="sellerLoginEmail"
                           class="aj-seller-login-label">
                        Email address
                    </label>

                    <input type="email"
                           class="aj-seller-login-input"
                           id="sellerLoginEmail"
                           name="email"
                           placeholder="you@example.com"
                           value="<?= esc(old('email') ?? '') ?>"
                           maxlength="190"
                           autocomplete="username"
                           required>
                </div>

                <div>
                    <label for="sellerLoginPassword"
                           class="aj-seller-login-label">
                        Password
                    </label>

                    <div class="aj-seller-login-input-wrap">
                        <input type="password"
                               class="aj-seller-login-input aj-seller-login-password"
                               id="sellerLoginPassword"
                               name="password"
                               placeholder="Enter your password"
                               autocomplete="current-password"
                               required>

                        <button type="button"
                                class="aj-seller-login-toggle"
                                id="ajSellerTogglePassword"
                                aria-label="Show password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="aj-seller-login-options">
                    <label>
                        <input type="checkbox" id="ajSellerRemember">
                        Remember me
                    </label>

                    <a href="<?= site_url('seller/forgot-password') ?>">
                        Forgot password?
                    </a>
                </div>

                <button type="submit"
                        class="aj-seller-login-submit"
                        id="ajSellerLoginButton">
                    Sign In to Seller Panel
                </button>

            </form>

            <div class="aj-seller-login-footer">
                Don't have a seller account?
                <a href="<?= site_url('/') ?>">
                    Register now
                </a>
            </div>

            <div class="aj-seller-login-security">
                <i class="fa-solid fa-lock"></i>
                Secure seller account access
            </div>

        </div>
    </div>
</div>



