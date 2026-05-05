const CACHE_NAME = 'tempatin-v1';
const STATIC_ASSETS = [
    '/',
    '/offline.html',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k))
            )
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // Skip non-GET dan request ke Livewire
    if (event.request.method !== 'GET') return;
    if (event.request.url.includes('/livewire/')) return;

    // Network-first untuk halaman HTML
    if (event.request.headers.get('accept')?.includes('text/html')) {
        event.respondWith(
            fetch(event.request)
                .catch(() => caches.match('/offline.html'))
        );
        return;
    }

    // Cache-first untuk aset statis (CSS, JS, gambar)
    event.respondWith(
        caches.match(event.request).then(
            (cached) => cached || fetch(event.request).then((response) => {
                if (response.ok && response.url.includes('/build/')) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
                }
                return response;
            })
        )
    );
});
