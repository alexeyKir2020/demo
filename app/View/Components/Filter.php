<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Filter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $filters;
    public $entity;

    public function __construct($filters, $entity)
    {
        $this->filters = $filters;
        $this->entity = $entity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        //ddd($this->filters);
        return view('components.filter');
    }
}
