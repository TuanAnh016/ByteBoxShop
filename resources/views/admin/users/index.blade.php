@extends('admin.layouts.app')

@section('header', 'Quản lý người dùng')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-lg font-medium">Danh sách người dùng</h3>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-bb-surface-highest border-b border-bb-outline-variant text-bb-on-surface-variant text-sm uppercase tracking-wider">
                <th class="p-4 font-medium">ID</th>
                <th class="p-4 font-medium">Tên</th>
                <th class="p-4 font-medium">Email</th>
                <th class="p-4 font-medium">Quyền</th>
                <th class="p-4 font-medium">Ngày đăng ký</th>
                <th class="p-4 font-medium text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-bb-outline-variant">
            @forelse($users as $user)
            <tr class="hover:bg-bb-surface-low transition-colors group">
                <td class="p-4 text-bb-on-surface-variant">{{ $user->id }}</td>
                <td class="p-4 font-medium">{{ $user->name }}</td>
                <td class="p-4 text-bb-on-surface-variant">{{ $user->email }}</td>
                <td class="p-4">
                    @if($user->role === 'admin')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-bb-primary/20 text-bb-primary border border-bb-primary/30">Admin</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-bb-surface-highest text-bb-on-surface-variant border border-bb-outline-variant">User</span>
                    @endif
                </td>
                <td class="p-4 text-bb-on-surface-variant text-sm">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                <td class="p-4 text-right space-x-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-bb-surface-highest text-bb-primary hover:bg-bb-primary hover:text-bb-surface transition-colors" title="Sửa quyền">
                        <i class="ph ph-shield-check text-lg"></i>
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-bb-surface-highest text-red-400 hover:bg-red-500 hover:text-white transition-colors" title="Xóa">
                            <i class="ph ph-trash text-lg"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-bb-on-surface-variant">
                    Chưa có người dùng nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($users->hasPages())
    <div class="p-4 border-t border-bb-outline-variant">
        {{ $users->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
