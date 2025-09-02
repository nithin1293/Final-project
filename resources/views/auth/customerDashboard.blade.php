@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Stores</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($stores as $store)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h2>
                    <p class="text-gray-600 mt-2 mb-4">{{ $store->description }}</p>
                    <a href="{{ route('dashboard.store.view', ['id' => $store->id]) }}"
                       class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                        View Products
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
