<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EventOga</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #0a0a0a;
            font-family: Arial, Helvetica, sans-serif;
            color: #ffffff;
        }

        table {
            border-spacing: 0;
        }

        .wrapper {
            width: 100%;
            background: #0a0a0a;
            padding: 30px 12px;
        }

        .main {
            width: 100%;
            max-width: 680px;
            background: #111111;
            margin: 0 auto;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 106, 0, 0.15);
        }

        .hero {
            background:
                radial-gradient(circle at top right, rgba(255, 106, 0, 0.25), transparent 35%),
                radial-gradient(circle at bottom left, rgba(255, 106, 0, 0.15), transparent 30%),
                linear-gradient(135deg, #181818, #050505);
            padding: 60px 42px;
        }

        .logo {
            font-size: 38px;
            font-weight: 900;
            color: #ffffff;
            margin: 0;
        }

        .logo span {
            color: #ff6a00;
        }

        .hero-title {
            font-size: 52px;
            line-height: 1.05;
            font-weight: 900;
            margin: 30px 0 16px;
            color: white;
        }

        .orange {
            color: #ff6a00;
        }

        .hero-text {
            color: #d1d1d1;
            font-size: 18px;
            line-height: 1.8;
            max-width: 480px;
        }

        .body {
            padding: 42px;
        }

        .body p {
            color: #d4d4d4;
            line-height: 1.9;
            font-size: 16px;
        }

        .success-card {
            margin-top: 28px;
            border-radius: 20px;
            background: #181818;
            border: 1px solid rgba(255, 106, 0, 0.18);
            overflow: hidden;
        }

        .success-inner {
            padding: 26px;
        }

        .success-icon {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6a00, #ff8c42);
            color: #fff;
            text-align: center;
            line-height: 68px;
            font-size: 32px;
            font-weight: bold;
        }

        .section-title {
            font-size: 24px;
            font-weight: 800;
            text-align: center;
            margin: 42px 0 22px;
        }

        .feature-grid {
            width: 100%;
        }

        .success-heading {
            margin: 0 0 8px;
            font-size: 24px;
            color: #ffffff;
        }

        .success-text {
            margin: 0;
            color: #d4d4d4;
            line-height: 1.7;
            font-size: 15px;
        }

        .feature-card {
            background: #161616;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 18px;
            padding: 24px;
            text-align: center;
        }

        .feature-icon {
            font-size: 34px;
        }

        .feature-title {
            margin: 14px 0 10px;
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
        }

        .feature-text {
            margin: 0;
            color: #bdbdbd;
            font-size: 14px;
            line-height: 1.7;
        }

        .button-wrap {
            text-align: center;
            margin-top: 36px;
        }

        .button {
            display: inline-block;
            background: #ff6a00;
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 16px;
        }

        .footer {
            padding: 30px 40px;
            background: #0c0c0c;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .footer p {
            color: #8f8f8f;
            font-size: 13px;
            line-height: 1.7;
            margin: 0;
        }

        .footer a {
            color: #ff6a00;
            text-decoration: none;
            font-weight: bold;
        }

        @media screen and (max-width:640px) {

            .success-icon-cell,
            .success-text-cell {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
            }

            .success-icon {
                margin: 0 auto 16px !important;
            }

            .success-heading {
                text-align: center !important;
                font-size: 22px !important;
            }

            .success-text {
                text-align: center !important;
                font-size: 14px !important;
                line-height: 1.7 !important;
            }

            .feature-card {
                text-align: center !important;
                max-width: 280px !important;
                margin: 0 auto 14px !important;
                padding: 20px !important;
            }

            .feature-title {
                margin: 10px 0 6px !important;
            }

            .feature-text {
                max-width: 180px !important;
                margin: 0 auto !important;
            }

            .hero {
                padding: 42px 24px;
            }

            .body {
                padding: 30px 22px;
            }

            .hero-title {
                font-size: 38px !important;
                color: white;
            }

            .hero-text {
                font-size: 16px !important;
            }

            .stack-column {
                display: block !important;
                width: 100% !important;
                padding-bottom: 16px !important;
            }

            .footer {
                padding: 24px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <table class="main" cellpadding="0" cellspacing="0">

            <!-- HERO -->
            <tr>
                <td class="hero">

                    <img src="https://api.sharebutter.com/eventoga.png" alt="EventOga Logo" width="180"
                        style="display:block; border:0; max-width:180px; height:auto;">

                    <h2 class="hero-title">
                        Welcome to the Future of <span class="orange">Events</span>
                    </h2>

                    <p class="hero-text">
                        Discover experiences, book unforgettable moments,
                        and organize amazing events across Nigeria.
                    </p>

                </td>
            </tr>

            <!-- BODY -->
            <tr>
                <td class="body">

                    <p>
                        Hi <strong>{{ ucwords(strtolower($user->name)) }}</strong>,
                    </p>

                    <p>
                        Thank you for joining <strong>EventOga</strong>.
                        Your account has been created successfully and you're now part of a growing event community.
                    </p>

                    <!-- SUCCESS -->
                    <div class="success-card">
                        <div class="success-inner">

                            <table width="100%" class="success-table">
                                <tr>
                                    <td class="success-icon-cell" width="80" valign="top" align="center">
                                        <div class="success-icon">
                                            ✓
                                        </div>
                                    </td>

                                    <td class="success-text-cell" valign="top">
                                        <h3 class="success-heading">
                                            You're all set!
                                        </h3>

                                        <p class="success-text">
                                            Start exploring events and booking memorable experiences today.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>



                    <!-- FEATURES -->
                    <h3 class="section-title">
                        What You Can Do Next
                    </h3>

                    <table width="100%" class="feature-grid">
                        <tr>

                            <td class="stack-column" width="33.3%" style="padding:8px;">
                                <div class="feature-card">
                                    <div class="feature-icon">🎟️</div>
                                    <h4 class="feature-title">Discover Events</h4>
                                    <p class="feature-text">
                                        Explore concerts, conferences,
                                        parties and experiences near you.
                                    </p>
                                </div>
                            </td>

                            <td class="stack-column" width="33.3%" style="padding:8px;">
                                <div class="feature-card">
                                    <div class="feature-icon">📅</div>
                                    <h4 class="feature-title">Book & Attend</h4>
                                    <p class="feature-text">
                                        Reserve your seat and enjoy smooth,
                                        secure ticket access.
                                    </p>
                                </div>
                            </td>

                            <td class="stack-column" width="33.3%" style="padding:8px;">
                                <div class="feature-card">
                                    <div class="feature-icon">🚀</div>
                                    <h4 class="feature-title">Organize Events</h4>
                                    <p class="feature-text">
                                        Create, promote and monetize your
                                        own events with ease.
                                    </p>
                                </div>
                            </td>

                        </tr>
                    </table>

                    <!-- CTA -->
                    <div class="button-wrap">
                        <a href="https://eventoga.netlify.app/dashboard" class="button">
                            Explore EventOga
                        </a>
                    </div>

                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td class="footer">

                    <p>
                        Need help?
                        <a href="mailto:support@eventoga.com">
                            support@eventoga.sharebutter.com
                        </a>
                    </p>

                    <p style="margin-top:10px;">
                        © {{ date('Y') }} EventOga. All rights reserved.
                    </p>

                </td>
            </tr>

        </table>

    </div>

</body>

</html>
