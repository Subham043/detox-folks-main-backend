<?php

namespace App\View\Components\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $list;
    public string $page;
    public string $link;
    public ?int $id;
    public string $route;
    /**
     * Create a new component instance.
     */
    public function __construct($list, $page, $link, $id = null)
    {
        $this->list = $list;
        $this->page = $page;
        $this->link = $link;
        $this->id = $id;
        $this->route = route($link, $id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.includes.breadcrumb');
    }
}