<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sell on Ajobmart – Seller Home</title>
<link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet"
    >

    <style>
    .aj-seller-login-page {
        min-height: 85vh;
        padding: 55px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f2f6ff, #f8faff);
    }

    .aj-seller-login-card {
        width: 100%;
        max-width: 1050px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 15px 55px rgba(25, 45, 90, .10);
    }

    .aj-seller-login-info {
        padding: 55px 45px;
        color: #fff;
        background: linear-gradient(145deg, #1746a2, #2869dc);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .aj-seller-login-brand {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 30px;
        letter-spacing: -.5px;
    }

    .aj-seller-login-brand span {
        color: #ffcf5c;
    }

    .aj-seller-login-info h1 {
        font-size: 34px;
        line-height: 1.25;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .aj-seller-login-info > p {
        color: #e2ebff;
        line-height: 1.8;
    }

    .aj-seller-login-benefits {
        list-style: none;
        padding: 0;
        margin: 28px 0 0;
    }

    .aj-seller-login-benefits li {
        margin-bottom: 17px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        color: #fff;
    }

    .aj-seller-login-check {
        width: 25px;
        height: 25px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        color: #1746a2;
        background: #ffcf5c;
        border-radius: 50%;
        font-weight: 800;
    }

    .aj-seller-login-form-area {
        padding: 55px 45px;
    }

    .aj-seller-login-form-area h2 {
        color: #17233c;
        font-size: 29px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .aj-seller-login-subtitle {
        color: #778198;
        margin-bottom: 30px;
    }

    .aj-seller-login-label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #34405a;
        margin-bottom: 8px;
    }

    .aj-seller-login-input-wrap {
        position: relative;
    }

    .aj-seller-login-input {
        width: 100%;
        min-height: 51px;
        padding: 12px 15px;
        border: 1px solid #dce2ed;
        border-radius: 10px;
        outline: none;
        background: #fff;
        transition: .2s;
    }

    .aj-seller-login-input:focus {
        border-color: #2869dc;
        box-shadow: 0 0 0 3px rgba(40, 105, 220, .10);
    }

    .aj-seller-login-password {
        padding-right: 48px;
    }

    .aj-seller-login-toggle {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #65718a;
        cursor: pointer;
    }

    .aj-seller-login-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 18px 0 24px;
        font-size: 13px;
    }

    .aj-seller-login-options a,
    .aj-seller-login-footer a {
        color: #245dcc;
        font-weight: 700;
        text-decoration: none;
    }

    .aj-seller-login-submit {
        width: 100%;
        min-height: 51px;
        border: 0;
        border-radius: 10px;
        background: #245dcc;
        color: #fff;
        font-weight: 700;
        transition: .2s;
    }

    .aj-seller-login-submit:hover {
        background: #1746a2;
    }

    .aj-seller-login-footer {
        text-align: center;
        margin-top: 25px;
        font-size: 14px;
        color: #778198;
    }

    .aj-seller-login-security {
        margin-top: 24px;
        text-align: center;
        color: #8992a5;
        font-size: 12px;
    }

    @media (max-width: 767px) {
        .aj-seller-login-page {
            padding: 25px 12px;
        }

        .aj-seller-login-card {
            grid-template-columns: 1fr;
            border-radius: 16px;
        }

        .aj-seller-login-info {
            padding: 30px 25px;
        }

        .aj-seller-login-info h1 {
            font-size: 27px;
        }

        .aj-seller-login-brand {
            margin-bottom: 18px;
        }

        .aj-seller-login-benefits {
            margin-top: 18px;
        }

        .aj-seller-login-form-area {
            padding: 35px 25px;
        }
    }
</style>

</head>
<body>


<div>
<?= $content ?>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput =
        document.getElementById('sellerLoginPassword');

    const toggleButton =
        document.getElementById('ajSellerTogglePassword');

    if (passwordInput && toggleButton) {
        toggleButton.addEventListener('click', function () {

            const isPassword =
                passwordInput.type === 'password';

            passwordInput.type =
                isPassword ? 'text' : 'password';

            toggleButton.innerHTML = isPassword
                ? '<i class="fa-regular fa-eye-slash"></i>'
                : '<i class="fa-regular fa-eye"></i>';

            toggleButton.setAttribute(
                'aria-label',
                isPassword ? 'Hide password' : 'Show password'
            );
        });
    }

    const loginForm =
        document.getElementById('ajSellerLoginForm');

    const loginButton =
        document.getElementById('ajSellerLoginButton');

    if (loginForm && loginButton) {
        loginForm.addEventListener('submit', function () {
            if (loginForm.checkValidity()) {
                loginButton.disabled = true;
                loginButton.textContent = 'Signing in...';
            }
        });
    }

});
</script>

</body>
</html>