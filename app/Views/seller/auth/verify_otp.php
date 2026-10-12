


    <style>
        body {
            background: #f4f7fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .verify-card {
            background: #fff;
            width: 100%;
            max-width: 440px;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 12px 40px rgba(0,0,0,.08);
        }

        .verify-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #e7f8ef;
            color: #198754;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .form-control {
            min-height: 48px;
            margin-bottom: 18px;
        }

        .otp-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 8px;
            font-weight: bold;
        }

        .btn-verify {
            width: 100%;
            min-height: 48px;
            font-weight: 600;
        }
    </style>


<div class="verify-card">

    <div class="verify-icon">✉</div>

    <h3 class="fw-bold">Verify your email</h3>

    <p class="text-muted mb-4">
        Enter the 6-digit OTP sent to your email address.
    </p>

    <div class="hero-card">
    <h3>Verify your email</h3>
    <p>Enter the 6-digit code sent to your email address.</p>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('seller/register/verify-otp') ?>"
          method="post">
        <?= csrf_field() ?>

        <div class="field">
            <label for="otp">Email OTP</label>
            <input type="text" id="otp" name="otp"
                   placeholder="Enter 6-digit OTP"
                   inputmode="numeric" pattern="[0-9]{6}"
                   maxlength="6" autocomplete="one-time-code" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Verify OTP & Register
        </button>
    </form>

    <form action="<?= site_url('seller/register/resend-otp') ?>"
          method="post" style="margin-top:15px">
        <?= csrf_field() ?>

        <button type="submit" class="btn btn-secondary">
            Resend OTP
        </button>
    </form>
</div>

    <div class="text-center mt-3">
        <a href="<?= site_url('seller/register') ?>">
            Back to registration
        </a>
    </div>

</div>

<script>
document.getElementById('otp').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
});
</script>

