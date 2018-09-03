<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function listData() {
        $user = User::orderBy('id', 'desc')->get();
        $no = 0;
        $data = [];
        foreach ($user as $list) {
            $no++;
               $row = [];
               $row[] = $no;
               $row[] = $list->name;
               $row[] = $list->email;
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
        $user = new User;
        $user->name = $request['nama'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->foto = 'user.png';
        $user->level = 2;
        $user->save();
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
        $user = User::find($id);
        return json_encode($user);
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
        $user = User::find($id);
        $user->name = $request['nama'];
        $user->email = $request['email'];
        if(!empty($request['password'])) {
            $user->password = bcrypt($request['password']);
        }
        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }

    public function profil() {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    public function changeProfil(Request $request, $id) {
        $msg = "success";
        $user = User::find($id);

        //cek password
        if(!empty($request['password'])) {
            //cek apakah password sama
            if(Hash::check($request['passwordlama'], $user->password)) {
                $user->password = bcrypt($request['password']);
            } else {
                $msg = "error";
            }
        }

        //cek input foto
        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_gambar = "fotouser_". $id.".".$file->getClientOriginalExtension();
            $lokasi = public_path('images');

            //upload foto ke folder images
            $file->move($lokasi, $nama_gambar);
            $user->foto = $nama_gambar;

            $datagambar = $nama_gambar;
        } else {
            $datagambar = $user->foto;
        }

        $user->update();
        echo json_encode(['msg' => $msg, 'url' => asset('public/images/'.$datagambar)]);
    }
}
