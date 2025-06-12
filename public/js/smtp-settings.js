document.addEventListener('DOMContentLoaded', function() {
    // Test e-postası gönderme butonu
    const sendTestEmailBtn = document.getElementById('send-test-email');
    
    if (sendTestEmailBtn) {
        sendTestEmailBtn.addEventListener('click', function() {
            const testEmail = document.getElementById('test_email').value;
            
            if (!testEmail) {
                showAlert('Lütfen test için bir e-posta adresi girin.', 'danger');
                return;
            }
            
            // Butonu devre dışı bırak ve yükleniyor göster
            sendTestEmailBtn.disabled = true;
            sendTestEmailBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Gönderiliyor...';
            
            // AJAX isteği gönder
            fetch('/profile/smtp/test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    test_email: testEmail
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message, 'danger');
                }
            })
            .catch(error => {
                showAlert('E-posta gönderilirken bir hata oluştu: ' + error, 'danger');
            })
            .finally(() => {
                // Butonu tekrar aktif et
                sendTestEmailBtn.disabled = false;
                sendTestEmailBtn.innerHTML = '<i class="bx bx-send me-1"></i> Test E-postası Gönder';
            });
        });
    }
    
    // Alert gösterme fonksiyonu
    function showAlert(message, type) {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert alert-${type} alert-dismissible fade show`;
        alertContainer.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Form üstüne ekle
        const form = document.getElementById('smtp-settings-form');
        form.parentNode.insertBefore(alertContainer, form);
        
        // 5 saniye sonra otomatik kapat
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
});
