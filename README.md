BACKEND
1. git clone-> link nya
2. open vsCode, composer install
3. di .env bagian default.database ganti ke nama db nya kita
4. php spark serve kalo db sudah di insertin semuanya.


FRONTEND
1. composer create-project laravel/laravel nama_folder

2. ke http controller lalu buat controller sesuai nama tabel contoh (mahasiswaController.php)

3. ke resource masuk ke views nya terus bikin crud nya tapi harus bikin folder dulu contoh (mahasiswa) di dalemnya bikin crud create.blade.php lalu edit.blade.php lalu index.blade.php

4. ke routes->web.php
Route::resource('dosen_wali', \App\Http\Controllers\DosenWaliController::class);
kalo sudah jangan lupa bikin folder layouts di dalemnya bikin app.blade.php

5. kalo sudah crud composer install
6. php artisan key:generate
7. php artisan serve

kalo ada perubahan:
php artisan config:clear
php artisan view:clear


GITHUB
1. git init
2. git add .
3. git commit -m "initial commit"
4. git remote add origin https://github.com/kamu/sistem-promosi.git (salin link repo yang sudah dibikin)
5. git branch -M main
6. git push -u origin main

https://github.com/AuliaZuifani/latihan_uas_pbf
https://github.com/AuliaZuifani/latihan_frontend
https://github.com/AuliaZuifani/latihan_backend

KALO GITHUB EXIST
error: remote origin already exists.
PS C:\laragon\www\PBF> git remote -v
>>
origin  https://github.com/Alledanaralle/PBF.git (fetch)
origin  https://github.com/Alledanaralle/PBF.git (push)
PS C:\laragon\www\PBF> git remote remove origin
PS C:\laragon\www\PBF> git remote add origin https://github.com/AuliaZuifani/latihan_backend
PS C:\laragon\www\PBF> git push -u origin main
Enumerating objects: 544, done.
Counting objects: 100% (544/544), done.
Delta compression using up to 16 threads
Compressing objects: 100% (215/215), done.
Writing objects: 100% (544/544), 172.49 KiB | 7.19 MiB/s, done.
Total 544 (delta 322), reused 526 (delta 313), pack-reused 0 (from 0)
remote: Resolving deltas: 100% (322/322), done.
To https://github.com/AuliaZuifani/latihan_backend
 * [new branch]      main -> main
branch 'main' set up to track 'origin/main'.
PS C:\laragon\www\PBF> 
ty6
