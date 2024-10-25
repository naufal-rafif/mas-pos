<div class="bg-white shadow rounded-[10px] flex flex-col" data-category="{{ $category }}">
    @if($imageUrl)
        <img class="w-full h-48 object-cover rounded-[10px]" src="{{ $imageUrl }}" alt="{{ $title }}">
    @endif
    <div class="flex justify-between px-4 py-5 sm:p-6">
        <div class="flex flex-col gap-2">
            <h3 class="text-sm leading-4 text-black">
                {{ $title }}
            </h3>
            <p class="text-black text-base font-semibold leading-4">Rp. {{$price}}</p>
        </div>
        <button class="p-2 items-center rounded-[5px] bg-[#DE350B] text-[10px] font-medium text-white h-min hover:bg-[#de0b0b]">Delete</button>
    </div>
    <div class="self-center px-5 pb-5">
        <button class="text-white bg-[#0052CC] rounded-[3px] text-xs flex py-1.5 px-3 justify-center items-center hover:bg-[#0030cc] font-semibold">+ Add to Cart</button>
    </div>
</div>