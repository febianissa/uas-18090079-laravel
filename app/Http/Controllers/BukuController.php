<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use Carbon\Carbon;
use Cloudinary;

class BukuController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        // $bukus= Buku::all();
        $bukus= Buku::latest()->get();
        
        return view('Buku.index',compact('bukus')); 

    }
    public function cetak(){
        $bukus= Buku::latest()->get();
        return view('Buku.cetak',compact('bukus')); 

    }
    public function create(){
        return view('Buku.create');
    }
    public function store(Request $request){
        $input = $request->all();

        if ($image = $request->file('gambar')) {

            $destinationPath = 'file/';

            $profileFile = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileFile);

            $input['gambar'] = "$profileFile";

        }

            Buku::create($input);

        return redirect() ->route('buku.index');
    }
    public function destroy($id){
        $buku = Buku::findOrFail($id);
        // dd($buku);
        $buku -> delete();
        return redirect() ->route('buku.index');

        
    }
    public function edit($id){
        $buku = Buku::findOrFail($id);
        return view('Buku.edit',compact('buku')); 

    }
    public function update(Request $request, Buku $buku){
        
        $input = $request->all();
       
        if ($image = $request->file('gambar')) {

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['gambar'] = "$profileImage";

        }else{

            unset($input['gambar']);
        }
        $buku->update($input);
        
        return redirect() ->route('buku.index');

    }
}
