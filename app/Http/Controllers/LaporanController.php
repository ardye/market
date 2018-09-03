<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian;
use App\Penjualan;
use App\Pengeluaran;
use DataTables;
use PDF;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');
        return view('laporan.index', compact('awal', 'akhir'));
    }

    protected function getData($awal, $akhir) {
        $no = 0;
        $data = [];
        $pendapatan = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            $total_penjualan = Penjualan::where('created_at', 'LIKE', '%'.$tanggal.'%')->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', '%'.$tanggal.'%')->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', '%'.$tanggal.'%')->sum('nominal');
            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $total_pendapatan += $pendapatan;

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = tanggalIndonesia($tanggal, false);
            $row[] = formatUang($total_penjualan);
            $row[] = formatUang($total_pembelian);
            $row[] = formatUang($total_pengeluaran);
            $row[] = formatUang($pendapatan);
            $data[] = $row;
        }
        $data[] = ["","","","", "Total Pendapatan", formatUang($total_pendapatan)];
        return $data;
    }
    public function listData($awal, $akhir) {
        $data = $this->getData($awal, $akhir);
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
    public function refresh(Request $request)
    {
        $awal = $request['awal'];
        $akhir = $request['akhir'];
        return view('laporan.index', compact('awal', 'akhir'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function printPDF($awal, $akhir) {
        $tanggal_awal = $awal;
        $tanggal_akhir = $akhir;
        $data = $this->getData($awal, $akhir);

        $pdf = PDF::loadView('laporan.pdf', compact('tanggal_awal', 'tanggal_akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
}
