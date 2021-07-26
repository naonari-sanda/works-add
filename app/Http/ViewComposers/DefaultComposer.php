<?php
namespace App\Http\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DefaultComposer
{
    /**
    * @var String
    */
    private $ip;
     
    public function __construct(Request $request)
    {
        $this->ip = $request->ip();
    }
     
    /**
    * Bind data to the view.
    * @param View $view
    * @return void
    */
    public function compose(View $view)
    {
        $view->with('ip', $this->ip);
    }
}
