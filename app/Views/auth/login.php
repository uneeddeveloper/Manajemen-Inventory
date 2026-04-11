<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Manajemen Inventori</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .inp {
            width: 100%; border: 1.5px solid #e5e7eb; border-radius: 10px;
            padding: 10px 14px; font-size: 13.5px; color: #1f2937;
            outline: none; transition: border .15s, box-shadow .15s;
            background: #fff; font-family: 'Inter', sans-serif;
        }
        .inp:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-800 flex items-center justify-center p-4">

<div class="w-full max-w-sm">

    <!-- Logo -->
    <div class="flex flex-col items-center mb-8">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 shadow-lg"
             style="background: linear-gradient(135deg,#6366f1,#8b5cf6)">
            <i class="fas fa-boxes-stacked text-white text-2xl"></i>
        </div>
        <h1 class="text-white text-xl font-bold">Toko Bangunan</h1>
        <p class="text-slate-400 text-sm mt-1">Manajemen Inventori</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8">

        <h2 class="text-slate-800 text-lg font-bold mb-1">Selamat datang</h2>
        <p class="text-slate-500 text-sm mb-6">Masukkan kredensial Anda untuk melanjutkan.</p>

        <!-- Error -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="flex items-center gap-2 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm mb-5">
            <i class="fas fa-circle-exclamation flex-shrink-0"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-1.5">Username</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="username" value="<?= old('username') ?>"
                           class="inp pl-9" placeholder="Masukkan username" autocomplete="username" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password"
                           class="inp pl-9 pr-10" placeholder="Masukkan password" autocomplete="current-password" required>
                    <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition text-sm">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[.98] text-white font-semibold py-2.5 rounded-xl transition text-sm">
                <i class="fas fa-right-to-bracket mr-2"></i>Masuk
            </button>
        </form>
    </div>

    <p class="text-center text-slate-500 text-xs mt-6">
        &copy; <?= date('Y') ?> Toko Bangunan. All rights reserved.
    </p>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
