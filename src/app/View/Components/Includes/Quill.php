<?php

namespace App\View\Components\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Quill extends Component
{
    public string $key;
    public string $label;
    public ?string $value;
    /**
     * Create a new component instance.
     */
    public function __construct($key, $label, $value)
    {
        $this->key = $key;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.includes.quill');
    }
}