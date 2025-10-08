<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('New Contact Form Submission') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #f8f9fa; border-left: 4px solid #10b981; padding: 20px; margin-bottom: 20px;">
        <h2 style="margin: 0 0 10px 0; color: #1f2937;">{{ __('New Contact Form Submission') }}</h2>
        <p style="margin: 0; color: #6b7280;">{{ __('You have received a new message from your website contact form.') }}</p>
    </div>

    <div style="background: white; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    <strong>{{ __('Name:') }}</strong>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    {{ $data['name'] }}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    <strong>{{ __('Email:') }}</strong>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    <a href="mailto:{{ $data['email'] }}" style="color: #10b981; text-decoration: none;">{{ $data['email'] }}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    <strong>{{ __('Submitted:') }}</strong>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    {{ now()->format('F j, Y \a\t g:i A') }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 20px;">
            <strong style="display: block; margin-bottom: 10px;">{{ __('Message:') }}</strong>
            <div style="background: #f9fafb; padding: 15px; border-radius: 6px; white-space: pre-wrap; word-wrap: break-word;">{{ $data['message'] }}</div>
        </div>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280; font-size: 14px;">
        <p style="margin: 0;">{{ __('This email was automatically generated from') }} <strong>{{ config('app.name') }}</strong></p>
        <p style="margin: 10px 0 0 0;">{{ __('Sent from IP:') }} {{ request()->ip() ?? 'N/A' }}</p>
    </div>
</body>
</html>

