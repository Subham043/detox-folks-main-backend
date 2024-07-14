<?php

namespace App\View\Components\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public string $link;
    public ?int $id;
    public string $route;
    /**
     * Create a new component instance.
     */
    public function __construct($link, $id = null)
    {
        $this->link = $link;
        $this->id = $id;
        $this->route = route($link, $id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.includes.back-button');
    }
}
