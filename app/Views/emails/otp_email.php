<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Ajobmart OTP Verification</title>

</head>


<body style="
    margin:0;
    padding:0;
    background:#f5f7fb;
    font-family:Arial,Helvetica,sans-serif;
">


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="padding:40px 15px;"
>

    <tr>

        <td align="center">


            <table
                width="500"
                cellpadding="0"
                cellspacing="0"
                style="
                    max-width:500px;
                    width:100%;
                    background:#ffffff;
                    border-radius:16px;
                    padding:35px;
                "
            >

                <!-- LOGO -->

                <tr>

                    <td align="center">

                        <h1 style="
                            margin:0;
                            color:#2878f0;
                            font-size:30px;
                        ">
                            Ajobmart
                        </h1>


                        <?php if ($userType === 'seller'): ?>

                            <p style="
                                margin:8px 0 0;
                                color:#777;
                                font-size:13px;
                            ">
                                Seller Account
                            </p>

                        <?php else: ?>

                            <p style="
                                margin:8px 0 0;
                                color:#777;
                                font-size:13px;
                            ">
                                Customer Account
                            </p>

                        <?php endif; ?>

                    </td>

                </tr>


                <!-- CONTENT -->

                <tr>

                    <td>

                        <p style="
                            margin-top:30px;
                            color:#333;
                            font-size:15px;
                        ">

                            Hello,

                        </p>


                        <p style="
                            color:#555;
                            font-size:14px;
                            line-height:1.6;
                        ">

                            <?php if ($purpose === 'registration'): ?>

                                Use the following OTP to verify your
                                email address and continue creating
                                your Ajobmart account.

                            <?php elseif ($purpose === 'login'): ?>

                                Use the following OTP to securely
                                login to your Ajobmart account.

                            <?php elseif ($purpose === 'forgot_password'): ?>

                                Use the following OTP to reset your
                                Ajobmart account password.

                            <?php endif; ?>

                        </p>


                        <!-- OTP -->

                        <div style="
                            margin:30px 0;
                            padding:20px;
                            background:#f1f5ff;
                            border-radius:12px;
                            text-align:center;
                        ">

                            <span style="
                                font-size:32px;
                                font-weight:bold;
                                letter-spacing:8px;
                                color:#2878f0;
                            ">

                                <?= esc($otp) ?>

                            </span>

                        </div>


                        <p style="
                            text-align:center;
                            color:#888;
                            font-size:13px;
                        ">

                            This OTP is valid for
                            <strong>10 minutes</strong>.

                        </p>


                        <p style="
                            margin-top:30px;
                            color:#999;
                            font-size:12px;
                            line-height:1.6;
                        ">

                            If you did not request this OTP,
                            please ignore this email.

                        </p>

                    </td>

                </tr>


                <!-- FOOTER -->

                <tr>

                    <td>

                        <hr style="
                            border:none;
                            border-top:1px solid #eee;
                            margin:25px 0;
                        ">


                        <p style="
                            margin:0;
                            text-align:center;
                            color:#aaa;
                            font-size:11px;
                        ">

                            © <?= date('Y') ?> Ajobmart.
                            All rights reserved.

                        </p>

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>


</body>

</html>