<x-layouts.public title="Selamat Datang di SIDESA">

    <nav class="bg-white/80 backdrop-blur-md fixed top-0 left-0 right-0 z-20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('welcome') }}" class="text-2xl font-bold text-primary">SIDESA</a>
                </div>
                <div>
                    @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-primary-gradient hover:bg-primary-gradient-dark text-white font-semibold py-2 px-4 rounded-md transition-colors">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="bg-primary-gradient hover:bg-primary-gradient-dark text-white font-semibold py-2 px-4 rounded-md transition-colors">
                        Login Administrator
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative h-screen flex items-center justify-center text-center bg-cover bg-center"
        style="background-image: url('{{ asset('Login-Image.png') }}');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 p-4 text-white">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                Sistem Digital Desa
            </h1>
            <p class="text-xl md:text-2xl font-light mt-4 max-w-3xl mx-auto">
                Mewujudkan Administrasi Kependudukan yang Cepat, Akurat, dan Modern untuk Desa Anjir Muara Kota Tengah.
            </p>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-text-main">Solusi Digital untuk Pelayanan Desa</h2>
                <p class="mt-4 text-lg text-text-light">Tiga pilar utama yang kami tawarkan untuk mempermudah
                    administrasi.</p>
            </div>
            <div class="mt-12 grid gap-10 md:grid-cols-3">

                <div class="text-center p-6 border border-slate-200 rounded-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-gradient text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-text-main">Data Terpusat</h3>
                    <p class="mt-2 text-base text-text-light">Semua data kependudukan, mutasi, dan surat-menyurat
                        tersimpan aman dalam satu sistem yang terintegrasi.</p>
                </div>

                <div class="text-center p-6 border border-slate-200 rounded-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-gradient text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-text-main">Pelayanan Cepat</h3>
                    <p class="mt-2 text-base text-text-light">Proses pembuatan surat-surat administrasi menjadi lebih
                        cepat dan efisien, mengurangi waktu tunggu warga.</p>
                </div>

                <div class="text-center p-6 border border-slate-200 rounded-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-gradient text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-text-main">Peta Digital Desa</h3>
                    <p class="mt-2 text-base text-text-light">Visualisasikan data kependudukan dalam bentuk peta
                        interaktif untuk perencanaan dan analisis yang lebih baik.</p>
                </div>

            </div>
        </div>
    </section>

</x-layouts.public>