<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteBox Admin | Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;600;800&family=Manrope:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bb: {
                            surface: '#131313',
                            'surface-low': '#1c1b1b',
                            'surface-high': '#2a2a2a',
                            'surface-highest': '#353534',
                            primary: '#f2ca50',
                            'primary-container': '#d4af37',
                            secondary: '#c8c6c5',
                            tertiary: '#bfcdff',
                            'on-surface': '#e5e2e1',
                            'on-surface-variant': '#d0c5af',
                            'outline-variant': '#4d4635'
                        }
                    },
                    fontFamily: {
                        display: ['Epilogue', 'sans-serif'],
                        body: ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #131313; color: #e5e2e1; font-family: 'Manrope', sans-serif; }
        .font-display { font-family: 'Epilogue', sans-serif; letter-spacing: -0.02em; }
        .glass-panel { background: rgba(28, 27, 27, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(77, 70, 53, 0.3); }
        .glass-sidebar { background: rgba(19, 19, 19, 0.95); backdrop-filter: blur(20px); border-right: 1px solid rgba(77, 70, 53, 0.3); }
        .gold-lustre { background: linear-gradient(135deg, #f2ca50 0%, #d4af37 100%); color: #3c2f00; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #131313; }
        ::-webkit-scrollbar-thumb { background: #353534; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #f2ca50; }
        
        /* Interactive Nav Link */
        .nav-link { position: relative; overflow: hidden; transition: all 0.3s ease; }
        .nav-link::before { content: ''; position: absolute; left: -100%; top: 0; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(242, 202, 80, 0.1), transparent); transition: left 0.5s ease; }
        .nav-link:hover::before { left: 100%; }
        .nav-link.active { background: rgba(242, 202, 80, 0.1); border-left: 3px solid #f2ca50; color: #f2ca50; }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 glass-sidebar h-full flex flex-col transition-all duration-300 relative z-20">
        <div class="h-20 flex items-center justify-center border-b border-bb-outline-variant">
            <a href="{{ route('admin.dashboard') }}" class="font-display font-bold text-2xl tracking-widest text-bb-primary hover:opacity-80 transition-opacity">BYTEBOX.</a>
        </div>
        
        <div class="flex-1 overflow-y-auto py-6">
            <nav class="space-y-2 px-4 font-body text-sm">
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-bb-on-surface-variant hover:text-bb-primary {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four text-xl"></i>
                    <span>Dashboard</span>
                </a>
                
                <h3 class="px-4 pt-6 pb-2 text-xs uppercase tracking-widest text-bb-outline-variant">Cửa hàng</h3>
                <a href="{{ route('admin.categories.index') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-bb-on-surface-variant hover:text-bb-primary {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ph ph-folders text-xl"></i>
                    <span>Danh mục</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-bb-on-surface-variant hover:text-bb-primary {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="ph ph-package text-xl"></i>
                    <span>Vật phẩm</span>
                </a>
                
                <h3 class="px-4 pt-6 pb-2 text-xs uppercase tracking-widest text-bb-outline-variant">Quản lý</h3>
                <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-bb-on-surface-variant hover:text-bb-primary {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ph ph-users text-xl"></i>
                    <span>Người dùng</span>
                </a>
            </nav>
        </div>
        
        <div class="p-4 border-t border-bb-outline-variant">
            <a href="{{ route('home') }}" class="flex items-center justify-center space-x-2 w-full py-2 px-4 rounded-lg border border-bb-outline-variant text-bb-on-surface-variant hover:text-bb-primary hover:border-bb-primary transition-colors text-sm">
                <i class="ph ph-storefront"></i>
                <span>Trang khách</span>
            </a>
        </div>
    </aside>

    <!-- Main Content wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Abstract Background element -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-bb-primary opacity-5 blur-[150px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-bb-tertiary opacity-5 blur-[150px] rounded-full pointer-events-none -z-10"></div>

        <!-- Topbar -->
        <header class="h-20 glass-panel border-x-0 border-t-0 flex items-center justify-between px-8 z-10">
            <div>
                <h2 class="font-display font-semibold text-xl text-bb-on-surface">@yield('header')</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-bb-primary">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-bb-on-surface-variant">Administrator</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-bb-surface-highest flex items-center justify-center border border-bb-outline-variant">
                    <i class="ph ph-user text-xl text-bb-primary"></i>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit" class="text-bb-on-surface-variant hover:text-bb-primary transition-colors" title="Đăng xuất">
                        <i class="ph ph-sign-out text-2xl"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Viewport -->
        <main class="flex-1 overflow-y-auto p-8 relative z-0">
            @yield('content')
        </main>
    </div>

    <!-- Toast Notifications -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#2a2a2a',
            color: '#e5e2e1',
            iconColor: '#f2ca50'
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
