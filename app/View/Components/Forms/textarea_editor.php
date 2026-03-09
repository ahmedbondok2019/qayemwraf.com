<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class textarea_editor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;

    public $value;

    public $trans;

    public function __construct($name, $value, $trans)
    {
        $this->name = $name;
        $this->value = $value;
        $this->trans = $trans;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.textarea_editor');
    }
}
