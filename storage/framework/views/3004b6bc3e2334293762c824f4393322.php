<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bacakuy - Loading</title>
    <style>
        body {
            min-height: 100vh;
            margin:0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            font-family: 'Inter', sans-serif;
        }
        .loader-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .loader-text {
            display: flex;
            align-items: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #212529;
            letter-spacing: 2px;
        }
        .icon-inline {
            display: inline-flex;
            margin-right: 18px;
            width: 50px;
            height: 150px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
        .dot {
            animation: blink 1s infinite;
            opacity:0.7;
        }
        @keyframes blink {
            0%,100% { opacity:0.2; }
            50%     { opacity:1; }
        }
    </style>
    <script>
        // Simple redirect - langsung check session
        function checkAuth() {
            // Coba akses dashboard, jika redirect ke login berarti belum auth
            window.location.href = '/dashboard';
        }

        // Redirect setelah 1.5 detik
        setTimeout(checkAuth, 2000);
    </script>
</head>
<body>
    <div class="loader-box">
        <div class="loader-text">
            <span class="icon-inline">
                <img src="<?php echo e(asset('Image/buku.png')); ?>" alt="Logo Buku" width="36" height="36">
            </span>
            Blogger<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\welcome.blade.php ENDPATH**/ ?>