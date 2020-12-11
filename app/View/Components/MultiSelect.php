<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultiSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $items;
    public $label;
    public $parameter;
    public $placeholder;
    public $modifiers;
    public $entity;

    public function __construct($items, $label, $parameter, $placeholder, $modifiers, $entity)
    {
        $this->items = $items;
        $this->label = $label;
        $this->parameter = $parameter;
        $this->placeholder = $placeholder;
        $this->modifiers = $modifiers;
        $this->entity = $entity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.multi-select');
    }
}
