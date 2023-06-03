<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Block;

class PlanetController extends Controller
{
    public function index()
    {
        $planets = Planet::latest()->paginate(15);
        return view('planets.index',compact('planets'));
    }
    public function show(Request $request, Planet $planet)
    {
        $blocks = $planet->blocks;
        //dd($blocks);
        return view('planets.show',[
            'pl' => $planet,
            'blocks' => $blocks
        ]);
    }
    public function create(Request $request)
    {
        $allblocks = Block::all();
        return view('planets.create',[
            'allblocks' => $allblocks,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:24',
            'bio' => 'required|string|max:128',
            'description' => 'required|string|max:1000',
        ]);
        $planet = $request->user()->planets()->make();
        $imgpath = $this->resolvePlanetImage($request, $planet);
        $validated['image'] = $imgpath;
        $planet->fill($validated);
        $planet->save();

        $this->resolvePlanetBlocks($request, $planet);
        return redirect(route('planets.index'));
    }
    public function edit(Request $request, Planet $planet)
    {
        $allblocks = Block::all();
        $plblocks = $planet->blocks;
        return view('planets.edit',[
            'pl' => $planet,
            'allblocks' => $allblocks,
            'plblocks' => $plblocks,
        ]);
    }
    public function update(Request $request, Planet $planet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:24',
            'bio' => 'required|string|max:128',
            'description' => 'required|string|max:1000',
        ]);
        $imgpath = $this->resolvePlanetImage($request, $planet);
        $validated['image'] = $imgpath;
        $planet->update($validated);
        $this->resolvePlanetBlocks($request, $planet);
        return redirect(route('planets.show',$planet));
    }

    protected function resolvePlanetBlocks(Request $request, Planet $planet) {
        $planet->blocks()->detach();
        $allbl_length = Block::count();
        $blockfield_keys = array_values(array_filter(
            array_keys($request->input()),
            function ($keyname) {
                return str_contains($keyname, 'block-');
            }
        ));
        $bfk_len = count($blockfield_keys) / 2;
        for ($i=0; ($i < $allbl_length)&&($i < $bfk_len); $i++) {
            $bl_name = $request->input($blockfield_keys[2*$i]);
            $bl = Block::where('name',$bl_name)->first();
            $bl_rate = $request->input($blockfield_keys[(2*$i)+1]);
            if ($bl_rate > 0) {
                $pivotdata = ['rate' => $bl_rate];
                if ($planet->hasBlock($bl->name)) {
                    $planet->blocks()->updateExistingPivot($bl->id, $pivotdata);
                } else {
                    $planet->blocks()->attach($bl, $pivotdata);
                }
            }
        }
    }
    protected function resolvePlanetImage(Request $request, Planet $planet) {
        $imgfile = $request->file('image');
        $path = ($imgfile) ? $imgfile->storeAs(
            'planets', $planet->id . '.' . $imgfile->extension(),
            'public'
        ) : null;
        return $path;
    }

    public function destroy(Request $request, $planet = null)
    {
        $pl = $planet ?? Planet::find($request->planet_id);
        if ($pl === null) {
            return redirect(route('planets.index'), 404);
        }
        //dd($pl);
        if ($request->user()->hasAnyRole(['admin','loader']) || $pl->user_id == Auth::user()->id) {
            $pl->delete();
            return redirect(route('planets.index'));
        }
        return redirect(route('planets.index'), 401);
    }
}
