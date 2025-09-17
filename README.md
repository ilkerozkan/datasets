# Akademik Profil Sitesi

Bu depo, Prof. Dr. Ayşe Demir için hazırlanan akademik web sayfasını ve içerik yönetimini kolaylaştıran PHP tabanlı bir yönetim panelini içerir. İçerik MySQL veritabanında saklanır ve yönetim paneli sayesinde yeni veriler eklenebilir veya mevcut kayıtlar güncellenebilir.

## Kurulum

1. **Bağımlılıklar**
   - PHP 8.1+ (PDO MySQL eklentisi etkin olmalıdır)
   - MySQL 5.7+ veya MariaDB eşdeğeri
   - Bir web sunucusu (Apache, Nginx veya PHP yerleşik sunucusu)

2. **Veritabanı**
   - `database.sql` dosyasını çalıştırarak `academic_profile` adlı veritabanını ve tabloları oluşturun:
     ```bash
     mysql -u <kullanıcı> -p < database.sql
     ```
   - Gerekirse farklı veritabanı adı/kullanıcısı belirleyebilir ve `config.php` dosyasındaki varsayılan değerleri ortam değişkenleriyle değiştirebilirsiniz:
     ```bash
     export APP_DB_HOST=localhost
     export APP_DB_NAME=academic_profile
     export APP_DB_USER=akademik
     export APP_DB_PASS=guclu_sifre
     ```

3. **Sunucu Başlatma**
   - Geliştirme ortamında PHP yerleşik sunucusunu kullanabilirsiniz:
     ```bash
     php -S localhost:8000
     ```
   - Ardından ana site için `http://localhost:8000/index.php`, yönetim paneli için `http://localhost:8000/admin/index.php` adresini ziyaret edin.

## Yönetim Paneli

- Yönetim paneli `admin/index.php` yolundadır.
- Profil, araştırma alanları, yayınlar, dersler, projeler ve özgeçmiş bölümleri için yeni kayıt ekleyebilir, mevcut kayıtları silebilirsiniz.
- Panel yalnızca temel doğrulamalar içerir; üretim ortamında kullanıcı girişi, CSRF koruması ve HTTPS gibi ek güvenlik önlemleri uygulamanız önerilir.

## İçerik

- Veritabanında kayıt bulunmadığında veya bağlantı kurulamadığında site, örnek içerik gösterir ve bu durum sayfa içerisinde bilgilendirme mesajıyla belirtilir.
- `config.php` dosyası PDO bağlantısını yönetir ve varsayılan olarak `APP_DB_*` ortam değişkenlerini kullanır.

## Dosya Yapısı

- `index.php`: Dinamik içerik sunan ana sayfa.
- `admin/index.php`: İçeriği güncellemek için kullanılan yönetim paneli.
- `config.php`: Veritabanı bağlantı ayarları.
- `database.sql`: Gerekli tabloların oluşturulması için SQL betiği.

Herhangi bir sorunda `admin/index.php` üzerinden veri ekleyip güncelleyebilir, daha sonra ana sayfayı yenileyerek değişiklikleri görebilirsiniz.
