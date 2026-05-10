<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteBox | The Dark Atelier</title>
    
    <!-- Fonts: Epilogue & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;600;800&family=Manrope:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- 10 Libraries for UI/UX -->
    <!-- 1. Tailwind CSS (Customized via arbitrary values to match design system) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- 2. GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <!-- 3. Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <!-- 4. AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- 5. Lenis Smooth Scroll -->
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
    <!-- 6. Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- 7. SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- 8. Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <!-- 9. Rellax (Parallax) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.0/rellax.min.js"></script>
    <!-- 10. Three.js (for ambient background effects) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <!-- Tailwind Config to match The Dark Atelier -->
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
                    },
                    letterSpacing: {
                        tighter: '-0.02em',
                        widest: '0.05em',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --surface: #131313;
            --surface-low: #1c1b1b;
            --surface-high: #2a2a2a;
            --surface-highest: #353534;
            --primary: #f2ca50;
            --primary-container: #d4af37;
            --on-surface: #e5e2e1;
        }
        
        body {
            background-color: var(--surface);
            color: var(--on-surface);
            font-family: 'Manrope', sans-serif;
            overflow-x: hidden;
            cursor: none;
        }

        /* Custom Cursor */
        #cursor-dot {
            width: 8px;
            height: 8px;
            background-color: var(--primary);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: width 0.3s cubic-bezier(0.25, 1, 0.5, 1), height 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }
        #cursor-ring {
            width: 40px;
            height: 40px;
            border: 1px solid var(--primary);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
            transition: width 0.3s cubic-bezier(0.25, 1, 0.5, 1), height 0.3s cubic-bezier(0.25, 1, 0.5, 1), background-color 0.3s, border-color 0.3s;
        }

        @media (max-width: 768px) {
            body { cursor: auto; }
            #cursor-dot, #cursor-ring { display: none !important; }
        }

        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Epilogue', sans-serif;
            letter-spacing: -0.02em;
        }

        /* Glassmorphism */
        .glass-nav {
            background: rgba(19, 19, 19, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Gold Lustre Gradient */
        .gold-lustre {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
            color: #3c2f00;
        }

        /* Ambient Shadows */
        .ambient-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Ghost Border */
        .ghost-border {
            border: 1px solid rgba(77, 70, 53, 0.2);
        }
        
        .ghost-border-bottom {
            border-bottom: 1px solid rgba(77, 70, 53, 0.2);
        }

        /* Hide scrollbar for clean look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--surface);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--surface-highest);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-container);
        }

        canvas#bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            opacity: 0.3;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased selection:bg-bb-primary selection:text-bb-surface overflow-x-hidden">

    <!-- Custom Cursor -->
    <div id="cursor-dot"></div>
    <div id="cursor-ring"></div>

    <!-- Global Preloader -->
    <div id="global-loader" class="fixed inset-0 z-[100] bg-bb-surface flex flex-col items-center justify-center">
        <canvas id="loader-canvas" class="absolute inset-0 pointer-events-none"></canvas>
        <h2 class="relative z-10 font-display font-bold text-4xl text-bb-primary tracking-widest mt-20" id="loader-text">
            BYTEBOX.
        </h2>
        <div class="relative z-10 w-48 h-[2px] bg-bb-surface-highest mt-6 overflow-hidden">
            <div id="loader-progress" class="h-full bg-bb-primary w-0"></div>
        </div>
    </div>

    <canvas id="bg-canvas"></canvas>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center group">
                <!-- BẠN CÓ THỂ CHỈNH KÍCH THƯỚC LOGO TẠI ĐÂY: 
                     - h-10: Chiều cao (có thể đổi thành h-12, h-16, h-8...)
                     - w-auto: Chiều rộng tự động co giãn theo tỷ lệ
                     - object-contain: Giữ nguyên tỷ lệ ảnh không bị méo 
                     - -ml-2: Điều chỉnh dịch chuyển vị trí qua trái/phải nếu cần
                -->
                <img src="{{ asset('logola.png') }}" alt="ByteBox Logo" class="h-20 w-auto object-contain group-hover:opacity-80 transition-opacity">
            </a>
            
            <div class="hidden md:flex space-x-8 items-center font-body text-sm uppercase tracking-widest text-bb-on-surface-variant">
                <a href="{{ route('home') }}" class="hover:text-bb-primary transition-colors">Trang chủ</a>
                <a href="{{ route('categories.index') }}" class="hover:text-bb-primary transition-colors">Danh mục</a>
                <a href="{{ route('explore') }}" class="hover:text-bb-primary transition-colors">Khám phá</a>
            </div>

            <div class="flex items-center space-x-6">
                <button id="searchTrigger" class="hover:text-bb-primary transition-colors">
                    <i class="ph ph-magnifying-glass text-2xl"></i>
                </button>
                <a href="{{ route('cart.index') }}" class="relative hover:text-bb-primary transition-colors group">
                    <i class="ph ph-shopping-bag text-2xl"></i>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-bb-primary text-bb-surface text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                @auth
                    <div class="relative group cursor-pointer">
                        <div class="flex items-center space-x-2">
                            <i class="ph ph-user-circle text-2xl"></i>
                            <span class="text-sm font-body hidden md:block">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-bb-surface-high ambient-shadow opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 py-2">
                            <a href="{{ route('orders.index') }}" class="block w-full text-left px-4 py-2 hover:bg-bb-surface-highest transition-colors text-sm font-body">Đơn hàng</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-bb-surface-highest transition-colors text-sm font-body">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-body uppercase tracking-widest hover:text-bb-primary transition-colors hidden md:block">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pt-24 pb-20">
        @yield('content')
    </main>

    <!-- Search Popup Overlay -->
    <div id="searchOverlay" class="fixed inset-0 z-[60] bg-bb-surface/80 backdrop-blur-md hidden flex-col items-center justify-center opacity-0">
        <button id="closeSearch" class="absolute top-8 right-8 text-bb-on-surface-variant hover:text-bb-primary transition-colors">
            <i class="ph ph-x text-4xl"></i>
        </button>
        <div id="searchContainer" class="w-full max-w-3xl px-6 translate-x-12 opacity-0">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <i class="ph ph-magnifying-glass absolute left-0 top-1/2 -translate-y-1/2 text-3xl text-bb-primary"></i>
                <input type="text" name="q" placeholder="Tìm kiếm siêu phẩm..." 
                    class="w-full bg-transparent border-b-2 border-bb-outline-variant focus:border-bb-primary py-4 pl-12 pr-4 text-3xl font-display font-bold text-bb-on-surface outline-none transition-colors"
                    autocomplete="off" autofocus>
            </form>
            <p class="text-bb-on-surface-variant font-body mt-4 text-center">Nhấn Enter để tìm kiếm</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-bb-surface-low pt-24 pb-12 mt-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2">
                    <h2 class="font-display font-bold text-4xl mb-6 text-bb-on-surface">ByteBox.</h2>
                    <p class="font-body text-bb-on-surface-variant max-w-sm mb-8 leading-relaxed">
                        Curating the finest technological artifacts. High-end editorial tech experience designed for the avant-garde.
                    </p>
                </div>
                <div>
                    <h3 class="font-body uppercase tracking-widest text-xs text-bb-on-surface mb-6">Khám phá</h3>
                    <ul class="space-y-4 text-bb-on-surface-variant text-sm font-body">
                        <li><a href="#" class="hover:text-bb-primary transition-colors">Bộ sưu tập mới</a></li>
                        <li><a href="#" class="hover:text-bb-primary transition-colors">Sản phẩm nổi bật</a></li>
                        <li><a href="#" class="hover:text-bb-primary transition-colors">Exclusive</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-body uppercase tracking-widest text-xs text-bb-on-surface mb-6">Hỗ trợ</h3>
                    <ul class="space-y-4 text-bb-on-surface-variant text-sm font-body">
                        <li><a href="#" class="hover:text-bb-primary transition-colors">Vận chuyển</a></li>
                        <li><a href="#" class="hover:text-bb-primary transition-colors">Bảo hành</a></li>
                        <li><a href="#" class="hover:text-bb-primary transition-colors">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t ghost-border-bottom pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-bb-on-surface-variant font-body">
                <p>&copy; 2026 ByteBox Atelier. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-bb-primary transition-colors text-lg"><i class="ph ph-instagram-logo"></i></a>
                    <a href="#" class="hover:text-bb-primary transition-colors text-lg"><i class="ph ph-twitter-logo"></i></a>
                </div>
            </div>
        </div>
        <!-- Abstract shape in footer -->
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-bb-primary-container rounded-full blur-[120px] opacity-10"></div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        // 1. Initialize Lenis (Smooth Scroll)
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 1,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // 2. Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50,
        });

        // 3. Initialize Rellax
        if(document.querySelector('.rellax')) {
            var rellax = new Rellax('.rellax', {
                speed: -2,
                center: false,
                wrapper: null,
                round: true,
                vertical: true,
                horizontal: false
            });
        }

        // 4. Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.style.paddingTop = '1rem';
                nav.style.paddingBottom = '1rem';
                nav.style.background = 'rgba(19, 19, 19, 0.85)';
            } else {
                nav.style.paddingTop = '1.5rem';
                nav.style.paddingBottom = '1.5rem';
                nav.style.background = 'rgba(19, 19, 19, 0.7)';
            }
        });

        // 5. SweetAlert2 Toasts for session messages
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#2a2a2a',
            color: '#e5e2e1',
            iconColor: '#f2ca50',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif

        // 6. Interactive Fluid Smoke & Nebula Trail Effect
        const canvas = document.getElementById('bg-canvas');
        const ctx = canvas.getContext('2d');
        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        const particles = [];
        const sparkles = [];
        
        // Generate pre-rendered soft smoke textures
        const createSmokeTexture = (r, g, b, alphaStr) => {
            const sc = document.createElement('canvas');
            sc.width = 120; sc.height = 120;
            const sCtx = sc.getContext('2d');
            const grad = sCtx.createRadialGradient(60, 60, 0, 60, 60, 60);
            grad.addColorStop(0, `rgba(${r},${g},${b}, ${alphaStr})`);
            grad.addColorStop(0.4, `rgba(${r},${g},${b}, ${parseFloat(alphaStr)*0.6})`);
            grad.addColorStop(1, 'rgba(0,0,0, 0)');
            sCtx.fillStyle = grad;
            sCtx.fillRect(0, 0, 120, 120);
            return sc;
        };

        const blackSmoke = createSmokeTexture(5, 5, 5, '0.6'); // Pure dark shadow
        const greySmoke = createSmokeTexture(40, 40, 40, '0.3'); // Lighter volume
        const goldSmoke = createSmokeTexture(242, 202, 80, '0.15'); // Nebula dust

        class SmokeParticle {
            constructor(x, y) {
                // Spawn strictly around the path
                this.x = x + (Math.random() - 0.5) * 10;
                this.y = y + (Math.random() - 0.5) * 10;
                this.size = Math.random() * 60 + 60; // 60 to 120px
                this.angle = Math.random() * Math.PI * 2;
                this.spin = (Math.random() - 0.5) * 0.05;
                // Barely moves, creating a static trail that dissipates
                this.speedX = (Math.random() - 0.5) * 0.3;
                this.speedY = (Math.random() - 0.5) * 0.3;
                this.life = 1.0;
                this.decay = Math.random() * 0.015 + 0.01; // Fade speed

                const rand = Math.random();
                if(rand > 0.85) this.texture = goldSmoke;
                else if(rand > 0.4) this.texture = greySmoke;
                else this.texture = blackSmoke;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.angle += this.spin;
                this.size += 0.5; // Slowly expand
                this.life -= this.decay;
            }
            draw(ctx) {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.angle);
                ctx.globalAlpha = Math.max(0, this.life);
                ctx.drawImage(this.texture, -this.size/2, -this.size/2, this.size, this.size);
                ctx.restore();
            }
        }

        class SparkleParticle {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.size = Math.random() * 2.5 + 0.5; 
                // Explode outwards slightly
                this.speedX = (Math.random() - 0.5) * 4;
                this.speedY = (Math.random() - 0.5) * 4;
                this.life = 1.0;
                this.decay = Math.random() * 0.02 + 0.015;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.speedX *= 0.92; // Friction slows them down
                this.speedY *= 0.92;
                this.life -= this.decay;
            }
            draw(ctx) {
                ctx.save();
                ctx.globalAlpha = Math.max(0, this.life);
                ctx.fillStyle = '#f2ca50';
                ctx.shadowBlur = 10;
                ctx.shadowColor = '#f2ca50';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        }

        let lastMouseX = width / 2;
        let lastMouseY = height / 2;
        let isFirstMove = true;

        document.addEventListener('mousemove', (e) => {
            const currentX = e.clientX;
            const currentY = e.clientY;
            
            if(isFirstMove) {
                lastMouseX = currentX;
                lastMouseY = currentY;
                isFirstMove = false;
            }

            const dx = currentX - lastMouseX;
            const dy = currentY - lastMouseY;
            const dist = Math.sqrt(dx*dx + dy*dy);
            
            // Interpolate particles to create a continuous unbroken ribbon
            const steps = Math.max(1, Math.floor(dist / 8)); 
            for(let i = 0; i < steps; i++) {
                const px = lastMouseX + dx * (i / steps);
                const py = lastMouseY + dy * (i / steps);
                particles.push(new SmokeParticle(px, py));
                
                // Spawn Nebula Sparkles occasionally
                if (Math.random() > 0.6) {
                    sparkles.push(new SparkleParticle(px, py));
                    sparkles.push(new SparkleParticle(px, py));
                }
            }
            
            lastMouseX = currentX;
            lastMouseY = currentY;
        });

        const animateSmoke = () => {
            requestAnimationFrame(animateSmoke);
            ctx.clearRect(0, 0, width, height);
            
            // Draw smoke
            for (let i = particles.length - 1; i >= 0; i--) {
                const p = particles[i];
                p.update();
                p.draw(ctx);
                if (p.life <= 0) particles.splice(i, 1);
            }
            
            // Draw sparkles on top
            for (let i = sparkles.length - 1; i >= 0; i--) {
                const s = sparkles[i];
                s.update();
                s.draw(ctx);
                if (s.life <= 0) sparkles.splice(i, 1);
            }
        };
        animateSmoke();

        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });

        // 7. Search Popup Animation using GSAP
        const searchOverlay = document.getElementById('searchOverlay');
        const searchTrigger = document.getElementById('searchTrigger');
        const closeSearch = document.getElementById('closeSearch');
        const searchContainer = document.getElementById('searchContainer');
        const searchInput = searchContainer.querySelector('input');

        let searchAnim = gsap.timeline({ paused: true })
            .set(searchOverlay, { display: 'flex' })
            .to(searchOverlay, { opacity: 1, duration: 0.3, ease: 'power2.out' })
            .to(searchContainer, { opacity: 1, x: 0, duration: 0.4, ease: 'back.out(1.7)' }, "-=0.1");

        searchTrigger.addEventListener('click', () => {
            searchAnim.play();
            setTimeout(() => searchInput.focus(), 400);
        });

        closeSearch.addEventListener('click', () => {
            searchAnim.reverse();
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && searchOverlay.style.display === 'flex') {
                searchAnim.reverse();
            }
        });

        // 8. Global Preloader with Three.js
        const initLoader = () => {
            const loaderContainer = document.getElementById('global-loader');
            if (!loaderContainer) return;
            
            // Temporary disable scroll
            document.body.style.overflow = 'hidden';
            
            const lScene = new THREE.Scene();
            const lCamera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const lRenderer = new THREE.WebGLRenderer({ canvas: document.getElementById('loader-canvas'), alpha: true, antialias: true });
            lRenderer.setSize(window.innerWidth, window.innerHeight);
            
            // Create an Icosahedron (Tech gem shape) wireframe
            const lGeo = new THREE.IcosahedronGeometry(2, 1);
            const lMat = new THREE.MeshBasicMaterial({ 
                color: 0xf2ca50, // Gold primary
                wireframe: true,
                transparent: true,
                opacity: 0.3
            });
            const lMesh = new THREE.Mesh(lGeo, lMat);
            lScene.add(lMesh);
            lCamera.position.z = 5;
            
            let lAnimId;
            const lAnimate = () => {
                lAnimId = requestAnimationFrame(lAnimate);
                lMesh.rotation.x += 0.01;
                lMesh.rotation.y += 0.015;
                lRenderer.render(lScene, lCamera);
            };
            lAnimate();

            // Fake progress animation combining with actual load
            gsap.to('#loader-progress', {
                width: '100%',
                duration: 1.5,
                ease: 'power2.inOut'
            });

            // On load, fade out the preloader
            window.addEventListener('load', () => {
                // Ensure it shows for at least a short duration for the premium feel
                setTimeout(() => {
                    gsap.to(loaderContainer, {
                        opacity: 0,
                        duration: 0.8,
                        ease: 'power2.inOut',
                        onComplete: () => {
                            loaderContainer.style.display = 'none';
                            document.body.style.overflow = ''; // Restore scroll
                            cancelAnimationFrame(lAnimId);
                            lGeo.dispose();
                            lMat.dispose();
                            lRenderer.dispose();
                        }
                    });
                }, 800);
            });
            
            window.addEventListener('resize', () => {
                if(loaderContainer.style.display !== 'none') {
                    lCamera.aspect = window.innerWidth / window.innerHeight;
                    lCamera.updateProjectionMatrix();
                    lRenderer.setSize(window.innerWidth, window.innerHeight);
                }
            });
        };
        initLoader();

        // 9. Premium Custom Cursor & Magnetic Effect
        const cursorDot = document.getElementById('cursor-dot');
        const cursorRing = document.getElementById('cursor-ring');
        
        if (window.innerWidth > 768 && cursorDot && cursorRing) {
            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            let ringX = mouseX;
            let ringY = mouseY;
            
            window.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursorDot.style.left = mouseX + 'px';
                cursorDot.style.top = mouseY + 'px';
            });
            
            const renderCursor = () => {
                ringX += (mouseX - ringX) * 0.15; // Smooth trailing
                ringY += (mouseY - ringY) * 0.15;
                cursorRing.style.left = ringX + 'px';
                cursorRing.style.top = ringY + 'px';
                requestAnimationFrame(renderCursor);
            };
            renderCursor();
            
            // Re-apply cursor interactions when DOM changes (e.g., links inside Swiper)
            const applyCursorInteractions = () => {
                const interactables = document.querySelectorAll('a, button, input, select, .cursor-pointer, .swiper-button-next, .swiper-button-prev, .swiper-pagination-bullet');
                interactables.forEach(el => {
                    // Prevent multiple event listeners
                    if(el.dataset.cursorBound) return;
                    el.dataset.cursorBound = "true";

                    el.addEventListener('mouseenter', () => {
                        cursorDot.style.width = '0px';
                        cursorDot.style.height = '0px';
                        cursorRing.style.width = '60px';
                        cursorRing.style.height = '60px';
                        cursorRing.style.backgroundColor = 'rgba(242, 202, 80, 0.1)';
                        cursorRing.style.borderColor = 'rgba(242, 202, 80, 0.5)';
                    });
                    el.addEventListener('mouseleave', () => {
                        cursorDot.style.width = '8px';
                        cursorDot.style.height = '8px';
                        cursorRing.style.width = '40px';
                        cursorRing.style.height = '40px';
                        cursorRing.style.backgroundColor = 'transparent';
                        cursorRing.style.borderColor = 'var(--primary)';
                    });
                });

                // Magnetic Button effect using GSAP
                const magneticElements = document.querySelectorAll('button, .magnetic');
                magneticElements.forEach(el => {
                    if(el.dataset.magneticBound) return;
                    el.dataset.magneticBound = "true";
                    
                    el.addEventListener('mousemove', (e) => {
                        const rect = el.getBoundingClientRect();
                        const x = e.clientX - rect.left - rect.width / 2;
                        const y = e.clientY - rect.top - rect.height / 2;
                        
                        gsap.to(el, {
                            x: x * 0.2, // Move 20% towards mouse
                            y: y * 0.2,
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                    });
                    
                    el.addEventListener('mouseleave', () => {
                        gsap.to(el, {
                            x: 0,
                            y: 0,
                            duration: 0.7,
                            ease: 'elastic.out(1, 0.3)'
                        });
                    });
                });
            };
            
            applyCursorInteractions();
            // Optional: call applyCursorInteractions() after ajax or dynamic content load
        }
    </script>
    
    @auth
        @php
            function getRecommendationPopup($user) {
                if (!$user->date_of_birth || !$user->gender) return null;
                $age = \Carbon\Carbon::parse($user->date_of_birth)->age;
                
                // 1. Nam từ 20-30 tuổi
                if ($user->gender === 'male' && $age >= 20 && $age <= 30) {
                    return [
                        'title' => 'Dành riêng cho phái mạnh!',
                        'product' => 'Sonic Prism Soundbar',
                        'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?q=80&w=600&auto=format&fit=crop',
                        'desc' => 'Trải nghiệm âm thanh cực đỉnh nâng tầm không gian sống của bạn.',
                        'url' => route('explore')
                    ];
                }
                // 2. Nữ từ 18-25 tuổi
                if ($user->gender === 'female' && $age >= 18 && $age <= 25) {
                    return [
                        'title' => 'Góc làm việc thêm xinh!',
                        'product' => 'Bàn phím cơ Pastel',
                        'image' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?q=80&w=600&auto=format&fit=crop',
                        'desc' => 'Làm việc năng suất hơn với set bàn phím màu sắc trẻ trung.',
                        'url' => route('explore')
                    ];
                }
                // 3. Nam từ 31-45 tuổi
                if ($user->gender === 'male' && $age >= 31 && $age <= 45) {
                    return [
                        'title' => 'Đẳng cấp không gian làm việc',
                        'product' => 'ErgoChair Pro V2',
                        'image' => 'https://images.unsplash.com/photo-1505843490538-5133c6c7d0e1?q=80&w=600&auto=format&fit=crop',
                        'desc' => 'Bảo vệ cột sống và mang lại sự thoải mái trong những giờ làm việc căng thẳng.',
                        'url' => route('explore')
                    ];
                }
                // 4. Các độ tuổi / giới tính khác (Mặc định)
                return [
                    'title' => 'Gợi ý hot tuần này!',
                    'product' => 'Tai nghe không dây Max Pods',
                    'image' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?q=80&w=600&auto=format&fit=crop',
                    'desc' => 'Sản phẩm bán chạy nhất, phù hợp cho mọi phong cách.',
                    'url' => route('explore')
                ];
            }

            $popupContent = getRecommendationPopup(auth()->user());
        @endphp

        @if($popupContent && session()->missing('has_seen_demographic_popup'))
            <!-- Demographic Recommendation Popup -->
            <div id="demographic-popup" class="fixed inset-0 z-[100] flex items-center justify-center bg-bb-surface/80 backdrop-blur-sm opacity-0" style="display: none;">
                <div class="relative w-[90%] max-w-md rounded-2xl bg-bb-surface-high p-8 shadow-2xl text-center ambient-shadow ghost-border transform scale-95" id="demographic-popup-content">
                    <button onclick="closeDemographicPopup()" class="absolute top-4 right-4 text-bb-on-surface-variant hover:text-bb-primary transition text-2xl">
                        <i class="ph ph-x"></i>
                    </button>
                    <h2 class="text-2xl font-display font-bold text-bb-primary mb-4">{{ $popupContent['title'] }}</h2>
                    <div class="relative overflow-hidden rounded-xl mb-6 group">
                        <img src="{{ $popupContent['image'] }}" alt="{{ $popupContent['product'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-bb-surface-highest to-transparent opacity-60"></div>
                    </div>
                    <h3 class="text-xl font-display font-bold text-bb-on-surface mb-2">{{ $popupContent['product'] }}</h3>
                    <p class="text-sm text-bb-on-surface-variant font-body mb-8 leading-relaxed">{{ $popupContent['desc'] }}</p>
                    <a href="{{ $popupContent['url'] }}" onclick="closeDemographicPopup()" class="inline-block w-full rounded-full gold-lustre px-8 py-3 text-sm tracking-widest uppercase font-bold text-bb-surface hover:opacity-90 transition transform hover:scale-105">
                        Xem chi tiết ngay
                    </a>
                </div>
            </div>
            
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    setTimeout(() => {
                        const popup = document.getElementById('demographic-popup');
                        const popupContent = document.getElementById('demographic-popup-content');
                        popup.style.display = 'flex';
                        gsap.to(popup, { opacity: 1, duration: 0.4 });
                        gsap.to(popupContent, { scale: 1, duration: 0.5, ease: 'back.out(1.5)' });
                    }, 2000); // Hiện popup sau 2 giây
                });

                function closeDemographicPopup() {
                    const popup = document.getElementById('demographic-popup');
                    const popupContent = document.getElementById('demographic-popup-content');
                    gsap.to(popupContent, { scale: 0.95, duration: 0.3, ease: 'power2.in' });
                    gsap.to(popup, { opacity: 0, duration: 0.3, onComplete: () => { popup.style.display = 'none'; } });
                }
            </script>
            
            @php
                session()->put('has_seen_demographic_popup', true);
            @endphp
        @endif
    @endauth

    @stack('scripts')
</body>
</html>
