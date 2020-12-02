<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tuto;
use App\Models\Conference;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sitemap = App::make("sitemap");
        $sitemap->add(URL::to('/'), Carbon::now(), '1.0', 'daily');

        $conferences = Conference::where('is_valid', 1)->orderBy('id', 'desc')->get();
        foreach ($conferences as $conf) {
            $sitemap->add(URL::to('/') . '/conference/' . $conf->slug, $conf->updated_at ? : Carbon::now(), '0.8', 'monthly');
        }

        $tutos = Tuto::where('is_valid', 1)->orderBy('id', 'desc')->get();
        foreach ($tutos as $tuto) {
            $sitemap->add(URL::to('/') . '/tuto/' . $tuto->slug, $tuto->updated_at, '0.8', 'monthly');
        }
        $sitemap->store('xml', 'sitemap');
    }
}
