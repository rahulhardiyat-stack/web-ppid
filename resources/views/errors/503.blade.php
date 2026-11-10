<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Dalam Pemeliharaan</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            text-align: center;
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            background-color: #eff6ff;
            color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px auto;
        }
        .icon-wrapper svg {
            width: 40px;
            height: 40px;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }
        p {
            font-size: 0.975rem;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 24px;
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 20px;
            margin-bottom: 24px;
        }
        .footer {
            font-size: 0.85rem;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-wrapper">
            <!-- Icon Obeng & Kunci Pas -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 01-3.586 0 2.548 2.548 0 010-3.586l5.653-4.655m0 0l-3.03 2.496a1.99 1.99 0 01-.766 1.208" />
            </svg>
        </div>
        
        <span class="badge">Pemeliharaan Rutin</span>
        
        <h1>Website Dalam Perbaikan</h1>
        
        <p>
            Saat ini kami sedang melakukan peningkatan kualitas sistem dan pemeliharaan rutin. 
            Website akan segera kembali beroperasi normal. Terima kasih atas kesabaran Anda.
        </p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Nama Aplikasi') }}. All rights reserved.
        </div>
    </div>
</body>
</html>