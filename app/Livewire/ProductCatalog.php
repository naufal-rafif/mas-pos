<?php

namespace App\Livewire;

use Livewire\Component;

class ProductCatalog extends Component
{
    public $selectedCategory = null;
    public $cart = [];
    public $totalBill = 0;

    protected $listeners = ['categorySelected', 'addToCart', 'removeFromCart'];

    public function mount()
    {
        // Initialize cart from session if exists
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function categorySelected($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->dispatch('category-changed');
    }

    public function addToCart($productId)
    {
        $product = \App\Models\Product::find($productId);
        if (!$product) return;

        $this->cart[] = [
            'id' => $productId,
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => 1
        ];

        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->dispatch('cart-updated');
    }

    private function calculateTotal()
    {
        $this->totalBill = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.product-catalog', [
            'categories' => \App\Models\Category::all(),
            'products' => $this->selectedCategory 
                ? \App\Models\Product::where('category_id', $this->selectedCategory)->get()
                : \App\Models\Product::all()
        ]);
    }
}