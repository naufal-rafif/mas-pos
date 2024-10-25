<div class="fixed top-0 left-0 flex w-full h-screen justify-center items-center gap-4 flex-col">
    <p class="text-xl font-semibold text-black">Payment Successful</p>
    <div class="checklist">
        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="50" fill="#36B37E" />
            <path
            d="M44.8438 61.7854L34.5312 51.4729L37.4771 48.5271L44.8469 55.8886L44.8438 55.8917L62.5208 38.2146L65.4667 41.1604L47.7896 58.8396L44.8458 61.7833L44.8438 61.7854Z"
            fill="white" />
        </svg>
    </div>
    <p class="text-xl font-semibold text-black">Rp. {{ number_format($total) }}</p>
    <a href="{{ route('home') }}" wire:navigate
        class="text-[#0052CC] bg-white rounded-[5px] text-sm border-2 border-[#0052CC] flex py-3 px-[30px] justify-center items-center hover:bg-[#dadada] font-semibold">
        Back to Home
    </a>
</div>
