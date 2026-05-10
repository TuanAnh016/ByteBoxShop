@extends('layouts.app')

@section('content')
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="font-display font-bold text-4xl md:text-5xl text-bb-on-surface mb-16" data-aos="fade-up">Thanh toán</h1>

        <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col lg:flex-row gap-12" data-aos="fade-up" data-aos-delay="100">
            @csrf
            
            <!-- Shipping Form -->
            <div class="lg:w-2/3">
                <div class="bg-bb-surface-low rounded-2xl p-8 md:p-12 ghost-border">
                    <h2 class="font-display text-2xl font-bold text-bb-on-surface mb-8">Thông tin giao hàng</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Họ tên</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', Auth::user()->name) }}" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                            @error('shipping_name') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Số điện thoại</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                            @error('shipping_phone') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Địa chỉ giao hàng</label>
                        <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" required class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">
                        @error('shipping_address') <span class="text-bb-error text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-2">Ghi chú (Tùy chọn)</label>
                        <textarea name="note" rows="3" class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body px-4 py-3 focus:outline-none focus:border-bb-primary transition-colors bg-transparent">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-bb-surface-low rounded-2xl p-8 ghost-border sticky top-32">
                    <h2 class="font-display text-2xl font-bold text-bb-on-surface mb-8">Đơn hàng</h2>
                    
                    <div class="space-y-6 mb-8 max-h-[40vh] overflow-y-auto pr-2">
                        @foreach($cart as $item)
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <div class="font-display font-bold text-bb-on-surface text-sm line-clamp-1 mb-1">{{ $item['name'] }}</div>
                                <div class="font-body text-xs text-bb-on-surface-variant">SL: {{ $item['quantity'] }}</div>
                            </div>
                            <div class="font-body text-sm font-bold text-bb-primary whitespace-nowrap">
                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 mb-8 font-body border-t ghost-border-bottom pt-6">
                        <div class="flex justify-between text-bb-on-surface-variant">
                            <span>Tạm tính</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-bb-on-surface-variant">
                            <span>Giao hàng</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-4">
                            <span class="text-bb-on-surface">Tổng cộng</span>
                            <span class="text-bb-primary">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full text-center gold-lustre px-8 py-4 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-[1.02] transition-transform">
                        Xác nhận đặt hàng
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
