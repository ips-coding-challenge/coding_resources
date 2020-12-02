<?php

namespace App\Http\Controllers\Web;

use App\Models\Tuto;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $conferences = Conference::customLatest('conferences', $request)->paginate(config('app.api_per_page'));
        return view('web.index');
    }
    // public function about() {
    //     return view('web.about');
    // }

    public function show(Request $request, string $type, $slug)
    {

        $suggestions = [];

        if ($type === 'conference') {
            $data = Conference::with(['categories', 'langue'])->where('is_valid', 1)->where('slug', $slug)->firstOrFail();
            if ($data) {
                $data->type = "conference";
                $suggestions = $this->getSuggestions($request, $type, $data);
                $this->generateSeo($type, $data);
            }
        } else if ($type === 'tuto') {
            $data = Tuto::with(['categories', 'langue', 'tutoParts' => function ($query) {
                $query->orderBy('part_number', 'asc');
            }])->where('is_valid', 1)->where('slug', $slug)->firstOrFail();
            if ($data) {
                $data->type = "tuto";
                $suggestions = $this->getSuggestions($request, $type, $data);
                $this->generateSeo($type, $data);
            }

            // dd($data);
        }

        return view('web.show', compact('data', 'suggestions'));
    }

    public function search(Request $request)
    {
        return view('web.search');
    }

    /** show resource form */
    public function create(Request $request)
    {
        return view('web.create');
    }

    private function getSuggestions(Request $request, $type, $data)
    {

        $suggestions = [];
        $duration = 120; // Minutes
        $categories = $data->categories->pluck('id');
        $request->request->add(['categories' => $categories]);

        if ($type === 'conference') {
            $suggestions = Cache::remember($this->generateCacheKey($type, $data), $duration, function () use ($request) {
                return Conference::filters('conferences', 'App\Models\Conference', $request)->take(6)->get();
            });
        } else if ($type === 'tuto') {
            $suggestions = Cache::remember($this->generateCacheKey($type, $data), $duration, function () use ($request) {
                return Tuto::filters($request)->take(6)->get();
            });
        }

        return $suggestions;
    }

    /**
     * Generate SEO
     */
    private function generateSeo($type, $data)
    {
        $currentUrl = url('/') . '/' . $type . '/' . $data->slug;
        $youtubeUrl = "https://www.youtube.com/embed/" . $data->youtube_id;
        $title = substr($data->title, 0, 65);
        $description = substr($data->description, 0, 200);

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('article:published_time', $data->updated_at, 'property');
        SEOMeta::addMeta('article:section', $data->categories->pluck('name'), 'property');
        SEOMeta::addKeyword([$data->categories->pluck('name')]);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($currentUrl);
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'en-us');
        OpenGraph::addImage("https://img.youtube.com/vi/{$data->youtube_id}/mqdefault.jpg", ['height' => 320, 'width' => 180]);

        OpenGraph::addVideo($youtubeUrl, [
            'secure_url' => $youtubeUrl,
            'type' => 'application/x-shockwave-flash',
            'width' => 1280,
            'height' => 720
        ]);
    }

    private function generateCacheKey($type, $data)
    {
        $concatCat = "";
        $sortedCat = $data->categories->sortBy('id');
        foreach ($sortedCat as $cat) {
            $concatCat .= "_" . $cat->id;
        }
        $key = $type . $concatCat;
        return $key;
    }
}
