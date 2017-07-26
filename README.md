# Persona Human Resources Information System (Backend/API)

Persona HRIS adalah sistem informasi yang bertujuan untuk membantu pekerjaan HRD (Human Resources Department) dan Panggajian
yang fokus pada regulasi perundangan yang berlaku di Indonesia.

## Minimal Requirement

```
* PHPv7.1.X
* MariaDB 10.2.X atau MySQL 5.7.X
* Redis Server (untuk Session dan Cache Storage)
* Web Server (sangat opsional, hanya untuk production)
```

## Fitur Utama

```
* Management Pegawai
* Management Kontrak Pegawai
* Management Absensi
* Management Lembur
* Management Cuti
* Management Kursus/Pelatihan Internal
* Penggajian
* Pajak PPH 21 sesuai peraturan terbaru (2016)
* Penilaian Kinerja Karyawan
* Perjalanan Dinas (TODO)
* Inventori Karyawan (TODO)
* User Management
* Akses Management
```

## Instalasi

* Buat Database kosong dengan nama `persona_hris`
* Clone repo
* Pindah ke folder `Backend` atau folder yang Anda buat saat cloning
* Jalankan `composer update` atau `composer install` dan ikuti petunjuk instalasi
* Ubah file `app/config/parameters_dev.yml` sesuai kebutuhan jika diperlukan
* Jalankan `php bin/console doctrine:schema:update --force`
* Jalankan `php bin/console doctrine:fixtures:load` pilih `y`
* Jalankan `php bin/console server:run` dan buka browser `http://localhost:8000/api/doc`

## Table Prefix Dictionary:

```
* at = attendance
* ov = overtime
* em = employee
* cr = course
* sa = salary
* ap = appraisal
* ja = job allocation
* lv = leave
* og = organization
* tx = tax
* c = core
* s = shared
```

## TODO:

- Limit day per leave
- Leave Adjustment
- Create subscriber for Overtime base on real case - Done
- Taxing (perpajakan) - Done
- Inactivating others appraisal period when one other is active - Done
- Closing salary period - Done
- Check existing tax history - Done
- Make sure salary calculating only active employee and not closed period - Done
