<section>
    <form id="smtp-settings-form" method="POST" action="{{ route('profile.smtp.update') }}" class="mt-1">
        @csrf
        @method('patch')

        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_host" class="form-label">SMTP Sunucu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-server'></i></span>
                                                <input type="text" class="form-control @error('mail_host') is-invalid @enderror"
                            id="mail_host" name="mail_host" value="{{ old('mail_host', \App\Models\MailSetting::getActive()?->mail_host ?? '') }}"
                            placeholder="smtp.example.com">
                        @error('mail_host')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">SMTP sunucu adresi (örn: smtp.gmail.com)</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_port" class="form-label">Port</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-plug'></i></span>
                                                <input type="number" class="form-control @error('mail_port') is-invalid @enderror"
                            id="mail_port" name="mail_port" value="{{ old('mail_port', \App\Models\MailSetting::getActive()?->mail_port ?? '') }}"
                            placeholder="587" min="1" max="65535">
                        @error('mail_port')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">SMTP port numarası (genellikle 587, 465 veya 25)</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_username" class="form-label">Kullanıcı Adı</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                                                <input type="text" class="form-control @error('mail_username') is-invalid @enderror"
                            id="mail_username" name="mail_username" value="{{ old('mail_username', \App\Models\MailSetting::getActive()?->mail_username ?? '') }}"
                            placeholder="email@example.com">
                        @error('mail_username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">SMTP hesap kullanıcı adı (genellikle e-posta adresiniz)</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_password" class="form-label">Şifre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                                <input type="password" class="form-control @error('mail_password') is-invalid @enderror"
                            id="mail_password" name="mail_password" value="{{ old('mail_password', \App\Models\MailSetting::getActive()?->mail_password ?? '') }}"
                            placeholder="••••••••">
                        @error('mail_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">SMTP hesap şifresi veya uygulama şifresi</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_encryption" class="form-label">Şifreleme</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-shield'></i></span>
                        <select class="form-select @error('mail_encryption') is-invalid @enderror" id="mail_encryption" name="mail_encryption">
                            @php $mailEncryption = old('mail_encryption', \App\Models\MailSetting::getActive()?->mail_encryption ?? ''); @endphp
                            <option value="tls" {{ $mailEncryption == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ $mailEncryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ $mailEncryption == '' || $mailEncryption == null ? 'selected' : '' }}>Yok</option>
                        </select>
                        @error('mail_encryption')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Bağlantı şifreleme türü (genellikle TLS)</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_from_address" class="form-label">Gönderen E-posta</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                        <input type="email" class="form-control @error('mail_from_address') is-invalid @enderror"
                            id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', \App\Models\MailSetting::getActive()?->mail_from_address ?? '') }}"
                            placeholder="bilgi@oteliniz.com">
                        @error('mail_from_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">E-postaların gönderici adresi</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mail_from_name" class="form-label">Gönderen Adı</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-hotel'></i></span>
                        <input type="text" class="form-control @error('mail_from_name') is-invalid @enderror"
                            id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', \App\Models\MailSetting::getActive()?->mail_from_name ?? '') }}"
                            placeholder="Otelinizin Adı">
                        @error('mail_from_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">E-postaların gönderici adı</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="test_email" class="form-label">Test E-postası</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-test-tube'></i></span>
                        <input type="email" class="form-control @error('test_email') is-invalid @enderror"
                            id="test_email" name="test_email" placeholder="test@example.com">
                        @error('test_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Ayarları test etmek için bir e-posta adresi girin</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Test Kişi Adı</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Ahmet Yılmaz">
                    </div>
                    <div class="form-text">Test e-postasında görünecek kişi adı</div>
                </div>
            </div>

            <div class="col-12">
                <div class="d-grid">
                    <button type="button" id="send-test-email" class="btn btn-outline-primary">
                        <i class='bx bx-send me-1'></i> Test E-postası Gönder
                    </button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class='bx bx-save me-1'></i> SMTP Ayarlarını Kaydet
            </button>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendTestEmailBtn = document.getElementById('send-test-email');
    const testEmailInput = document.getElementById('test_email');

    sendTestEmailBtn.addEventListener('click', function() {
        const email = testEmailInput.value.trim();
        const customerNameInput = document.getElementById('customer_name');
        const customerName = customerNameInput.value.trim();

        if (!email) {
            alert('Lütfen test e-postası adresini girin.');
            return;
        }

        // E-posta format kontrolü
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Lütfen geçerli bir e-posta adresi girin.');
            return;
        }

        // Butonu devre dışı bırak ve loading durumu göster
        const originalHtml = sendTestEmailBtn.innerHTML;
        sendTestEmailBtn.disabled = true;
        sendTestEmailBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Gönderiliyor...';

        // AJAX ile test e-postası gönder
        fetch('{{ route("profile.send-test-email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                test_email: email,
                customer_name: customerName
            })
        })
                .then(response => {
            // Response kontrolü
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const contentType = response.headers.get("content-type");

            if (contentType && contentType.indexOf("application/json") !== -1) {
                return response.json();
            } else {
                // HTML response'u sessizce handle et
                return response.text().then(text => {
                    throw new Error("Server yanıtı beklenmedik formatta");
                });
            }
        })
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                testEmailInput.value = ''; // Başarılı olursa inputu temizle
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ E-posta gönderilirken bir hata oluştu: ' + error.message);
        })
        .finally(() => {
            // Butonu tekrar aktif et
            sendTestEmailBtn.disabled = false;
            sendTestEmailBtn.innerHTML = originalHtml;
        });
    });
});
</script>
