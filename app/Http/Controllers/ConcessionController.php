<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use App\Repositories\ConcessionRepositoryInterface;
use Illuminate\Http\Request;

class ConcessionController extends Controller
{
    public function __construct(private ConcessionRepositoryInterface $concessions) {}

    public function index() {
        $concessions = $this->concessions->paginate();
        return view('concessions.index', compact('concessions'));
    }

    public function create() { return view('concessions.create'); }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'price' => 'required|numeric|min:0',
        ]);
        $path = $request->file('image')->store('concessions','public');
        $this->concessions->create([
            'name'=>$data['name'],
            'description'=>$data['description'] ?? null,
            'image_path'=>$path,
            'price'=>$data['price'],
        ]);
        return redirect()->route('concessions.index')->with('ok','Concession added.');
    }

    public function edit(Concession $concession) {
        return view('concessions.edit', compact('concession'));
    }

    public function update(Request $request, Concession $concession) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
        ]);
        $payload = [
            'name'=>$data['name'],
            'description'=>$data['description'] ?? null,
            'price'=>$data['price'],
            'image_path'=>$concession->image_path,
        ];
        if ($request->hasFile('image')) {
            $payload['image_path'] = $request->file('image')->store('concessions','public');
        }
        $this->concessions->update($concession, $payload);
        return redirect()->route('concessions.index')->with('ok','Concession updated.');
    }

    public function destroy(Concession $concession) {
        $this->concessions->delete($concession);
        return back()->with('ok','Concession deleted.');
    }
}
