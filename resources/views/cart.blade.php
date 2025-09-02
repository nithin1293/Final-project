@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
    <h1 class="text-3xl font-bold mb-6">My Cart</h1>
    <div id="cart-items" class="space-y-4"></div>

    <!-- Subtotal Section -->
    <div id="cart-summary" class="mt-8 p-4 bg-white rounded-lg shadow text-right hidden">
        <p class="text-lg font-semibold">
            Subtotal (<span id="total-items">0</span> items): 
            <span class="text-green-600 font-bold">₹<span id="total-price">0</span></span>
        </p>
    </div>
@endsection

@section('scripts')
<script>
    function renderCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let container = document.getElementById('cart-items');
        let summary = document.getElementById('cart-summary');
        let totalItemsEl = document.getElementById('total-items');
        let totalPriceEl = document.getElementById('total-price');

        container.innerHTML = '';
        let totalItems = 0;
        let totalPrice = 0;

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-gray-600">Your cart is empty.</p>';
            summary.classList.add('hidden');
            return;
        }

        cart.forEach(item => {
            totalItems += item.quantity;
            totalPrice += item.price * item.quantity;

            container.innerHTML += `
                <div class="p-4 bg-white rounded-lg shadow flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold">${item.name}</h2>
                        <p class="text-gray-600">₹${item.price} x ${item.quantity} = <b>₹${item.price * item.quantity}</b></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="decrementQuantity(${item.id})" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                        <span class="font-semibold">${item.quantity}</span>
                        <button onclick="incrementQuantity(${item.id})" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                        <button onclick="removeFromCart(${item.id})" class="ml-4 text-red-500 hover:text-red-700">Remove</button>
                    </div>
                </div>
            `;
        });

        
        totalItemsEl.textContent = totalItems;
        totalPriceEl.textContent = totalPrice.toLocaleString('en-IN');
        summary.classList.remove('hidden');
    }

    function incrementQuantity(id) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let item = cart.find(p => p.id === id);
        if (item) {
            item.quantity++;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    function decrementQuantity(id) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let item = cart.find(p => p.id === id);
        if (item) {
            item.quantity--;
            if (item.quantity <= 0) {
                cart = cart.filter(p => p.id !== id);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    function removeFromCart(id) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(p => p.id !== id);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    document.addEventListener('DOMContentLoaded', renderCart);
</script>
@endsection
