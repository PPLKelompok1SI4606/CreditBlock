<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New KYC Verification Request</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f7fa; color: #333;">
    <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td style="background-color: #007bff; padding: 20px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <h1 style="color: #ffffff; margin: 0; font-size: 30px; font-weight: bold;">CreditBlock</h1>
                <p style="color: #e6f0ff; margin: 5px 0 0; font-size: 14px;">New KYC Verification Request</p>
            </td>
        </tr>
        <!-- Content -->
        <tr>
            <td style="padding: 30px;">
                <h2 style="font-size: 20px; color: #333; margin: 0 0 15px;">Hello Admin,</h2>
                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">A new KYC verification request has been submitted. Please review the details below and verify the user.</p>

                <h3 style="font-size: 18px; color: #333; margin: 20px 0 10px;">User Details</h3>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 16px; line-height: 1.5;">
                    <tr>
                        <td style="padding: 8px 0; color: #555;"><strong>Name:</strong></td>
                        <td style="padding: 8px 0; color: #333;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #555;"><strong>Email:</strong></td>
                        <td style="padding: 8px 0; color: #333;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #555;"><strong>ID Type:</strong></td>
                        <td style="padding: 8px 0; color: #333;">{{ ucfirst($user->id_type) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #555;"><strong>Submission Date:</strong></td>
                        <td style="padding: 8px 0; color: #333;">{{ $user->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>

                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ route('admin.dashboard') }}" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; border-radius: 5px; transition: background-color 0.3s;">
                        Review KYC Documents
                    </a>
                </p>
            </td>
        </tr>
        <!-- Footer -->
        <tr>
            <td style="background-color: #f8f9fa; padding: 20px; text-align: center; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                <p style="font-size: 14px; color: #666; margin: 0;">This email was sent by {{ $user->name }} ({{ $user->email }}).</p>
                <p style="font-size: 14px; color: #666; margin: 10px 0 0;">&copy; {{ date('Y') }} CreditBlock. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
