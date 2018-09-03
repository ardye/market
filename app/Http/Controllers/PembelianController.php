<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Redirect;
use App\Pembelian;
use App\Supplier;
use App\PembelianDetail;
use App\Produk;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        return view('pembelian.index', compact('supplier'));
    }

    public function listData() {
        $pembelian = Pembelian::orderBy('id', 'desc')->get();
        $no = 0;
        $data = [];
        foreach ($pembelian as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = tanggalIndonesia(substr($list->created_at, 0, 10), false);
            $row[] = $list->supplier->nama;
            $row[] = $list->total_item;
            $row[] = formatUang($list->total_harga);
            $row[] = $list->diskon. "%";
            $row[] = formatUang($list->bayar);
            $row[] = '<div class="btn btn-group">
                        <a onclick="showDetail('. $list->id .')" class="btn btn-primary btn-sm btn-flat">
                            <i class="fa fa-eye"></i>
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
    public function create($id)
    {
        $pembelian = new Pembelian;
        $pembelian->id_supplier = $id;
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->bayar = 0;
        $pembelian->save();

        session(['id_pembelian' => $pembelian->id]);
        session(['id_supplier' => $id]);

        return Redirect::route('pembelian_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::find($request['id_pembelian']);
        $pembelian->total_item = $request['total_item'];
        $pembelian->total_harga = $request['total'];
        $pembelian->diskon = $request['diskon'];
        $pembelian->bayar = $request['bayar'];
        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', '=', $request['id_pembelian'])->get();
        foreach ($detail as $data) {
            $produk = Produk::where('id', '=', $data->id_produk)->first();
            $produk->stok += $data->jumlah;
            $produk->update();
        }
        session()->forget(['id_pembelian', 'id_supplier']);
        return Redirect::route('pembelian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pembelian = Pembelian::find($id);
        $data = [];
        $no = 0;
        foreach ($pembelian->produk as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->kode_produk;
            $row[] = $list->nama_produk;
            $row[] = formatUang($list->harga_jual);
            $row[] = $list->pivot->jumlah;
            $row[] = formatUang($list->pivot->sub_total);
            $data[] = $row;
        }
        $output = ['data' => $data];
        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PembelianDetail::where('id_pembelian', '=', $id)->get();
        foreach ($detail as $data) {
            $produk = Produk::where('id', '=', $data->id_produk)->first();
            $produk->stok -= $data->jumlah;
            $produk->update();
        }
        $pembelian = Pembelian::find($id);
        $pembelian->delete();
    }
}
