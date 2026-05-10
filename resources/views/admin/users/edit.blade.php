@extends('admin.layouts.app')

@section('header', 'Phân Quyền Người Dùng')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-bb-on-surface-variant hover:text-bb-primary flex items-center space-x-2 w-max transition-colors">
        <i class="ph ph-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>
</div>

<div class="glass-panel rounded-2xl p-8 max-w-xl mx-auto mt-10 relative overflow-hidden">
    <!-- Decal effect -->
    <i class="ph ph-shield-check absolute -bottom-10 -right-10 text-9xl text-bb-primary opacity-5"></i>

    <div class="flex items-center space-x-4 mb-8">
        <div class="w-16 h-16 rounded-full bg-bb-surface-highest flex items-center justify-center border border-bb-primary text-bb-primary">
            <i class="ph ph-user text-3xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-display font-bold">{{ $user->name }}</h4>
            <p class="text-bb-on-surface-variant text-sm">{{ $user->email }}</p>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6 relative z-10">
        @csrf
        @method('PUT')
        
        <div>
            <label for="role" class="block text-sm font-medium text-bb-on-surface-variant mb-4">Vai trò / Quyền hạn</label>
            
            <div class="space-y-3">
                <label class="flex items-center p-4 border border-bb-outline-variant rounded-xl cursor-pointer hover:border-bb-primary transition-colors {{ $user->role === 'user' ? 'bg-bb-surface-low border-bb-primary' : '' }}">
                    <input type="radio" name="role" value="user" class="w-5 h-5 text-bb-primary focus:ring-bb-primary bg-bb-surface-highest border-bb-outline-variant" {{ $user->role === 'user' ? 'checked' : '' }}>
                    <div class="ml-4 flex-1">
                        <p class="font-medium text-bb-on-surface">Người dùng thường</p>
                        <p class="text-xs text-bb-on-surface-variant mt-1">Chỉ có thể mua hàng và xem đơn hàng của mình.</p>
                    </div>
                </label>

                <label class="flex items-center p-4 border border-bb-outline-variant rounded-xl cursor-pointer hover:border-bb-primary transition-colors {{ $user->role === 'admin' ? 'bg-bb-primary/5 border-bb-primary' : '' }}">
                    <input type="radio" name="role" value="admin" class="w-5 h-5 text-bb-primary focus:ring-bb-primary bg-bb-surface-highest border-bb-outline-variant" {{ $user->role === 'admin' ? 'checked' : '' }}>
                    <div class="ml-4 flex-1">
                        <p class="font-medium text-bb-primary">Administrator</p>
                        <p class="text-xs text-bb-on-surface-variant mt-1">Toàn quyền truy cập vào trang quản trị, thêm sửa xóa dữ liệu.</p>
                    </div>
                </label>
            </div>
            
            @error('role') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="pt-6 border-t border-bb-outline-variant">
            <button type="submit" class="w-full bg-bb-primary text-bb-surface font-bold py-3 px-8 rounded-lg hover:bg-bb-primary-container transition-colors shadow-[0_0_15px_rgba(242,202,80,0.3)]">
                Lưu Thay Đổi
            </button>
        </div>
    </form>
</div>
@endsection
