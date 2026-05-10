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
                <h1 class="font-display font-bold text-3xl text-bb-on-surface mb-2">Đăng ký</h1>
                <p class="font-body text-sm text-bb-on-surface-variant tracking-widest uppercase">Gia nhập Atelier</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                
                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Họ tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                        @error('name') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                        @error('email') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-3">Giới tính</label>
                        <div class="flex gap-4">
                            @foreach(['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'] as $val => $label)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="gender" value="{{ $val }}" {{ old('gender') == $val ? 'checked' : '' }}
                                    class="hidden peer">
                                <span class="w-4 h-4 rounded-full border border-bb-outline-variant peer-checked:border-bb-primary peer-checked:bg-bb-primary transition-all flex items-center justify-center flex-shrink-0">
                                    <span class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></span>
                                </span>
                                <span class="font-body text-sm text-bb-on-surface-variant group-hover:text-bb-on-surface transition-colors">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('gender') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Ngày sinh</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                            max="{{ now()->subYears(13)->format('Y-m-d') }}"
                            class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent [color-scheme:dark]">
                        @error('date_of_birth') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Mật khẩu</label>
                        <input type="password" name="password" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                        @error('password') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                    </div>
                </div>

                <button type="submit" class="w-full text-center gold-lustre px-8 py-4 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-[1.02] transition-transform mb-6">
                    Đăng ký
                </button>
                
                <div class="text-center font-body text-sm text-bb-on-surface-variant">
                    Đã có tài khoản? 
                    <a href="{{ route('login') }}" class="text-bb-primary hover:text-bb-primary-container font-bold transition-colors">Đăng nhập ngay</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Custom radio buttons visual feedback
    document.querySelectorAll('input[name="gender"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="gender"]').forEach(r => {
                const dot = r.nextElementSibling?.querySelector('span');
                if (dot) dot.style.opacity = r.checked ? '1' : '0';
            });
        });
    });
</script>
@endpush
