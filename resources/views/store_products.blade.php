<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name }} - Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body 
    class="min-h-screen p-10" 
    style="
        background-color: {{ $themeSettings['background_color'] ?? '#f9fafb' }};
        color: {{ $themeSettings['font_color'] ?? '#111827' }};
        font-size: {{ $themeSettings['font_size'] ?? '16px' }};
        font-family: {{ $themeSettings['font_name'] ?? 'sans-serif' }};
    "
>
    <h1 class="text-3xl font-bold mb-6">{{ $store->name }} - Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($store->products as $product)
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="mt-2">{{ $product->description }}</p>
                <p class="mt-2 font-bold">₹{{ $product->price }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>