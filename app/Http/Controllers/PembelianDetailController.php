<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use DataTables;
use App\Pembelian;
use App\PembelianDetail;
use App\Supplier;
use App\Produk;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        $id_pembelian = session('id_pembelian');
        $supplier = Supplier::find(session('id_supplier'));
        return view('pembelian_detail.index', compact('produk', 'id_pembelian', 'supplier'));
    }

    public function listData($id) {
        $pembelian = Pembelian::find($id);
        $no = 0;
        $data = [];
        $total = 0;
        $total_item = 0;
        foreach ($pembelian->produk as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = '<input type="hidden" class="form-control" name="id_produk" value="'. $list->id .'">'.$list->kode_produk;
            $row[] = $list->nama_produk;
            $row[] = formatUang($list->pivot->harga_beli);
            $row[] = '<input type="number" class="form-control" name="jumlah_'. $list->pivot->id .'" value="'. $list->pivot->jumlah .'" onchange="changeCount('.$list->pivot->id.')">';
            $row[] = formatUang($list->harga_beli * $list->pivot->jumlah);

            $row[] = '<div class="btn btn-group">
                        <a onclick="deleteItem('. $list->pivot->id .')" class="btn btn-danger btn-sm btn-flat">
                            <i class="fa fa-trash"></i>
                        </a>
                      </div>';
            $data[] = $row;
            $total += $list->harga_beli * $list->pivot->jumlah;
            $total_item += $list->pivot->jumlah;
        }
        $data[] = ['<span class="hide total">'.$total.'</span><span class="hide total_item">'.$total_item.'</span>', '', '', '', '', '', ''];
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
        $produk = Produk::find($request['id_produk']);
        $detail = new PembelianDetail;
        $detail->id_pembelian = $request['id_pembelian'];
        $detail->id_produk = $request['id_produk'];
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->sub_total = $produk->harga_beli;
        $detail->save();
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
        echo $produk->stok;
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
        $nama_input = "jumlah_". $id;
        if($request[$nama_input] > 0) {
            $detail = PembelianDetail::find($id);
            $detail->jumlah = $request[$nama_input];
            $detail->sub_total = $detail->harga_beli * $request[$nama_input];
            $detail->update();
            return json_encode(['msg' => 'success']);
        } else {
            return json_encode(['msg' => 'delete', 'id' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();
    }

    public function loadForm($diskon, $total) {
        $bayar = $total - ($diskon / 100 * $total);
        $data = [
            "totalrp" => formatUang($total),
            "bayar" => $bayar,
            "bayarrp" => formatUang($bayar),
            "terbilang" => ucwords(angkaTerbilang($bayar)). "Rupiah"
        ];
        return response()->json($data);
    }
}
