<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title . ' - SMA Negeri Contoh' : 'SMA Negeri Contoh'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-wrapper {
            width: 100%;
            max-width: 400px;
        }
        
        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .auth-header {
            background: #4f46e5;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .auth-icon {
            font-size: 40px;
            margin-bottom: 15px;
            opacity: 0.9;
        }
        
        .auth-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .auth-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .auth-body {
            padding: 30px;
        }
        
        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .input-group .form-control {
            border-right: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        
        .input-group-text {
            background: white;
            border: 1.5px solid #d1d5db;
            border-left: 0;
            border-radius: 0 8px 8px 0;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s;
            padding: 0 16px;
        }
        
        .input-group-text:hover {
            background: #f9fafb;
            color: #4f46e5;
        }
        
        .btn-primary-custom {
            background: #4f46e5;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            padding: 14px;
            width: 100%;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-primary-custom:active {
            transform: translateY(0);
        }
        
        .btn-outline-secondary {
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-outline-secondary:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .auth-footer {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .back-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #4b5563;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .alert-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .alert-info {
            background: #e0f2fe;
            color: #0369a1;
        }
        
        .otp-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 8px;
            font-weight: 600;
        }
        
        .timer {
            color: #4f46e5;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .auth-body {
                padding: 25px 20px;
            }
            
            .auth-header {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>