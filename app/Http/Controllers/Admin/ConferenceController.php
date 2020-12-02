<?php

namespace App\Http\Controllers\Admin;

use App\Models\Conference;
use App\Models\Langue;
use App\Models\Proposition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConferenceController extends Controller
{

    public function index(Request $request)
    {

        if ($request->has('search') && $request->get('search') !== '') {
            $conferences = Conference::with('categories')->where('is_valid', 1)->whereRaw('LOWER(title) like ?', ["%{$request->search}%"])->orderBy('id', 'desc')->paginate(15);
        } else {
            $conferences = Conference::with('categories')->where('is_valid', 1)->orderBy('id', 'desc')->paginate(15);
        }


        return view('admin.conferences.index', compact('conferences'));
    }

    public function propositions()
    {

        $propositions = Conference::where('is_valid', 0)->orderBy('id', 'desc')->paginate(10);

        return view('admin.conferences.propositions', compact('propositions'));
    }

    public function create()
    {

        $langues = Langue::all();

        return view('admin.conferences.create', compact('langues'));
    }

    public function edit(Conference $conference)
    {

        $langues = Langue::all();

        if (!$conference->is_valid) {
            $data = getYoutubeInfo($conference->youtube_id);
            $conference->title = $data['title'];
            $conference->description = $data['description'];
            $conference->published_at = $data['published_at'];
            $conference->duration = $data['duration'];
        }
        $conference->categories = $conference->convertCategoriesToString();



        return view('admin.conferences.edit', compact('conference', 'langues'));
    }

    public function store(Request $request)
    {

        return $this->createOrUpdate($request);
    }

    public function update(Request $request, Conference $conference)
    {

        return $this->createOrUpdate($request, $conference);

    }

    public function destroy(Request $request, Conference $conference)
    {

        $conference->delete();

        if ($request->ajax()) {
            return response()->json("Deleted", 204);
        }

        return redirect()->back()->with('deleted', "Conference deleted");
    }

    private function createOrUpdate(Request $request, Conference $conference = null)
    {

        $this->validateConf($request);

        DB::beginTransaction();
        try {
            if ($conference == null) {
                $conference = Conference::create($this->paramsToSave());
            } else {
                $conference->update($this->paramsToSave());
            }

            $conference->saveCategories(request('categories'));


        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
        }

        DB::commit();

        return redirect('/admin/conference/propositions')->with('edited', 'Conference updated!');


    }

    private function validateConf(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required|youtube_link',
            // 'description' => 'required', // Description can be empty
            'categories' => 'required',
            'langue' => 'required|exists:langues,id',
        ]);
    }

    private function paramsToSave()
    {

        $youtubeId = convertYoutubeLinkToId(request('link'));
        try {
            $data = getYoutubeInfo($youtubeId);
        } catch (\Exception $e) {
            throw $e;
        }

        return [
            'title' => request('title'),
            'youtube_id' => $youtubeId,
            'description' => request('description') ? : "",
            'langue_id' => request('langue'),
            'duration' => $data['duration'],
            'channel_name' => $data['channel_name'],
            'published_at' => Carbon::parse($data['published_at'])->toDateTimeString(),
            'is_valid' => 1
        ];
    }

}
