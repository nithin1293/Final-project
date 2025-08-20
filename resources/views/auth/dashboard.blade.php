<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white flex flex-col">
        <h2 class="text-2xl font-bold p-6 border-b border-gray-700">Dashboard</h2>

        <nav class="flex flex-col">
            <a href="{{ route('store.view') }}" 
               class="px-6 py-3 hover:bg-gray-700 border-b border-gray-700 text-left">
               Store
            </a>
            <a href="{{ route('theme.view') }}" 
               class="px-6 py-3 hover:bg-gray-700 border-b border-gray-700 text-left">
               Theme
            </a>
            <a href="{{ route('products.view') }}" 
               class="px-6 py-3 hover:bg-gray-700 border-b border-gray-700 text-left">
               Products
            </a>
            <form id="logout-form">
                <button id="logout-button" type="button" 
                        class="w-full px-6 py-3 text-left hover:bg-gray-700 border-b border-gray-700">
                    Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 bg-gray-100">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-700">Welcome to Dashboard</h1>
            <p class="mt-2 text-gray-500">Manage your store, themes, and products easily.</p>
        </div>
    </div>

    <script>
        var token = getWithExpiry('token');

        document.getElementById('logout-button').addEventListener('click', function () {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Logout successful:', data);
                localStorage.removeItem('token');
                window.location.href = '/login';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Logout failed. Please try again.');
            });
        });

        function getWithExpiry(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) {
                window.location.href = '/login';
            }
            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                window.location.href = '/login';
            }
            return item.value;
        }
    </script>
</body>
</html>
