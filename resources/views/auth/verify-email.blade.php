<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-[var(--color-background)] px-4 py-12 text-[var(--color-foreground)] transition-colors duration-200 sm:px-6 lg:px-8">
        
        <div class="w-full max-w-md space-y-8">
            
            {{-- الشعار والعنوان --}}
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[var(--color-primary)] text-white shadow-lg shadow-[var(--color-primary)]/20">
                    <x-authentication-card-logo />
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-[var(--color-foreground)] sm:text-3xl">
                    {{ __('Verify Your Email Address') }}
                </h2>
                <p class="mt-2 text-sm text-[var(--color-foreground-muted)] leading-relaxed">
                    {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </p>
            </div>

            {{-- بطاقة الإجراءات --}}
            <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-xl shadow-black/5 sm:p-8">
                
                {{-- تنبيه نجاح إعادة الإرسال --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 rounded-lg border border-[var(--color-success)]/20 bg-[var(--color-success)]/10 p-4 text-xs font-medium text-[var(--color-success)]">
                        {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                    </div>
                @endif

                <div class="space-y-4">
                    {{-- زر إعادة إرسال رابط التحقق --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <x-button type="submit" class="w-full justify-center rounded-xl bg-[var(--color-primary)] px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--color-primary-hover)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:ring-offset-2 border-0">
                            {{ __('Resend Verification Email') }}
                        </x-button>
                    </form>

                    {{-- خيارات تعديل الملف الشخصي وتسجيل الخروج --}}
                    <div class="flex items-center justify-between pt-2">
                        <a 
                            href="{{ route('profile.show') }}" 
                            class="text-xs font-medium text-[var(--color-foreground-muted)] transition hover:text-[var(--color-primary)] focus:outline-none"
                        >
                            {{ __('Edit Profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf

                            <button 
                                type="submit" 
                                class="text-xs font-medium text-[var(--color-danger)] transition hover:underline focus:outline-none"
                            >
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-guest-layout>