<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shopify')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="min-h-screen p-10" 
    style="
        background-color: {{ $themeSettings['background_color'] ?? '#f9fafb' }};
        color: {{ $themeSettings['font_color'] ?? '#111827' }};
        font-size: {{ $themeSettings['font_size'] ?? '16px' }};
        font-family: {{ $themeSettings['font_name'] ?? 'sans-serif' }};
    ">

    
    <header class="bg-white shadow-md sticky top-0 z-10">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a class="text-2xl font-bold text-gray-800" href="{{ route('customerDashboard') }}">
                Shopify
            </a>
            <div class="flex items-center space-x-5">
                <a href="{{ route('cart') }}" class="relative text-gray-600 hover:text-blue-500 transition">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="cart-count" class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-1 rounded-full">0</span>
                </a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">
                    <i class="fas fa-heart"></i>
                </a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">
                    <i class="fas fa-star"></i>
                </a>
                <button id="logout-button" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition font-semibold">Logout</button>
            </div>
        </nav>
    </header>

    
    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <script>
        
        function addToCart(id, name, price) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let existing = cart.find(item => item.id === id);

            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            alert(name + " added to cart!");
        }

       
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cart-count').innerText = cart.length;
        }

        
        function removeFromCart(id) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.filter(item => item.id !== id);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            if (typeof renderCart === "function") renderCart(); 
        }

       
        function getWithExpiry(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) return null;
            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        }

        document.getElementById('logout-button').addEventListener('click', function() {
            const token = getWithExpiry('token');
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
            })
            .finally(() => {
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        });

        
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>

    @yield('scripts')
</body>
</html>
