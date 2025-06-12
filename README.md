# Otel Yönetim Sistemi

Bu proje, modern bir otel veya konaklama tesisinin operasyonel ihtiyaçlarını yönetmek için geliştirilmiş, Laravel tabanlı kapsamlı bir web uygulamasıdır. Sistem, rezervasyon yönetiminden oda durumlarına, temizlik görevlerinden raporlamaya kadar birçok temel süreci dijitalleştirmeyi amaçlar.

---

## 🚀 Nasıl Çalışır? (Kurulum ve Başlatma)

Projeyi yerel makinenizde çalıştırmak için aşağıdaki adımları izleyin:

1.  **Projeyi Klonlayın:**
    ```bash
    git clone https://github.com/kullanici-adi/otel-rezervasyon.git
    cd otel-rezervasyon
    ```

2.  **PHP Bağımlılıklarını Yükleyin:**
    ```bash
    composer install
    ```

3.  **JavaScript Bağımlılıklarını Yükleyin:**
    ```bash
    npm install
    ```

4.  **Ortam Dosyasını Oluşturun:**
    `.env.example` dosyasını kopyalayarak yeni bir `.env` dosyası oluşturun.
    ```bash
    cp .env.example .env
    ```

5.  **Uygulama Anahtarını Oluşturun:**
    ```bash
    php artisan key:generate
    ```

6.  **Veritabanı Ayarlarını Yapılandırın:**
    Oluşturduğunuz `.env` dosyasını açın ve aşağıdaki veritabanı bilgilerini kendi yerel ayarlarınıza göre güncelleyin:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=otel_yonetim
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Veritabanını Oluşturun ve Doldurun:**
    Aşağıdaki komut, veritabanı tablolarını oluşturacak (`migrate`) ve başlangıç için gerekli olan örnek verileri (roller, admin kullanıcısı vb.) ekleyecektir (`seed`).
    ```bash
    php artisan migrate --seed
    ```
    > **Varsayılan Admin Giriş Bilgileri:**
    > - **E-posta:** `admin@example.com`
    > - **Şifre:** `password`
    >
    > **Not:** Güvenlik nedeniyle, ilk girişten sonra bu şifreyi hemen değiştirmeniz önemle tavsiye edilir.

8.  **Varlık (Asset) Dosyalarını Derleyin:**
    ```bash
    npm run dev
    ```

9.  **Uygulamayı Başlatın:**
    ```bash
    php artisan serve
    ```
    Artık projeye `http://localhost:8000` adresinden erişebilirsiniz.

---

## ✨ Neler Yapılabilir? (Mevcut Özellikler)

-   **Dashboard:** Sistemin genel durumunu özetleyen (dolu/boş odalar, günlük giriş/çıkışlar) ana kontrol paneli.
-   **Rezervasyon Yönetimi:**
    -   Yeni rezervasyon oluşturma, mevcutları düzenleme ve silme.
    -   Rezervasyon oluşturma/düzenleme sırasında oda çakışmalarının anlık (real-time) kontrolü.
    -   Check-in ve check-out işlemlerinin yönetimi.
    -   Check-in tarih kontrolü (tarihi gelmemiş rezervasyon için check-in yapılamaz).
-   **Oda ve Oda Tipi Yönetimi:** Dinamik olarak odaları ve oda tiplerini (tek kişilik, çift kişilik vb.) ekleme ve yönetme.
-   **Temizlik Yönetimi:** Odalar için temizlik görevleri oluşturma, personellere atama ve durum takibi (beklemede, yapılıyor, tamamlandı).
-   **Müşteri İstekleri:** Müşterilerden gelen özel isteklerin takibi ve yönetimi.
-   **Raporlama:** Doluluk oranları, gelir ve diğer performans metrikleri hakkında temel raporlar.
-   **Kullanıcı ve Yetki Yönetimi:** Rol bazlı yetkilendirme (Admin, Resepsiyonist, Temizlik Personeli).
-   **Aktivite Logları:** Sistemde yapılan tüm önemli işlemlerin kaydının tutulması (Sadece Admin).
-   **Cron Job Yönetimi:** Otomatik check-in/check-out gibi zamanlanmış görevlerin yönetimi ve izlenmesi için arayüz (Sadece Admin).

---

## 🔮 Gelecek Güncellemeler (Planlanan Geliştirmeler)

-   **Gelişmiş Raporlama Modülü:**
    -   Grafik ve istatistiklerle zenginleştirilmiş görsel raporlar.
    -   Tarih aralığına göre özel rapor oluşturma.
    -   Raporları PDF/Excel formatında dışa aktarma.
-   **Online Ödeme Entegrasyonu:**
    -   Stripe, Iyzico gibi popüler ödeme ağ geçitleri ile entegrasyon.
    -   Rezervasyon sırasında online ön ödeme veya tam ödeme alınması.
-   **Müşteri Portalı:**
    -   Müşterilerin kendi rezervasyonlarını görüntüleyebileceği, düzenleyebileceği ve yeni istekler oluşturabileceği özel bir portal.
-   **Çoklu Dil Desteği:** Sistemin arayüzünün farklı dillere çevrilebilmesi.
-   **Dinamik Fiyatlandırma:** Sezona, doluluk oranına veya özel etkinliklere göre oda fiyatlarının otomatik olarak ayarlanması.
-   **Kanal Yöneticisi Entegrasyonu:** Booking.com, Airbnb gibi üçüncü parti rezervasyon kanallarıyla takvim senkronizasyonu.
-   **Mobil Uygulama/PWA:** Özellikle temizlik personeli ve yöneticiler için anlık bildirimler ve görev takibi sağlayan bir mobil arayüz.
-   **SMS Bildirim Entegrasyonu:**
    -   Müşterilere rezervasyon onayı, check-in hatırlatması gibi önemli bilgileri SMS ile gönderme.
    -   Yeni bir rezervasyon veya acil bir durum olduğunda personele SMS ile bildirim.
