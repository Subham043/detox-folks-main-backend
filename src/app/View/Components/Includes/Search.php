<?php

namespace App\View\Components\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public string $search;
    public string $link;
    public ?int $id;
    public string $route;
    /**
     * Create a new component instance.
     */
    public function __construct($search, $link, $id = null)
    {
        $this->search = $search;
        $this->link = $link;
        $this->id = $id;
        $this->route = route($link, $id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.includes.search');
    }
}