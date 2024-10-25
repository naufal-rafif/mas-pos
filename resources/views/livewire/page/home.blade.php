<div>
    <div class="relative px-4 xl:px-0">
        <div class="pt-8 pb-3 flex justify-end gap-3">
                <a href="{{ route('filament.dashboard.resources.categories.index') }}" class="bg-blue-100 text-[#0052CC] rounded-[3px] flex py-2.5 px-5 justify-center items-center hover:bg-blue-200 font-semibold">+ Add Category</a>
         
                <a href="{{ route('filament.dashboard.resources.products.index') }}" class="bg-blue-100 text-[#0052CC] rounded-[3px] flex py-2.5 px-5 justify-center items-center hover:bg-blue-200 font-semibold">+ Add Products</a>
            <a 
                href="{{route('cart')}}"
                wire:navigate
                data-cart-button
                class="text-white bg-[#0052CC] rounded-[3px] flex py-2.5 px-5 justify-center items-center hover:bg-[#0030cc] font-semibold"
                x-on:click="$dispatch('toggle-cart')"
            >
                Cart ({{ count($cart) }})
            </a>
        </div>

        <div class="flex items-center justify-start gap-4" id="category">
            @foreach ($categories as $index => $category)
                <div 
                    wire:click="categorySelected({{ $category->id }}, {{ $index }})"
                    class="w-32 text-center font-medium py-3 cursor-pointer transition-all duration-300 {{ $selectedCategory === $category->id ? 'active' : '' }}"
                    data-category="{{ $category->id }}"
                    data-index="{{ $index }}"
                >
                    {{ $category->name }}
                </div>
            @endforeach
        </div>

        <div class="relative" id="bar">
            <div class="absolute w-full h-1 bg-[#EBECF0] rounded-full"></div>
            <div 
                class="w-32 border-b-4 border-[#0052CC] rounded-full relative transition-transform duration-300 ease-in-out" 
                id="progressiveBar"
                style="transform: translateX({{ $selectedIndex * 144 }}px)"
            ></div>
        </div>
        <div class="grid gap-6 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 pt-8">
            @foreach($products as $product)
                <div 
                    class="bg-white shadow rounded-[10px] flex flex-col transform transition-all duration-300 hover:scale-105"
                    data-category="{{ $product->category_id }}"
                >
                    @if($product->image)
                        <img class="w-full h-48 object-cover rounded-t-[10px]" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @endif
                    <div class="flex justify-between px-4 py-5 sm:p-6">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-sm leading-4 text-black">{{ $product->name }}</h3>
                            <p class="text-black text-base font-semibold leading-4">Rp. {{ number_format($product->price) }}</p>
                        </div>
                        @if(in_array($product->id, collect($cart)->pluck('id')->toArray()))
                            <button 
                                wire:click="removeFromCart('{{ array_search($product->id, collect($cart)->pluck('id')->toArray()) }}')"
                                class="p-2 items-center rounded-[5px] bg-[#DE350B] text-[10px] font-medium text-white h-min hover:bg-[#de0b0b] transition-colors duration-300"
                            >
                                Remove
                            </button>
                        @endif
                    </div>
                    <div class="self-center px-5 pb-5">
                        <button 
                            wire:click="addToCart({{ $product->id }})"
                            class="text-white bg-[#0052CC] rounded-[3px] text-xs flex py-1.5 px-3 justify-center items-center hover:bg-[#0030cc] font-semibold transition-colors duration-300"
                        >
                            + Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($cart) > 0)
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                class="fixed bottom-8 max-w-7xl mx-auto w-full flex justify-end px-8 xl:px-0"
            >
                <a 
                href="{{route('cart')}}"
                wire:navigate class="text-white bg-[#0052CC] rounded-[10px] flex py-2.5 px-5 justify-center items-center hover:bg-[#0030cc] font-semibold">
                    Total Bill Rp. {{ number_format($totalBill) }}
                </a>
            </div>
        @endif
    </div>
</div>
<script>
    // Add this to your JavaScript file
document.addEventListener('livewire:initialized', () => {
    const categories = document.querySelectorAll("#category > div");
    const bar = document.getElementById("progressiveBar");
    
    // Initialize the bar position based on the active category
    const activeCategory = document.querySelector("#category > div.active");
    if (activeCategory) {
        const index = parseInt(activeCategory.dataset.index);
        bar.style.transform = `translateX(${index * 144}px)`;
    }

    // Optional: Add click handler if you want JavaScript-based animation before Livewire updates
    categories.forEach((category) => {
        category.addEventListener("click", () => {
            const index = parseInt(category.dataset.index);
            bar.style.transform = `translateX(${index * 144}px)`;
        });
    });

    // Listen for Livewire events
    Livewire.on('category-changed', () => {
        // Add slide animation for products
        const products = document.querySelectorAll('.grid > div');
        products.forEach(product => {
            product.style.opacity = '0';
            product.style.transform = 'translateY(20px)';
            setTimeout(() => {
                product.style.opacity = '1';
                product.style.transform = 'translateY(0)';
            }, 300);
        });
    });

    // Cart update animation remains the same
    Livewire.on('cart-updated', () => {
        const cartButton = document.querySelector('[data-cart-button]'); // Using data attribute
        if (cartButton) {
            cartButton.classList.add('animate-bounce');
            setTimeout(() => {
                cartButton.classList.remove('animate-bounce');
            }, 1000);
        }
    });
});
</script>