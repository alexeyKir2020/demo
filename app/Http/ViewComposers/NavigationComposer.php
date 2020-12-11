<?php
namespace App\Http\ViewComposers;
use Illuminate\Support\Facades\Lang;

class NavigationComposer
{
    public function compose($view)
    {
        $headerMenu = Lang::get("header.menu");
        $footerMenu = Lang::get("footer.menu");
        $footerSocial = Lang::get("footer.social.links");

        $view->with('headerMenu', $headerMenu)->with('footerMenu', $footerMenu)->with('footerSocialLinks', $footerSocial);
    }
}
