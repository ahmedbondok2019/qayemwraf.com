<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;

    public $value;

    public $trans;

    public $dataArray;

    public $field;

    public function __construct($name, $value, $trans, $dataArray, $field)
    {
        $this->name = $name;
        $this->value = $value;
        $this->trans = $trans;
        $this->dataArray = $dataArray;
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
