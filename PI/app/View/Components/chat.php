<?php

namespace App\View\Components;

use Illuminate\View\Component;

class chat  extends Component
{
    public $id;
    public $title;

    public function __construct($id, $title = null)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.modal');
    }
}