<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Langue;
use App\Models\Tuto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('search') && $request->get('search') !== '') {
            $tutos = Tuto::with('categories')->where('is_valid', 1)->whereRaw('LOWER(title) like ?', ["%{$request->search}%"])->orderBy('id', 'desc')->paginate(15);
        } else {
            $tutos = Tuto::with('categories')->where('is_valid', 1)->orderBy('id', 'desc')->paginate(15);
        }

        return view('admin.tutos.index', compact('tutos'));
    }

    public function propositions()
    {
        $propositions = Tuto::where('is_valid', 0)->latest()->paginate(15);

        return view('admin.tutos.propositions', compact('propositions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Il faut passer par les propositions pour poster un tuto
        
        // $langues = Langue::all();

        // $parts = null;
        // $tuto = null;

        // return view('admin.tutos.create', compact('tuto', 'langues', 'parts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tuto $tuto
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Tuto $tuto)
    {
        // dd(getAllPartsFromPlaylist("PLFt_AvWsXl0ctd4dgE1F8g3uec4zKNRV0"));
        $langues = Langue::all();

        if (!$tuto->is_valid) {
            $data = getYoutubeInfo($tuto->youtube_id);
            $tuto->title = $data['title'];
            $tuto->description = $data['description'];
            $tuto->channel_name = $data['channel_name'];
            $tuto->published_at = $data['published_at'];
            $tuto->duration = $data['duration'];
        }
        $tuto->categories = $tuto->convertCategoriesToString();
        $parts = $tuto->tutoParts()->orderBy('part_number')->get();

        return view('admin.tutos.edit', compact('tuto', 'langues', 'parts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tuto $tuto)
    {

        //Ajax request cause add dynamic parts ..
        if (!$request->ajax()) throw new BadRequestHttpException("Wrong method");

        return $this->createOrUpdate($request, $tuto);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tuto $tuto)
    {
        $tuto->delete();

        return redirect('/admin/tuto')->with('deleted', "Tuto deleted");
    }

    private function createOrUpdate(Request $request, Tuto $tuto = null)
    {

        $this->validate($request, $this->validationRules(($tuto)));

        // dd($this->validate($request, $this->validationRules($tuto)));

        // dd($request->all());
        DB::beginTransaction();
        try {
            if ($tuto == null) {
                $tuto = Tuto::create($this->paramsToSave($request));
            } else {
                $tuto->update($this->paramsToSave($request));
            }

            $tuto->saveCategories($request->input('tuto.categories'));

            // dd($request->input('parts'));
            $tuto->saveTutoParts($request->input('parts'));


        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('error', 'An Error Occured');
            return response()->json(["error" => [$e->getMessage()]], 422);
            // die($e->getMessage());
        }

        DB::commit();

        $request->session()->flash('added', 'Tuto Edited!');

        return response()->json(['success'], 201);

    }

    private function paramsToSave(Request $request)
    {
        // dd(request('tuto.youtube_id'), $request->input('tuto.youtube_id'));


        $youtubeId = convertYoutubeLinkToId($request->input('tuto.youtube_id'));
        // dd($youtubeId, request('tuto.youtube_id'));

        return [
            'title' => $request->input('tuto.title'),
            'description' => $request->input('tuto.description') ? : "",
            'youtube_id' => $youtubeId,
            'langue_id' => $request->input('tuto.langue_id'),
            'is_valid' => 1,
            'channel_name' => $request->input('tuto.channel_name'),
            'duration' => $request->input('tuto.duration'),
            'published_at' => Carbon::parse($request->input('tuto.published_at'))->toDateTimeString(),
            'updated_at' => Carbon::now() // Pour update le timestamp lorsque je rajoute une part
        ];
    }

    private function validationRules($tuto)
    {

        $uniqueRule = "bail|required|youtube_link|distinct|uniqueInTutoAndTutoPart";

        if ($tuto) {
            $uniqueRule .= ":" . $tuto->id;
        }

        return [
            'tuto.title' => 'required',
            'tuto.youtube_id' => 'required|uniqueInTutoAndTutoPart' . $tuto === null ? : ':' . $tuto->id,
            'tuto.categories' => 'required',
            // 'tuto.description' => 'required', --> Add empty string instead just above
            'tuto.langue_id' => 'required|exists:langues,id',
            'tuto.channel_name' => 'required',
            'tuto.published_at' => 'required',
            'parts.*.youtube_id' => $uniqueRule,
            'parts.*.title' => 'required',
            'parts.*.duration' => 'required'
        ];
    }
}
