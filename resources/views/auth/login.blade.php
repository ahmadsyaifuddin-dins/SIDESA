<x-layouts.guest title="Login SIDESA">
    
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-primary">Selamat Datang Kembali!</h2>
        <p class="text-sm text-text-light">Silakan login untuk melanjutkan ke dashboard.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm bg-red-100 text-red-700 p-3 rounded-md">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-primary mb-1">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/><path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/></svg>
                </div>
                <input id="email" 
                       class="block w-full ps-10 p-2.5 border-slate-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" 
                       type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com" />
            </div>
        </div>

        <div>
            <label for="password" class="block font-medium text-sm text-primary mb-1">Password</label>
            <div class="relative">
                 <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                </div>
                <input id="password" 
                       class="block w-full ps-10 p-2.5 border-slate-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" 
                       type="password" name="password" required placeholder="********" />
            </div>
        </div>

        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input id="remember" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-text-light">Ingat Saya</span>
            </label>
            <a class="underline text-sm text-text-light hover:text-text-main" href="#">Lupa password?</a>
        </div>

        <div class="flex items-center">
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-gradient hover:bg-primary-gradient-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Login
            </button>
        </div>
    </form>
</x-layouts.guest>