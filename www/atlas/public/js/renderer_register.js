// public/js/renderer_register.js

document.addEventListener('DOMContentLoaded', function() {
    
    // === DEKLARASI ELEMEN FORM ===
    const registerForm = document.getElementById('register-form');
    const registerButton = document.getElementById('register-button');
    const customAlert = document.getElementById('custom-alert');
    const alertMessage = document.getElementById('alert-message');
    const alertCloseBtn = document.getElementById('alert-close-btn');

    // === LOGIKA NOTIFIKASI KUSTOM ===
    function showCustomAlert(message) {
        if (alertMessage && customAlert) {
            alertMessage.textContent = message;
            customAlert.classList.remove('hidden');
        }
    }
    if (alertCloseBtn) {
        alertCloseBtn.addEventListener('click', () => {
            if (customAlert) customAlert.classList.add('hidden');
        });
    }

    // === LOGIKA CANVAS TANDA TANGAN ===
    const canvas = document.getElementById('signature-pad');
    const clearButton = document.getElementById('clear-signature');
    
    // JAGA-JAGA: Cuma jalanin kode kanvas KALO elemennya ada
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            ctx.strokeStyle = '#000000';
            ctx.lineWidth = 2;
            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        function getMousePos(canvasDom, mouseEvent) {
            const rect = canvasDom.getBoundingClientRect();
            return { x: mouseEvent.clientX - rect.left, y: mouseEvent.clientY - rect.top };
        }

        function draw(e) {
            if (!isDrawing) return;
            const pos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            [lastX, lastY] = [pos.x, pos.y];
        }

        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            const pos = getMousePos(canvas, e);
            [lastX, lastY] = [pos.x, pos.y];
        });
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', () => isDrawing = false);
        canvas.addEventListener('mouseout', () => isDrawing = false);

        // Tambahan untuk touch screen (HP)
        canvas.addEventListener('touchstart', (e) => {
            isDrawing = true;
            const touch = e.touches[0];
            const pos = getMousePos(canvas, touch);
            [lastX, lastY] = [pos.x, pos.y];
        });
        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault(); // Biar halaman nggak ikut ke-scroll
            if (!isDrawing) return;
            const touch = e.touches[0];
            const pos = getMousePos(canvas, touch);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            [lastX, lastY] = [pos.x, pos.y];
        });
        canvas.addEventListener('touchend', () => isDrawing = false);

        if (clearButton) {
            clearButton.addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });
        }
    } else {
        console.error("Elemen #signature-pad tidak ditemukan!");
    }


    // === LOGIKA TOGGLE PASSWORD ===
    function setupPasswordToggle(toggleBtnId, passwordInputId, eyeIconId, eyeSlashIconId) {
        const toggleButton = document.getElementById(toggleBtnId);
        const input = document.getElementById(passwordInputId);
        const eyeIcon = document.getElementById(eyeIconId);
        const eyeSlashIcon = document.getElementById(eyeSlashIconId);

        if (toggleButton && input && eyeIcon && eyeSlashIcon) {
            toggleButton.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                eyeIcon.classList.toggle('hidden');
                eyeSlashIcon.classList.toggle('hidden');
            });
        }
    }
    setupPasswordToggle('toggle-password', 'password', 'eye-icon', 'eye-slash-icon');
    setupPasswordToggle('toggle-confirm-password', 'confirm-password', 'confirm-eye-icon', 'confirm-eye-slash-icon');


    // === LOGIKA SUBMIT FORM REGISTRASI KE LARAVEL ===
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault(); 
            registerButton.disabled = true;
            registerButton.textContent = 'Memproses...';

            // Validasi Password
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                showCustomAlert('Password dan Konfirmasi Password tidak cocok.');
                registerButton.disabled = false;
                registerButton.textContent = 'Register';
                return;
            }
            
            // Validasi Tanda Tangan
            if (canvas) {
                const blankCanvas = document.createElement('canvas');
                blankCanvas.width = canvas.width; blankCanvas.height = canvas.height;
                if (canvas.toDataURL() === blankCanvas.toDataURL()) {
                    showCustomAlert('Tanda tangan tidak boleh kosong.');
                    registerButton.disabled = false;
                    registerButton.textContent = 'Register';
                    return;
                }
                // Isi hidden input
                document.getElementById('signature-data').value = canvas.toDataURL('image/png');
            } else {
                showCustomAlert('Error: Komponen tanda tangan tidak ditemukan.');
                registerButton.disabled = false;
                registerButton.textContent = 'Register';
                return;
            }

            // Submit form-nya ke Laravel
            registerForm.submit();
        });
    }
});