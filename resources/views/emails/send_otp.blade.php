<!DOCTYPE html>
<html>
<head>
    <title>Reset Password BookNStay</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body style="font-family: 'Poppins', sans-serif; margin: 0; padding: 20px; background-color: #f7fafc;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 28px; margin: 0;">
                <span style="color: #3b82f6;">Book</span>
                <span style="color: #f59e0b;">N</span>
                <span style="color: #3b82f6;">Stay</span>
            </h1>
            <p style="color: #718096; margin-top: 8px;">Your Trusted Booking Partner</p>
        </div>

        <!-- Content -->
        <div style="border-top: 2px solid #e2e8f0; padding-top: 25px;">
            <p style="color: #1a202c; font-size: 16px; margin-bottom: 15px;">Halo Pelanggan Terhormat,</p>
            <p style="color: #4a5568; line-height: 1.6;">Anda menerima email ini karena meminta reset password untuk akun BookNStay Anda. Gunakan kode OTP berikut:</p>

            <!-- OTP Box -->
            <div style="background: #f8fafc; border: 2px dashed #cbd5e0; border-radius: 8px; padding: 20px; text-align: center; margin: 25px 0;">
                <div style="font-size: 32px; letter-spacing: 4px; font-weight: 600; color: #1e40af;">
                    {{ $otp }}
                </div>
                <div style="color: #718096; font-size: 14px; margin-top: 10px;">
                    Berlaku hingga 5 menit
                </div>
            </div>

            <!-- Warning -->
            <div style="background: #fff5f5; border-left: 4px solid #fed7d7; padding: 16px; border-radius: 6px;">
                <p style="color: #e53e3e; margin: 0; font-size: 14px;">
                    ⚠️ Jika Anda tidak melakukan permintaan ini,
                    harap abaikan email ini dan periksa keamanan akun Anda.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="border-top: 2px solid #e2e8f0; margin-top: 35px; padding-top: 20px; text-align: center;">
            <p style="color: #718096; font-size: 12px; margin: 8px 0;">
                Jangan membagikan kode ini ke siapapun termasuk pihak BookNStay
            </p>
            <p style="color: #718096; font-size: 12px; margin: 5px 0;">
                © 2024 BookNStay. All rights reserved<br>
                Jl. Contoh No. 123, Jakarta Selatan<br>
                Email: support@booknstay.id | Telp: (021) 1234-5678
            </p>
            <div style="margin-top: 15px;">
                <a href="#" style="margin: 0 8px; text-decoration: none;">
                    <img src="https://via.placeholder.com/24" alt="Facebook" style="width: 24px; height: 24px;">
                </a>
                <a href="https://x.com/byann_fekk" target="_blank" rel="noopener noreferrer" style="margin: 0 8px; text-decoration: none;">
                    <img src="https://via.placeholder.com/24" alt="X" style="width: 24px; height: 24px;">
                </a>
                <a href="https://www.instagram.com/fabyannprtm/" target="_blank" rel="noopener noreferrer" style="margin: 0 8px; text-decoration: none;">
                    <img src="https://via.placeholder.com/24" alt="Instagram" style="width: 24px; height: 24px;">
                </a>
            </div>
        </div>
    </div>
</body>
</html>
