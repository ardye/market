<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use DataTables;
use App\PenjualanDetail;
use PDF;
use App\Produk;
use App\Member;
use Auth;
use Redirect;
use App\Setting;

class PenjualanDetailController extends Controller
{
    public function index() {
    	$produk = Produk::where('stok', '>', 0)->get();
    	$member = Member::all();
    	$setting = Setting::first();
    	if(!empty(session('id_penjualan'))) {
    		$id_penjualan = session('id_penjualan');
    		return view('penjualan_detail.index', compact('produk', 'member', 'id_penjualan', 'setting'));
    	} else {
    		return Redirect::route('home');
    	}
    }

    public function listData($id) {
    	$penjualan = Penjualan::find($id);
    	$no = 0;
    	$data = [];
    	$total = 0;
    	$total_item = 0;
    	foreach ($penjualan->produk as $list) {
    		$no++;
    		$row = [];
    		$row[] = $no;
    		$row[] = '<input type="hidden" class="form-control" name="id_produk" value="'. $list->id .'">'.$list->kode_produk;
            $row[] = $list->nama_produk;
            $row[] = formatUang($list->pivot->harga_jual);
            $row[] = '<input type="number" class="form-control" name="jumlah_'. $list->pivot->id .'" value="'. $list->pivot->jumlah .'" onchange="changeCount('.$list->pivot->id.')">';
            $row[] = $list->pivot->diskon. " %";
            $row[] = formatUang($list->pivot->sub_total);

            $row[] = '<div class="btn btn-group">
                        <a onclick="deleteItem('. $list->pivot->id .')" class="btn btn-danger btn-sm btn-flat">
                            <i class="fa fa-trash"></i>
                        </a>
                      </div>';
            $data[] = $row;
            $total += ($list->harga_jual * $list->pivot->jumlah) - ($list->diskon/100 * $list->harga_jual * $list->pivot->jumlah);
            $total_item += $list->pivot->jumlah;
    	}
    	$data[] = ['<span class="hide total">'.$total.'</span><span class="hide total_item">'.$total_item.'</span>', '', '', '', '', '', '', ''];
        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        $produk = Produk::find($request['id_produk']);
        $detail = new PenjualanDetail;
        $detail->id_penjualan = $request['id_penjualan'];
        $detail->id_produk = $request['id_produk'];
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->sub_total = $produk->harga_jual - ($produk->harga_jual * $produk->diskon/100);
        $detail->diskon = $produk->diskon;
        $detail->save();
        
    }

    public function update(Request $request, $id)
    {
        $nama_input = "jumlah_". $id;
        $produk = Produk::find($request['id_produk']);
        $stok = $produk->stok;
        if($request[$nama_input] > 0) {
        if($stok >= $request[$nama_input]) {
            $detail = PenjualanDetail::find($id);
            $total_harga = $request[$nama_input] * $detail->harga_jual;
            $detail->jumlah = $request[$nama_input];
            $detail->sub_total = $total_harga - ($detail->diskon/100 * $total_harga);
            $detail->update();
            return json_encode(['msg' => 'success']);
        } else {
            return json_encode(['msg' => 'error']);
        }
    } else {
        return json_encode(['msg' => 'delete', 'id' => $id]);
    }
    }

   	public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();
    }

    public function newSession() {
    	$penjualan = new Penjualan;
    	$penjualan->id_member = null;
    	$penjualan->total_item = 0;
    	$penjualan->total_harga = 0;
    	$penjualan->diskon = 0;
    	$penjualan->bayar = 0;
    	$penjualan->diterima = 0;
    	$penjualan->id_user = Auth::user()->id;
    	$penjualan->save();

    	session(['id_penjualan' => $penjualan->id]);
    	return Redirect::route('transaksi.index');
    }

    public function saveData(Request $request) {
    	$penjualan = Penjualan::find($request['id_penjualan']);
    	$request['member'] != 0 ? $penjualan->id_member = $request['member'] : $penjualan->id_member = NULL;
    	$penjualan->total_item = $request['total_item'];
    	$penjualan->total_harga = $request['total'];
    	$penjualan->diskon = $request['diskon'];
    	$penjualan->bayar = $request['bayar'];
    	$penjualan->diterima = $request['diterima'];
    	$penjualan->update();

    	//Update Stok
    	$detail = PenjualanDetail::where('id_penjualan', '=', $request['id_penjualan'])->get();
        foreach ($detail as $data) {
            $produk = Produk::where('id', '=', $data->id_produk)->first();
            $produk->stok -= $data->jumlah;
            $produk->update();
        }

        return Redirect::route('transaksi.cetak');
    }
    public function loadForm($diskon, $total, $diterima) {
        $bayar = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data = [
            "totalrp" => formatUang($total),
            "bayar" => $bayar,
            "bayarrp" => formatUang($bayar),
            "terbilang" => ucwords(angkaTerbilang($bayar)). "Rupiah",
            "kembalirp" => formatUang($kembali),
            "kembali_terbilang" => ucwords(angkaTerbilang($kembali)). "Rupiah"
        ];
        return response()->json($data);
    }

    public function printNota() {
    	 $penjualan = session('id_penjualan');
    	// $setting = Setting::find(1);

    	// if($setting->tipe_nota == 0) {
    	// 	$handle = printer_open();
    	// 	printer_start_doc($handle, "Nota");
    	// 	printer_start_page($handle);

    	// 	$font = printer_create_font("Consolas", 100, 80, 600, false, false, false, 0);
    	// 	printer_select_font($handle, $font);
    	// 	printer_draw_text($handle, $setting->nama_perusahaan, 400, 100);

    	// 	$font = printer_create_font("Consolas", 72, 48, 400, false, false, false, 0);
    	// 	printer_select_font($handle, $font);
    	// 	printer_draw_text($handle, $setting->alamat, 0, 400);
    	// 	printer_draw_text($handle, date(Y-m-d), 0, 400);
    	// 	printer_draw_text($handle, substr("".Auth::user()->name, -15), 600, 400);

    	// 	printer_draw_text($handle, "No : ". substr("00000000".$penjualan->id, -8), 0, 500);
    	// 	printer_draw_text($handle, "=========================", 0, 600);
    	// 	$y = 700;
    	// 	foreach ($penjualan->produk as $list) {
    	// 		printer_draw_text($handle, $list->kode_produk."".$list->nama_produk, 0, $y+=100);
    	// 		printer_draw_text($handle, $list->pivot->jumlah."".formatUang($list->pivot->harga_jual), 0, $y+=100);
    	// 		printer_draw_text($handle, substr("".formatUang($list->pivot->jumlah*$list->pivot->harga_jual), -10), 850, $y);
    	// 		if($list->diskon != 0) {
    	// 			printer_draw_text($handle, "Diskon", 0, $y+=100);
    	// 			printer_draw_text($handle, substr("".formatUang($list->pivot->diskon/100*$list->sub_total), -10), 850, $y);
    	// 		}
    	// 	}
    	// 	printer_draw_text($handle, "-------------------------", 0, $y+=100);
    	// 	printer_draw_text($handle, "Total Harga: ", 0, $y+=100);
    	// 	printer_draw_text($handle, substr("".formatUang($penjualan->total_harga), -10), 850, $y);

    	// 	printer_draw_text($handle, "Total Item: ", 0, $y+=100);
    	// 	printer_draw_text($handle, substr("".$penjualan->total_item, -10), 850, $y);   		    		
    		
    	// 	printer_draw_text($handle, "Diskon Member: ", 0, $y+=100);
    	// 	printer_draw_text($handle, substr("".$penjualan->diskon."%", -10), 850, $y);

    	// 	printer_draw_text($handle, "Total Bayar: ", 0, $y+=100);
    	// 	printer_draw_text($handle, substr("".formatUang($penjualan->bayar), -10), 850, $y);

    	// 	printer_draw_text($handle, "Diterima: ", 0, $y+=100);
    	// 	printer_draw_text($handle, substr("".formatUang($penjualan->diterima), -10), 850, $y);

    	// 	printer_draw_text($handle, "Kembali: ", 0, $y+=100);
    	// 	printer_draw_text($handle, substr("".formatUang($penjualan->diterima-$penjualan->bayar), -10), 850, $y);

    	// 	printer_draw_text($handle, "=========================", 0, $y+=100);
    	// 	printer_draw_text($handle, "-= TERIMA KASIH =-", 250, $y+=100);

    	// 	printer_delete_font($font);
    	// 	printer_end_page($handle);
    	// 	printer_end_doc($handle);
    	// 	printer_close($handle);
    	// }
    	return view('penjualan_detail.selesai');
    }

    public function notaPDF() {
    	$penjualan = Penjualan::find(session('id_penjualan'));
    	$setting = Setting::find(1);
    	$no = 0;
    	$pdf = PDF::loadView('penjualan_detail.notapdf', compact('penjualan', 'setting', 'no'));
    	$pdf->setPaper([0,0,609,500], 'potrait');
    	return $pdf->stream();
    }

    public function show() {

    }
}
