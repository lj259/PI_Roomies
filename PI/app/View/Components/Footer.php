<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public $year;
    public $date;

    public function __construct($year = null, $date = null)
    {
        $this->year = $year ?? date('Y'); // Año actual por defecto con PHP
        $this->date = $date ?? date('d \d\e F \d\e\l Y'); // Fecha actual en formato PHP
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
