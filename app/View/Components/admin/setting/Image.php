<?php

namespace App\View\Components\admin\setting;

use Illuminate\View\Component;

class Image extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $field;

    public $trans;

    public $col;

    public $width;

    public $height;

    public function __construct($field, $trans, $col, $width, $height)
    {
        $this->field = $field;
        $this->trans = $trans;
        $this->col = $col;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.setting.image');
    }
}
