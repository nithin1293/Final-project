<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Welcome to the Customer Dashboard!</h1>

    <h2 class="text-xl font-semibold mb-2">Available Stores:</h2>

    <div class="grid grid-cols-3 gap-4">
        @foreach($stores as $store)
            <div class="bg-white shadow rounded p-4">
                <h3 class="font-bold text-lg">{{ $store->name }}</h3>
                <p class="text-gray-600">{{ $store->description }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>
