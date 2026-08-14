<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchBox extends Component
{
    public function __construct(
        public string $placeholder = 'Search...'
    ) {
    }

    public function render()
    {
        return view('components.search-box');
    }
}
