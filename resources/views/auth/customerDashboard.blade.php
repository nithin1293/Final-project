<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header Section -->
    <header class="bg-white shadow-md sticky top-0 z-10">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a class="text-2xl font-bold text-gray-800" href="{{ route('customerDashboard') }}">
                ShopSphere
            </a>
            <div class="flex items-center space-x-5">
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="hidden md:inline ml-1">Cart</span>
                </a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">
                    <i class="fas fa-heart"></i>
                    <span class="hidden md:inline ml-1">Wishlist</span>
                </a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">
                    <i class="fas fa-star"></i>
                    <span class="hidden md:inline ml-1">Favourites</span>
                </a>
                <button id="logout-button" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition font-semibold">Logout</button>
            </div>
        </nav>
    </header>

    <!-- Main Content: Store Grid -->
    <main class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Discover Our Stores</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($stores as $store)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h2>
                        <p class="text-gray-600 mt-2 mb-4">{{ $store->description }}</p>
                        <a href="{{ route('dashboard.store.view', ['id' => $store->id]) }}" class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                            View Products
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <script>
        /**
         * Retrieves an item from localStorage that was stored with an expiry time.
         * @param {string} key The key of the item to retrieve.
         * @returns {string|null} The value of the item, or null if it's expired or doesn't exist.
         */
        function getWithExpiry(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) {
                return null;
            }
            const item = JSON.parse(itemStr);
            const now = new Date();
            // Check if the item has expired
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        }

        // Event listener for the logout button
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
            .then(response => {
                // Always remove token and redirect, regardless of API response
                localStorage.removeItem('token');
                window.location.href = '/login';
            })
            .catch(error => {
                console.error('Error during logout:', error);
                // Still remove token and redirect on error
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        });
    </script>
</body>
</html>
