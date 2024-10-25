<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Card extends Component
{
    public $title;
    public $imageUrl;
    public $category;
    public $price;

    public function mount($title, $imageUrl = null, $category, $price)
    {
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->category = $category;
        $this->price = $price;
    }
    public function render()
    {
        return view('livewire.components.card');
    }
}
