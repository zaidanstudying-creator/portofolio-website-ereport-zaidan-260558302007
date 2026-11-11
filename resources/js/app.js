document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-password-toggle]');

    if (!button) {
        return;
    }

    const input = document.getElementById(button.dataset.passwordToggle);

    if (!input) {
        return;
    }

    const reveal = input.type === 'password';
    input.type = reveal ? 'text' : 'password';
    button.textContent = reveal ? 'Sembunyikan' : 'Lihat';
    button.setAttribute('aria-label', `${reveal ? 'Sembunyikan' : 'Tampilkan'} kata sandi`);
});

let photoPreviewUrl = null;

document.addEventListener('change', (event) => {
    if (event.target.id !== 'foto') {
        return;
    }

    const preview = document.getElementById('photo-preview');
    const file = event.target.files?.[0];

    if (photoPreviewUrl) {
        URL.revokeObjectURL(photoPreviewUrl);
        photoPreviewUrl = null;
    }

    if (!preview || !file) {
        if (preview) {
            preview.hidden = true;
            preview.removeAttribute('src');
        }

        return;
    }

    photoPreviewUrl = URL.createObjectURL(file);
    preview.src = photoPreviewUrl;
    preview.hidden = false;
});

document.addEventListener('submit', (event) => {
    const button = event.target.querySelector('[data-submit-label]');

    if (!button || !event.target.reportValidity()) {
        return;
    }

    button.disabled = true;
    button.textContent = 'Mengirim…';
});
