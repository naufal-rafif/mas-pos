<div>
    <div>
        <table class="table-auto w-full text-xl font-semibold">
            <thead class="text-start">
                <tr class="border border-t-0 border-x-0 border-b border-[#D9D9D9]">
                    <th></th>
                    <th class="py-5 text-start">Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Sub Total</th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cart as $index => $item)
                    <tr class="text-center p-8 border-b border-[#D9D9D9]">
                        <td class="py-12 px-4">{{ $index + 1 }}.</td>
                        <td class="text-start py-8">
                            <div class="flex items-center gap-6">
                                <img src="{{ asset('storage/'.$item['image']) }}"
                                    class="w-48 h-48 object-cover rounded" alt="{{ $item['name'] }}">
                                <div class="flex flex-col">
                                    <p>{{ $item['name'] }}</p>
                                    <p>Rp. {{ number_format($item['price']) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex justify-center items-center gap-2">
                                <button wire:click="decreaseQuantity('{{ $item['id'] }}')" 
                                        class="bg-blue-500 hover:bg-[#0052CC] text-white w-10 h-10 rounded-full">
                                    -
                                </button>
                                <input value="{{ $item['quantity'] }}" 
                                       type="number" 
                                       min="1" 
                                       max="10" 
                                       class="w-10 h-10 bg-white rounded-full text-center px-auto" 
                                       disabled>
                                <button wire:click="increaseQuantity('{{ $item['id'] }}')"
                                        class="bg-blue-500 hover:bg-[#0052CC] text-white rounded-full w-10 h-10">
                                    +
                                </button>
                            </div>
                        </td>
                        <td>Rp. {{ number_format($item['price'] * $item['quantity']) }}</td>
                        <td>
                            <button wire:click="removeItem('{{ $item['id'] }}')"
                                    class="bg-[#DE350B] hover:bg-[#de0b0b] text-white px-3 py-2 text-sm rounded-[3px]">
                                Remove Item
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8">
                            Your cart is empty
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        @if(count($cart) > 0)
            <div class="mt-8 border-[#D9D9D9] pt-4">
                <div class="text-xl font-semibold text-right">
                    Total: Rp. {{ number_format($total) }}
                </div>
            </div>
        @endif
    
        <div class="flex justify-end gap-4 mt-5">
            <a href="{{ route('home') }}" wire:navigate
                class="text-[#0052CC] bg-white rounded-[5px] border-2 border-[#0052CC] flex py-5 px-10 justify-center items-center hover:bg-[#dadada] font-semibold">
                Back to Home
            </a>
            <button wire:click="proceedToCheckout"
                class="text-white bg-[#0052CC] rounded-[5px] flex py-5 px-10 justify-center items-center hover:bg-[#0030cc] font-semibold">
                Pay Bill
            </button>
        </div>
    
        {{-- Optional: Add a notification component for alerts --}}
        <div x-data="{ show: false, message: '', type: '' }"
             x-on:show-alert.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => { show = false }, 3000)">
            <div x-show="show"
                 x-transition
                 class="fixed top-4 right-4 p-4 rounded-lg"
                 :class="type === 'error' ? 'bg-red-500' : 'bg-green-500'">
                <p class="text-white" x-text="message"></p>
            </div>
        </div>
    </div>
</div>
