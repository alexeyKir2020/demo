<?php
namespace App\Http\ViewComposers;
use Illuminate\Support\Facades\Lang;

class OrganisationsComposer
{
    public function compose($view)
    {
        $organisations = Lang::get("organisations");

        $view->with('organisations', $organisations);
    }
}
