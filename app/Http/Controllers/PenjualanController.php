<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\PenjualanDetail;
use App\Produk;
use DataTables;

class PenjualanController extends Controller
{
    public function index() {
    	return view('penjualan.index');
    }

    public function listData() {
    	$penjualan = Penjualan::orderBy('id', 'desc')->get();
        $no = 0;
        $data = [];
        foreach ($penjualan as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = tanggalIndonesia(substr($list->created_at, 0, 10), false);
            (!empty($list->member->id)) ? $row[] = $list->member->nama : $row[] = " - ";
            $row[] = $list->total_item;
            $row[] = formatUang($list->total_harga);
            $row[] = $list->diskon. "%";
            $row[] = formatUang($list->bayar);
            $row[] = $list->user->name;
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

    public function show($id)
    {
        $penjualan = Penjualan::find($id);
        $data = [];
        $no = 0;
        foreach ($penjualan->produk as $list) {
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

    public function destroy($id)
    {
        $detail = PenjualanDetail::where('id_penjualan', '=', $id)->get();
        foreach ($detail as $data) {
            $produk = Produk::where('id', '=', $data->id_produk)->first();
            $produk->stok += $data->jumlah;
            $produk->update();
        }
        $penjualan = penjualan::find($id);
        $penjualan->delete();
    }
}
