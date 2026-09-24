MASTER MENU CLEAN FIX

Masalah yang diperbaiki:
1. CSS Master sebelumnya diletakkan di @push('styles') pada navbar,
   tetapi app.blade.php memanggil @stack('styles') sebelum navbar di-include.
   Akibatnya CSS tidak masuk ke head pada urutan render yang benar.
2. Pada versi fix sebelumnya, CSS sempat tampil sebagai TEXT di halaman.
   Itu tidak boleh terjadi.
3. Sekarang CSS Master berada DI DALAM <style> utama app.blade.php.
4. navbar.blade.php tidak lagi melakukan @push('styles') untuk CSS Master.
5. @push('scripts') tetap di navbar karena @stack('scripts') memang berada
   setelah navbar di-include.

File yang berubah:
- resources/views/layouts/app.blade.php
- resources/views/layouts/navbar.blade.php

File partial Master tetap:
- resources/views/layouts/partials/top-menu.blade.php

Setelah extract:
php artisan optimize:clear

Kemudian browser:
Ctrl + F5

Expected:
- Halaman TIDAK menampilkan CSS sebagai text.
- System bisa dibuka.
- Master tertutup secara default.
- Klik Master -> submenu Master muncul.
