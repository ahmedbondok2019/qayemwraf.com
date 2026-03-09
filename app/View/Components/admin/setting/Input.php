<?php

namespace App\View\Components\admin\setting;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $field;

    public $value;

    public $trans;

    public $col;

    public function __construct($field, $value, $trans, $col)
    {
        $this->field = $field;
        $this->value = $value;
        $this->trans = $trans;
        $this->col = $col;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.setting.input');
    }
}
