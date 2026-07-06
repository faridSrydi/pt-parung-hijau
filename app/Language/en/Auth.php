<?php

declare(strict_types=1);

return [
    // Exceptions
    'unknownAuthenticator'  => '{0} bukan metode autentikasi yang valid.',
    'unknownUserProvider'   => 'Tidak dapat menentukan User Provider yang akan digunakan.',
    'invalidUser'           => 'Tidak dapat menemukan pengguna yang ditentukan.',
    'bannedUser'            => 'Anda tidak dapat masuk karena akun Anda sedang ditangguhkan.',
    'logOutBannedUser'      => 'Anda telah dikeluarkan karena akun Anda ditangguhkan.',
    'badAttempt'            => 'Gagal masuk. Silakan periksa kembali email dan kata sandi Anda.',
    'noPassword'            => 'Tidak dapat memvalidasi pengguna tanpa kata sandi.',
    'invalidPassword'       => 'Gagal masuk. Kata sandi yang Anda masukkan salah.',
    'noToken'               => 'Setiap permintaan harus memiliki bearer token di header {0}.',
    'badToken'              => 'Token akses tidak valid.',
    'oldToken'              => 'Token akses telah kedaluwarsa.',
    'noUserEntity'          => 'User Entity harus disediakan untuk validasi kata sandi.',
    'invalidEmail'          => 'Tidak dapat memverifikasi karena alamat email "{0}" tidak cocok dengan data kami.',
    'unableSendEmailToUser' => 'Maaf, terjadi masalah saat mengirim email ke "{0}".',
    'throttled'             => 'Terlalu banyak percobaan masuk dari alamat IP ini. Silakan coba lagi dalam {0} detik.',
    'notEnoughPrivilege'    => 'Anda tidak memiliki izin yang diperlukan untuk melakukan operasi ini.',
    // JWT Exceptions
    'invalidJWT'     => 'Token tidak valid.',
    'expiredJWT'     => 'Token telah kedaluwarsa.',
    'beforeValidJWT' => 'Token belum tersedia untuk digunakan.',

    'email'           => 'Alamat Email',
    'username'        => 'Username',
    'password'        => 'Kata Sandi',
    'passwordConfirm' => 'Konfirmasi Kata Sandi',
    'haveAccount'     => 'Sudah memiliki akun?',
    'token'           => 'Token',

    // Buttons
    'confirm' => 'Konfirmasi',
    'send'    => 'Kirim',

    // Registration
    'register'         => 'Daftar',
    'registerDisabled' => 'Pendaftaran akun baru saat ini tidak diaktifkan.',
    'registerSuccess'  => 'Pendaftaran berhasil! Selamat bergabung.',

    // Login
    'login'              => 'Masuk',
    'needAccount'        => 'Belum punya akun?',
    'rememberMe'         => 'Ingat saya',
    'forgotPassword'     => 'Lupa kata sandi Anda?',
    'useMagicLink'       => 'Gunakan Tautan Masuk',
    'magicLinkSubject'   => 'Tautan Masuk Anda',
    'magicTokenNotFound' => 'Tidak dapat memverifikasi tautan.',
    'magicLinkExpired'   => 'Maaf, tautan masuk telah kedaluwarsa.',
    'checkYourEmail'     => 'Periksa email Anda!',
    'magicLinkDetails'   => 'Kami baru saja mengirimkan email yang berisi Tautan Masuk. Tautan ini hanya berlaku selama {0} menit.',
    'magicLinkDisabled'  => 'Penggunaan MagicLink saat ini tidak diizinkan.',
    'successLogout'      => 'Anda telah berhasil keluar dari sistem.',
    'backToLogin'        => 'Kembali ke Halaman Masuk',

    // Passwords
    'errorPasswordLength'       => 'Kata sandi minimal harus terdiri dari {0, number} karakter.',
    'suggestPasswordLength'     => 'Frasa sandi - hingga 255 karakter - membuat kata sandi lebih aman dan mudah diingat.',
    'errorPasswordCommon'       => 'Kata sandi tidak boleh berupa kata sandi yang umum digunakan.',
    'suggestPasswordCommon'     => 'Kata sandi diperiksa terhadap lebih dari 65 ribu kata sandi umum atau yang bocor akibat peretasan.',
    'errorPasswordPersonal'     => 'Kata sandi tidak boleh mengandung informasi pribadi.',
    'suggestPasswordPersonal'   => 'Variasi dari alamat email atau username sebaiknya tidak digunakan sebagai kata sandi.',
    'errorPasswordTooSimilar'   => 'Kata sandi terlalu mirip dengan username Anda.',
    'suggestPasswordTooSimilar' => 'Jangan gunakan bagian dari username Anda di dalam kata sandi.',
    'errorPasswordPwned'        => 'Kata sandi {0} telah terekspos akibat kebocoran data dan telah terlihat {1, number} kali dalam {2} kata sandi yang disusupi.',
    'suggestPasswordPwned'      => '{0} sebaiknya tidak digunakan sebagai kata sandi. Segera ganti jika Anda menggunakannya di tempat lain.',
    'errorPasswordEmpty'        => 'Kata sandi wajib diisi.',
    'errorPasswordTooLongBytes' => 'Kata sandi tidak boleh melebihi {param} byte.',
    'passwordChangeSuccess'     => 'Kata sandi berhasil diubah.',
    'userDoesNotExist'          => 'Gagal mengubah kata sandi. Pengguna tidak ditemukan.',
    'resetTokenExpired'         => 'Maaf, token reset Anda telah kedaluwarsa.',

    // Email Globals
    'emailInfo'      => 'Informasi mengenai pengguna:',
    'emailIpAddress' => 'Alamat IP:',
    'emailDevice'    => 'Perangkat:',
    'emailDate'      => 'Tanggal:',

    // 2FA
    'email2FATitle'       => 'Autentikasi Dua Faktor (2FA)',
    'confirmEmailAddress' => 'Konfirmasi alamat email Anda.',
    'emailEnterCode'      => 'Konfirmasi Email Anda',
    'emailConfirmCode'    => 'Masukkan 6 digit kode yang baru saja kami kirimkan ke email Anda.',
    'email2FASubject'     => 'Kode autentikasi Anda',
    'email2FAMailBody'    => 'Kode autentikasi Anda adalah:',
    'invalid2FAToken'     => 'Kode yang dimasukkan salah.',
    'need2FA'             => 'Anda harus menyelesaikan verifikasi dua faktor.',
    'needVerification'    => 'Silakan periksa email Anda untuk menyelesaikan aktivasi akun.',

    // Activate
    'emailActivateTitle'    => 'Aktivasi Email',
    'emailActivateBody'     => 'Kami baru saja mengirimkan kode verifikasi ke email Anda. Masukkan kode tersebut di bawah ini.',
    'emailActivateSubject'  => 'Kode aktivasi Anda',
    'emailActivateMailBody' => 'Gunakan kode di bawah ini untuk mengaktifkan akun Anda dan mulai menggunakan layanan kami.',
    'invalidActivateToken'  => 'Kode aktivasi salah.',
    'needActivate'          => 'Anda harus menyelesaikan pendaftaran dengan memasukkan kode yang dikirim ke email Anda.',
    'activationBlocked'     => 'Anda harus mengaktifkan akun terlebih dahulu sebelum masuk.',

    // Groups
    'unknownGroup' => '{0} bukan grup pengguna yang valid.',
    'missingTitle' => 'Grup pengguna wajib memiliki nama/judul.',

    // Permissions
    'unknownPermission' => '{0} bukan hak akses yang valid.',
];
