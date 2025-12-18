<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập nhanh - Vietlance</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">Vietlance</h1>
    </div>
    
    <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px;">
        <h2 style="color: #333; margin-top: 0;">
            {{ $userType === 'freelance' ? 'Đăng nhập Freelance' : 'Đăng nhập Client' }}
        </h2>
        
        <p>Xin chào,</p>
        
        <p>Bạn đã yêu cầu đăng nhập nhanh vào hệ thống Vietlance. Click vào nút bên dưới để đăng nhập:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $loginUrl }}" 
               style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                      color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; 
                      font-weight: bold; font-size: 16px;">
                Đăng nhập ngay
            </a>
        </div>
        
        <p style="color: #666; font-size: 14px;">
            Hoặc copy và paste link này vào trình duyệt:<br>
            <a href="{{ $loginUrl }}" style="color: #667eea; word-break: break-all;">{{ $loginUrl }}</a>
        </p>
        
        <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; color: #856404; font-size: 14px;">
                <strong>⚠️ Lưu ý:</strong> Link này chỉ có hiệu lực trong 15 phút và chỉ sử dụng được 1 lần. 
                Nếu bạn không yêu cầu đăng nhập, vui lòng bỏ qua email này.
            </p>
        </div>
        
        <p style="color: #666; font-size: 12px; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px;">
            Email này được gửi tự động từ hệ thống Vietlance. Vui lòng không trả lời email này.
        </p>
    </div>
</body>
</html>

