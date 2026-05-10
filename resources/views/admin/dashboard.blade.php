@extends('admin.layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Stat Card 1 -->
    <div class="glass-panel p-6 rounded-2xl flex items-center justify-between group hover:-translate-y-1 transition-transform duration-300">
        <div>
            <p class="text-bb-on-surface-variant text-sm font-medium uppercase tracking-widest mb-1">Người dùng</p>
            <h3 class="text-3xl font-display font-bold text-bb-on-surface group-hover:text-bb-primary transition-colors">{{ $usersCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-bb-surface-highest flex items-center justify-center text-bb-primary">
            <i class="ph ph-users text-2xl"></i>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="glass-panel p-6 rounded-2xl flex items-center justify-between group hover:-translate-y-1 transition-transform duration-300">
        <div>
            <p class="text-bb-on-surface-variant text-sm font-medium uppercase tracking-widest mb-1">Vật phẩm</p>
            <h3 class="text-3xl font-display font-bold text-bb-on-surface group-hover:text-bb-primary transition-colors">{{ $productsCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-bb-surface-highest flex items-center justify-center text-bb-primary">
            <i class="ph ph-package text-2xl"></i>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="glass-panel p-6 rounded-2xl flex items-center justify-between group hover:-translate-y-1 transition-transform duration-300">
        <div>
            <p class="text-bb-on-surface-variant text-sm font-medium uppercase tracking-widest mb-1">Danh mục</p>
            <h3 class="text-3xl font-display font-bold text-bb-on-surface group-hover:text-bb-primary transition-colors">{{ $categoriesCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-bb-surface-highest flex items-center justify-center text-bb-primary">
            <i class="ph ph-folders text-2xl"></i>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="glass-panel p-6 rounded-2xl flex items-center justify-between group hover:-translate-y-1 transition-transform duration-300">
        <div>
            <p class="text-bb-on-surface-variant text-sm font-medium uppercase tracking-widest mb-1">Đơn hàng</p>
            <h3 class="text-3xl font-display font-bold text-bb-on-surface group-hover:text-bb-primary transition-colors">{{ $ordersCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-bb-surface-highest flex items-center justify-center text-bb-primary">
            <i class="ph ph-shopping-cart text-2xl"></i>
        </div>
    </div>

</div>

<div class="glass-panel rounded-2xl p-8 text-center flex flex-col items-center justify-center py-20">
    <div class="w-24 h-24 rounded-full bg-bb-surface-highest flex items-center justify-center mb-6 border border-bb-outline-variant">
        <i class="ph ph-rocket-launch text-4xl text-bb-primary animate-pulse"></i>
    </div>
    <h2 class="text-2xl font-display font-bold mb-2">Chào mừng đến với hệ thống quản trị</h2>
    <p class="text-bb-on-surface-variant max-w-lg">Sử dụng menu bên trái để quản lý danh mục, vật phẩm, người dùng và các thiết lập khác cho hệ thống ByteBox.</p>
</div>
@endsection
