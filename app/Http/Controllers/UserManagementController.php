<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagementController extends Controller
{
    protected $data;

    public function __construct()
    {
        global $data;
        $this->data = &$data;

        $this->data['roles'] = DB::table('roles')->get();
        $this->data['permissions'] = DB::table('permissions')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['users'] = User::where('active', 1)->orderBy('online', 'DESC')->orderBy('last_login', 'DESC')->get();
        $this->data['deactivated'] = User::where('active', 0)->get();
        return view('users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('users.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'role' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
        ];

        $user = User::create($data);
        $newUser  = User::find($user->id);
        // dd($newUser);
        if (!empty($newUser)) {
            if ($newUser->assignRole($request->role)) {
                flash('User ' . $request->name . ' created successfully with the role ' . $request->role)->success();
            } else {
                flash('An error occurred while processing your request! Kindly try again later!')->error();
                // Delete the newly created record
                $newUser->delete();
            }
        } else {
            flash('An error occurred while processing your request! Kindly try again later!')->error();
        }

        return back();
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
        //
        $this->data['user'] = User::find($id);

        return view('users.edit', $this->data);
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

        $success = false;
        $user = User::find($id);

        if ($request->name != $user->name) {
            $request->validate([
                'name' => 'required|unique:users,name',
            ]);
            $user->name = $request->name;
        }

        if ($user->save()) {
            $success = true;
        } else {
            $success = false;
        }
        $user = User::find($id);

        $roles = $this->data['roles'];
        foreach ($roles as $role) {
            if ($user->hasRole($role->name)) {
                $user->removeRole($role->name);
            }
        }

        $user->assignRole($request->role);

        if ($success) {
            flash("Changes made successfully!")->success();
        } else {
            flash('An error occurred while processing your request! Kindly try again later!')->error();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $user = User::find($id);
        $user->active = 0;
        $user->deleted_at = new DateTime();
        $user->deleted_by = Auth::user()->id;
        if ($user->save()) {
            flash('User deactivated successfully')->success();
        } else {
            flash('An error occurred while processing your request! Kindly try again later!')->error();
        }

        return back();
    }

    public function show_roles()
    {


        return view('users.roles', $this->data);
    }

    public function delete_permanently(Request $request)
    {
        $user = User::find($request->id);
        $status = '';
        if ($user->delete()) {
            $status = "success";
        } else {
            $status = "failure";
        }

        echo json_encode(['status' => $status]);
    }
}
