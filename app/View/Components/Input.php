<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $model;
    public $label;
    public $placeholder;
    public $type;
    public $required;

    public function __construct($model, $label, $placeholder = null, $type = 'text', $required = false)
    {
        $this->model = $model;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.input');
    }
}
