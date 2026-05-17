<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to EventOga</title>
</head>
<body style="margin:0; padding:0; background:#f5f0ff; font-family:Arial, Helvetica, sans-serif; color:#1f1235;">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:32px 12px;">
    <tr>
      <td align="center">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:680px; background:#ffffff; border-radius:18px; overflow:hidden;">

          <!-- Logo -->
          <tr>
            <td align="center" style="padding:32px 20px;">
              <h1 style="margin:0; font-size:34px; font-weight:900; color:#5b21b6;">
                Event<span style="color:#ff6a00;">Oga</span>
              </h1>
            </td>
          </tr>

          <!-- Hero -->
          <tr>
            <td style="background:linear-gradient(135deg,#3b0b78,#220042); padding:48px 40px; color:#ffffff;">
              <h2 style="margin:0; font-size:42px; line-height:1.1; font-weight:900;">
                Welcome to <br>
                <span style="color:#ff6a00;">Event</span>Oga!
              </h2>
              <p style="margin:20px 0 0; font-size:18px; line-height:1.7; max-width:460px;">
                Your go-to platform for discovering amazing events and unforgettable experiences.
              </p>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:40px;">
              <p style="font-size:18px; line-height:1.7; margin:0 0 18px;">
                Hi <strong>{{ $user->name }}</strong>,
              </p>

              <p style="font-size:17px; line-height:1.8; margin:0 0 24px;">
                Thank you for joining <strong>EventOga</strong>! We’re excited to have you on board.
                Whether you’re here to attend, organize, or explore, we’re here to make every event experience exceptional.
              </p>

              <!-- Success Card -->
              <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3e8ff; border-radius:16px; margin:28px 0;">
                <tr>
                  <td style="padding:24px;">
                    <table cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="72" valign="top">
                          <div style="height:64px; width:64px; border-radius:50%; background:linear-gradient(135deg,#6d28d9,#ff6a00); color:#fff; text-align:center; line-height:64px; font-size:30px;">
                            ✓
                          </div>
                        </td>
                        <td style="padding-left:18px;">
                          <h3 style="margin:0; font-size:22px;">You’re all set!</h3>
                          <p style="margin:8px 0 0; font-size:16px; line-height:1.7;">
                            Your account has been created successfully. Start exploring events, book tickets, and create memories that last.
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Next steps -->
              <h3 style="text-align:center; margin:36px 0 22px; font-size:20px;">
                What you can do next
              </h3>

              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="33.3%" align="center" style="padding:10px;">
                    <div style="font-size:30px;">🎟️</div>
                    <h4 style="margin:12px 0 6px;">Discover Events</h4>
                    <p style="font-size:14px; line-height:1.5; margin:0;">Find events that match your passion.</p>
                  </td>

                  <td width="33.3%" align="center" style="padding:10px;">
                    <div style="font-size:30px;">📅</div>
                    <h4 style="margin:12px 0 6px;">Book & Attend</h4>
                    <p style="font-size:14px; line-height:1.5; margin:0;">Secure your spot and enjoy seamless entry.</p>
                  </td>

                  <td width="33.3%" align="center" style="padding:10px;">
                    <div style="font-size:30px;">🚀</div>
                    <h4 style="margin:12px 0 6px;">Organize Events</h4>
                    <p style="font-size:14px; line-height:1.5; margin:0;">Create and manage events with ease.</p>
                  </td>
                </tr>
              </table>

              <!-- CTA -->
              <div style="text-align:center; margin-top:34px;">
                <a href="{{ url('/') }}" style="display:inline-block; background:#6d28d9; color:#ffffff; text-decoration:none; padding:15px 42px; border-radius:8px; font-weight:800; font-size:16px;">
                  Explore Events
                </a>
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#f3e8ff; padding:28px 40px; text-align:center;">
              <p style="margin:0 0 10px; font-size:14px;">
                Questions? We’re here to help.
                <a href="mailto:support@eventoga.com" style="color:#6d28d9; font-weight:bold;">support@eventoga.com</a>
              </p>

              <p style="margin:0; font-size:13px; color:#6b5b80;">
                © {{ date('Y') }} EventOga. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
