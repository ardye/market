<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\Produk;
use DataTables;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view('produk.index', compact('kategori'));
    }

    public function listData() {
        $produk = Produk::orderBy('id', 'desc')->get();
        $no = 0;
        $data = [];
        foreach ($produk as $list) {
            $no++;
               $row = [];
               $row[] = '<input type="checkbox" name="id[]" value="'. $list->id .'">';
               $row[] = $no;
               $row[] = $list->kode_produk;
               $row[] = $list->nama_produk;
               $row[] = $list->kategori->nama_kategori;
               $row[] = "Rp. ". formatUang($list->harga_jual);
               $row[] = $list->stok;
               $row[] = '<div class="btn btn-group">
                            <a onclick="showDetail('. $list->id .')" class="btn btn-default btn-sm btn-flat">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a onclick="editForm('. $list->id .')" class="btn btn-primary btn-sm btn-flat">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a onclick="deleteData('. $list->id .')" class="btn btn-danger btn-sm btn-flat">
                                <i class="fa fa-trash"></i>
                            </a>
                          </div>';
                $data[] = $row;
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Cek kode produk
        $jumlah = Produk::where('kode_produk', '=', $request['kode'])->count();
        if($jumlah < 1) {
            $produk = new Produk;
            $produk->kode_produk = $request['kode'];
            $produk->id_kategori = $request['kategori'];
            $produk->nama_produk = $request['nama'];
            $produk->merk = $request['merk'];
            $produk->harga_beli = $request['harga_beli'];
            $produk->harga_jual = $request['harga_jual'];
            $produk->diskon = $request['diskon'];
            $produk->stok = $request['stok'];
            $produk->save();
            echo json_encode(['msg' => 'success']);
        } else {
            echo json_encode(['msg' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);
        echo json_encode($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::find($id);
        echo json_encode($produk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->id_kategori = $request['kategori'];
        $produk->nama_produk = $request['nama'];
        $produk->merk = $request['merk'];
        $produk->harga_beli = $request['harga_beli'];
        $produk->harga_jual = $request['harga_jual'];
        $produk->diskon = $request['diskon'];
        $produk->stok = $request['stok'];
        $produk->update();
        echo json_encode(['msg' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
    }

    public function deleteSelected(Request $request) {
        foreach ($request['id'] as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }
    }

    public function printBarcode(Request $request) {
        $dataProduk = [];
        foreach ($request['id'] as $id) {
            $produk = Produk::find($id);
            $dataProduk[] = $produk;
        }
        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataProduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    } 
}
