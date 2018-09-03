<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use DataTables;
use PDF;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }
    public function listData() {
        $member = Member::orderBy('id', 'desc')->get();
        $no = 0;
        $data = [];
        foreach ($member as $list) {
            $no++;
            $row = [];
            $row[] = '<input type="checkbox" name="id[]" value="'. $list->id. '">';
            $row[] = $no;
            $row[] = $list->kode_member;
            $row[] = $list->nama;
            $row[] = $list->alamat;
            $row[] = $list->telepon;
            $row[] = '<div class="btn btn-group">
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
        //Cek kode member
        $jumlah = Member::where('kode_member', '=', $request['kode'])->count();
        if($jumlah < 1) {
            $member = new Member;
            $member->kode_member = $request['kode'];
            $member->nama = $request['nama'];
            $member->alamat = $request['alamat'];
            $member->telepon = $request['telepon'];
            $member->save();
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
        $member = Member::find($id);
        echo json_encode($member);
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
        $member = Member::find($id);
        $member->nama = $request['nama'];
        $member->alamat = $request['alamat'];
        $member->telepon = $request['telepon'];
        $member->update();
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
        $member = Member::find($id);
        $member->delete();
    }

    public function printCard(Request $request) {
        $dataMember = [];
        foreach ($request['id'] as $id) {
            $member = Member::find($id);
            $dataMember[] = $member;
        }

        $pdf = PDF::loadView('member.card', compact('dataMember'));
        $pdf->setPaper([0, 0, 566.93, 850.93], 'potrait');
        return $pdf->stream();
    }
}
