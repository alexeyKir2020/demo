<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckGroup extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $items;
    public $label;
    public $parameter;

    public function __construct($items, $label, $parameter)
    {
        $this->items = $items;
        $this->label = $label;
        $this->parameter = $parameter;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.check-group');
    }
}
