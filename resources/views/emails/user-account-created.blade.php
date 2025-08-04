<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $appName }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #042E60 0%, #E0498A 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }
        
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 0;
        }
        
        .content {
            padding: 40px 30px;
            background-color: #ffffff;
        }
        
        .greeting {
            font-size: 24px;
            color: #042E60;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .message {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .credentials-container {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px solid #E0498A;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .credentials-title {
            color: #042E60;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .credential-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px 15px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .credential-label {
            font-weight: 600;
            color: #042E60;
            font-size: 14px;
        }
        
        .credential-value {
            font-family: 'Courier New', monospace;
            color: #2d3748;
            font-size: 14px;
            background-color: #f7fafc;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #cbd5e0;
        }
        
        .password-value {
            background-color: #fff5f5;
            border-color: #E0498A;
            color: #E0498A;
            font-weight: bold;
        }
        
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #042E60 0%, #E0498A 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(224, 73, 138, 0.3);
        }
        
        .security-notice {
            background-color: #fff8e1;
            border-left: 4px solid #ffa726;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .security-title {
            color: #e65100;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .security-icon {
            width: 18px;
            height: 18px;
            margin-right: 8px;
        }
        
        .security-text {
            color: #ef6c00;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }
        
        .user-info {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .user-info-title {
            color: #042E60;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .user-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .user-detail-label {
            color: #64748b;
            font-weight: 500;
        }
        
        .user-detail-value {
            color: #1e293b;
            font-weight: 600;
        }
        
        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .role-admin {
            background-color: #e9d5ff;
            color: #7c3aed;
        }
        
        .role-manager {
            background-color: #dbeafe;
            color: #2563eb;
        }
        
        .role-hr {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .role-user {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        .footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-text {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .footer-links {
            margin-bottom: 20px;
        }
        
        .footer-link {
            color: #E0498A;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .company-info {
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.5;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .credential-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .credential-value {
                margin-top: 5px;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <p class="header-subtitle">Employee Management System</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="greeting">Welcome, {{ $user->name }}!</h1>
            
            <p class="message">
                Your account has been successfully created in our system. You can now access the employee management portal with the credentials provided below.
            </p>

            <!-- User Information -->
            <div class="user-info">
                <div class="user-info-title">Account Information</div>
                <div class="user-detail">
                    <span class="user-detail-label">Full Name:</span>
                    <span class="user-detail-value">{{ $user->name }}</span>
                </div>
                <div class="user-detail">
                    <span class="user-detail-label">Email Address:</span>
                    <span class="user-detail-value">{{ $user->email }}</span>
                </div>
                @if($user->employee_id)
                <div class="user-detail">
                    <span class="user-detail-label">Employee ID:</span>
                    <span class="user-detail-value">{{ $user->employee_id }}</span>
                </div>
                @endif
                @if($user->department)
                <div class="user-detail">
                    <span class="user-detail-label">Department:</span>
                    <span class="user-detail-value">{{ $user->department->name }}</span>
                </div>
                @endif
                @if($user->position)
                <div class="user-detail">
                    <span class="user-detail-label">Position:</span>
                    <span class="user-detail-value">{{ $user->position }}</span>
                </div>
                @endif
                <div class="user-detail">
                    <span class="user-detail-label">Role:</span>
                    <span class="user-detail-value">
                        <span class="role-badge role-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </span>
                </div>
            </div>

            <!-- Login Credentials -->
            <div class="credentials-container">
                <div class="credentials-title">Your Login Credentials</div>
                
                <div class="credential-row">
                    <span class="credential-label">Email:</span>
                    <span class="credential-value">{{ $user->email }}</span>
                </div>
                
                <div class="credential-row">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value password-value">{{ $password }}</span>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <div class="security-title">
                    <svg class="security-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Important Security Information
                </div>
                <p class="security-text">
                    <strong>Please change your password immediately after your first login.</strong> 
                    This temporary password should not be shared with anyone. For security reasons, 
                    you will be required to verify your email and set up two-factor authentication 
                    on your first login.
                </p>
            </div>

            <!-- Login Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $loginUrl }}" class="login-button">
                    Sign In to Your Account
                </a>
            </div>

            <div class="divider"></div>

            <p class="message">
                If you have any questions or need assistance, please don't hesitate to contact our support team at 
                <a href="mailto:{{ $supportEmail }}" style="color: #E0498A; text-decoration: none; font-weight: 600;">{{ $supportEmail }}</a>.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                This email was sent automatically. Please do not reply to this email.
            </p>
            
            <div class="footer-links">
                <a href="{{ $appUrl }}" class="footer-link">Visit Portal</a>
                <a href="mailto:{{ $supportEmail }}" class="footer-link">Support</a>
                <a href="{{ $appUrl }}/privacy" class="footer-link">Privacy Policy</a>
            </div>
            
            <div class="company-info">
                <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
                <p>This is an automated message from our employee management system.</p>
            </div>
        </div>
    </div>
</body>
</html>