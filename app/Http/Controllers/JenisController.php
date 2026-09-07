<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\Jenis; 
use Illuminate\Http\Request; 
 
class JenisController extends Controller 
{ 
    public function index(Request $request) 
    { 
        $query = Jenis::query(); 
 
        if ($request->filled('search')) { 
            $query->where( 
                'nama_jenis', 
                'like', 
                '%' . $request->search . '%' 
            ); 
        } 
 
        $jenis = $query 
            ->latest() 
            ->paginate(10) 
            ->withQueryString(); 
 
        return view('jenis.index', compact('jenis')); 
    } 
 
    public function create() 
    { 
        return view('jenis.create'); 
    } 
 
    public function store(Request $request) 
    { 
        $request->validate([ 
            'nama_jenis' => 'required|string|max:255|unique:jenis,nama_jenis', 
            'deskripsi' => 'nullable|string', 
        ], [ 
            'nama_jenis.required' => 'Nama jenis wajib diisi.', 
            'nama_jenis.unique' => 'Nama jenis sudah digunakan.', 
        ]); 
 
        Jenis::create([ 
            'nama_jenis' => $request->nama_jenis, 
            'deskripsi' => $request->deskripsi, 
        ]); 
 
        return redirect() 
            ->route('jenis.index') 
            ->with('success', 'Jenis berhasil ditambahkan.'); 
    } 
 
    public function edit(Jenis $jenis) 
    { 
        return view('jenis.edit', compact('jenis')); 
    } 
 
    public function update(Request $request, Jenis $jenis) 
    { 
        $request->validate([ 
            'nama_jenis' => 'required|string|max:255|unique:jenis,nama_jenis,' . $jenis->id, 
            'deskripsi' => 'nullable|string', 
        ], [ 
            'nama_jenis.required' => 'Nama jenis wajib diisi.', 
            'nama_jenis.unique' => 'Nama jenis sudah digunakan.', 
        ]); 
 
        $jenis->update([ 
            'nama_jenis' => $request->nama_jenis, 
            'deskripsi' => $request->deskripsi, 
        ]); 
 
        return redirect() 
            ->route('jenis.index') 
            ->with('success', 'Jenis berhasil diperbarui.'); 
    }

    public function destroy(Jenis $jeni)
    { 
        if ($jeni->produk()->exists()) { 
            return redirect() 
                ->route('jenis.index') 
                ->with( 
                    'error', 
                    'Jenis tidak dapat dihapus karena masih digunakan oleh produk.' 
                ); 
        } 
 
        $namaJenis = $jeni->nama_jenis; 
 
        $jeni->delete(); 
 
        return redirect() 
            ->route('jenis.index') 
            ->with('success', "Jenis {$namaJenis} berhasil dihapus."); 
    } 
 
}