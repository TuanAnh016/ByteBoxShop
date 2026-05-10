@extends('layouts.app')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center py-20 relative overflow-hidden">
    <!-- Abstract Background -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bb-surface-high rounded-full blur-[100px] opacity-20 -z-10"></div>
    
    <div class="w-full max-w-md px-6 relative z-10" data-aos="fade-up">
        <div class="bg-bb-surface-low rounded-2xl p-10 md:p-12 ghost-border ambient-shadow relative overflow-hidden">
            <!-- Decorative line -->
            <div class="absolute top-0 left-0 w-full h-1 gold-lustre"></div>
            
            <div class="text-center mb-10">
                <h1 class="font-display font-bold text-3xl text-bb-on-surface mb-2">Đăng nhập</h1>
                <p class="font-body text-sm text-bb-on-surface-variant tracking-widest uppercase">Trải nghiệm đặc quyền</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent placeholder-bb-on-surface-variant/50">
                        @error('email') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Mật khẩu</label>
                        <input type="password" name="password" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent placeholder-bb-on-surface-variant/50">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-bb-outline-variant bg-bb-surface-highest text-bb-primary focus:ring-bb-primary focus:ring-offset-bb-surface cursor-pointer">
                            <span class="font-body text-sm text-bb-on-surface-variant group-hover:text-bb-on-surface transition-colors">Ghi nhớ</span>
                        </label>
                        <a href="#" class="font-body text-sm text-bb-primary hover:text-bb-primary-container transition-colors">Quên mật khẩu?</a>
                    </div>
                </div>

                <button type="submit" class="w-full text-center gold-lustre px-8 py-4 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-[1.02] transition-transform mb-6">
                    Đăng nhập
                </button>
                
                <div class="text-center font-body text-sm text-bb-on-surface-variant">
                    Chưa có tài khoản? 
                    <a href="{{ route('register') }}" class="text-bb-primary hover:text-bb-primary-container font-bold transition-colors">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
