<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\Tuto;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = App::make("sitemap");

        $sitemap->setCache('laravel.sitemap', 60);
        // dd($sitemap);
        if (!$sitemap->isCached()) {
            $sitemap->add(URL::to('/'), Carbon::now(), '1.0', 'daily');

            $conferences = Conference::where('is_valid', 1)->orderBy('id', 'desc')->get();
            foreach ($conferences as $conf) {
                $sitemap->add(URL::to('/') . '/conference/' . $conf->slug, $conf->updated_at ? : Carbon::now(), '0.8', 'monthly');
            }

            $tutos = Tuto::where('is_valid', 1)->orderBy('id', 'desc')->get();
            foreach ($tutos as $tuto) {
                $sitemap->add(URL::to('/') . '/tuto/' . $tuto->slug, $tuto->updated_at, '0.8', 'monthly');
            }
        }
        return $sitemap->render('xml');
    }
}
