<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BookCard extends Component
{
    public $name;
    public $coverImage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $coverImage)
    {
        $this->name = $name;
        $this->coverImage = $coverImage; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.book-card');
    }
}
