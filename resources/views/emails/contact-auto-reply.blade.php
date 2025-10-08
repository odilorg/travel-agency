<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="margin: 0; color: white; font-size: 24px;">{{ config('app.name') }}</h1>
    </div>

    <div style="background: white; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px;">
        <p style="margin: 0 0 15px 0; font-size: 16px;">{{ __('Hello') }} {{ $customerName }},</p>
        
        <div style="background: #f9fafb; padding: 20px; border-left: 4px solid #10b981; margin: 20px 0;">
            {!! nl2br(e($body)) !!}
        </div>

        <p style="margin: 20px 0 0 0; color: #6b7280;">
            {{ __('Best regards,') }}<br>
            <strong>{{ config('app.name') }} {{ __('Team') }}</strong>
        </p>
    </div>

    <div style="margin-top: 30px; text-align: center; color: #9ca3af; font-size: 12px;">
        <p style="margin: 0;">{{ __('This is an automated message. Please do not reply to this email.') }}</p>
        <p style="margin: 10px 0 0 0;">© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
    </div>
</body>
</html>

