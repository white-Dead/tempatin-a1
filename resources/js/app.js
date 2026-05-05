import './bootstrap';

// PWA Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    });
}

// Geolokasi untuk filter "dekat saya"
window.requestUserLocation = (livewireComponent) => {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(
        (pos) => {
            livewireComponent.setUserLocation(pos.coords.latitude, pos.coords.longitude);
        },
        () => {
            // Gagal → gunakan default Yogyakarta
        },
        { timeout: 6000, maximumAge: 300000 }
    );
};

// Log aktivitas ke server (klik rute/kontak)
window.logPlaceAction = async (placeId, actionType) => {
    try {
        await fetch(`/tempat/${placeId}/log`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ action_type: actionType }),
        });
    } catch (_) {}
};

// Alpine.js helper: toast notifikasi
document.addEventListener('alpine:init', () => {
    Alpine.store('toast', {
        messages: [],
        add(msg, type = 'success') {
            const id = Date.now();
            this.messages.push({ id, msg, type });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) {
            this.messages = this.messages.filter(m => m.id !== id);
        },
    });
});

// Livewire global event: show toast
document.addEventListener('livewire:init', () => {
    Livewire.on('show-login-prompt', () => {
        window.location.href = '/masuk';
    });
});
