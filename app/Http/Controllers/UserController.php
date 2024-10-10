<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
    // public function __construct() {
    //     $this->middleware('permission:User add', ['only' => ['create']]);
    //     $this->middleware('permission:User edit', ['only' => ['edit']]);
    //     $this->middleware('permission:User delete', ['only' => ['destroy']]);
    //     $this->middleware('permission:User list');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $table_length = $request->table_length != '' ? $request->table_length : 10;
        $users = User::latest()->paginate($table_length);
        return view('users-manager.index', compact('users'));
    }
      public function create() {
        $roles = Role::all();
        return view('users-manager.create', compact('roles'));
    }  
    public function store(Request $request)
    {
        // Validate the form inputs
        $this->validate($request, [
            'name' => 'required|regex:/^[a-z\s\-\.]+$/i|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required|exists:roles,id', // Ensure the role exists based on ID
        ]);


    
        try {
            // Create new user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $saved = $user->save();
        } catch (Exception $e) {
            $saved = false;
            Log::channel('activity')->error($e, ['user' => auth()->user()->name, 'date' => now()]);
        }
    
        if ($saved) {
            // Fetch the role by ID and assign it to the user
            $role = Role::findById($request->role); // Find role by ID
            $user->assignRole($role);
    
            Log::channel('activity')->info('User added successfully.', ['user' => auth()->user()->name, 'date' => now()]);
         

            return redirect()->route('userIndex')->with('success', 'User added successfully.');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    

    public function edit($id) {
        $user =  User::find($id);
        $roles = Role::all();

        return view('users-manager.edit', compact('user', 'roles'));
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
        $this->validate($request, [
            'name' => 'required|regex:/^[a-z\s\-\.]+$/i|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $id,
            'password' => 'nullable|min:6|max:50|confirmed',
            'role' => 'required',
        ]);
    
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
    
            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }
    
            // Get the current role of the user (assuming they have only one role)
            $currentRole = $user->roles->first(); 
    
            // Fetch the role by ID and get the name for assigning the new role
            $newRole = Role::findById($request->role); // Fetch the role by its ID from the request
    
            // Check if the role has changed
            if ($currentRole && $currentRole->id != $newRole->id) {
                $user->removeRole($currentRole); // Remove the current role
                $user->assignRole($newRole->name); // Assign the new role by its name
            } elseif (!$currentRole) {
                // If the user has no role yet, assign the new role
                $user->assignRole($newRole->name);
            }
    
            // Save the user
            $saved = $user->save();
        } catch (Exception $e) {
            $saved = false;
            Log::channel('activity')->error($e, ['user' => auth()->user()->name, 'date' => now()]);
        }
    
        if ($saved) {
            Log::channel('activity')->info('user updated successfully.', ['user' => auth()->user()->name, 'date' => now()]);

            return redirect()->route('userIndex')->with('success', 'User updated successfully.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreAll()
    {
        // Fetch all soft deleted users
        $users = User::onlyTrashed()->with('roles')->get();

        foreach ($users as $user) {
            // Restore the user
            $user->restore();
    
            // Optionally, reassign their roles (not needed if roles are automatically preserved)
            foreach ($user->roles as $role) {
                $user->assignRole($role->name);
            }
        }
    
        return redirect()->back()->with('success', 'All users and their roles have been restored.');
    }
    
    public function destroy($id, Request $request) {
        $user = User::find($id);     
        // $role = $user->getRoleNames(); 

        // if($role['0'] == "admin" || $role['0'] == "Admin" || $role['0'] == "Super Admin" )
        // {
        //     return back()->with('message', 'Admin role can not allow to deleted . ');
       
        // } elseif ( Auth::User()->name==$user->name)
        //  {
        //     return back()->with('message', 'login user cannot delete. ');
        // } 
        // else {
        //     //role delete
        //     foreach ($user->roles->pluck('id') as $role) {}
        //     $user->removeRole($role);
        //     $user->delete();
        //     Log::channel('activity')->info('user deleted successfully.',
        //      ['user' => auth()->user()->name, 'date' => now()]);
           
        //     return response()->json(
        //         [
        //             'status' => 'success',
        //             'message' => 'User deleted Successfully',
        //         ]
        //     );

        // }
        $user->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'User deleted Successfully',
            ]
        );
    }
}
