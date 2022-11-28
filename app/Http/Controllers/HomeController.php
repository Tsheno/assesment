<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Companies;
use App\Models\companyEmployees;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show  dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('home');
    }

    /**
     * Show setup view.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setup(){
        $userDetails = User::all();
        return view('account')->with('userDetails', $userDetails);
    }

    /**
     * Show account view.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function account(){
        $userDetails = User::find(Auth::user()->id);
        return view('account')->with('userDetails', $userDetails);
    }

    /**
     * Show companies view.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function companies(){

        if(checkPermission(['superadmin'])):
            $compDetails = Companies::all();
            return view('companies')->with('compDetails', $compDetails);
        else:
            return redirect('home');
        endif;
    }

    /**
     * Show edit company view.
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editCompany(int $id){
        $detail = Companies::find($id);
        return view('edit-company')->with('detail', $detail);
    }

    /**
     * Show create company view.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createCompany(){
        $admins = User::where('is_permission', '=', 'admin')->get();
        return view('create-company')->with('admins', $admins);
    }

    /**
     * Show store company details view.
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storeCompanyDetails(Request $request){

        # Validation
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'admin' => ['required', 'integer', 'max:3', 'min:1'],
        ]);

        $company = new Companies();
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->user_id = $request->input('admin');
        $company->save();

        $c_employees = new companyEmployees();
        $c_employees->user_id = $request->input('admin');
        $c_employees->company_id = $company->id;
        $c_employees->save();

        return back()->with("status", "Company Saved successfully!");
    }

    /**
     * deletes company record.
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteCompany(int $id){
        $detail = Companies::find($id);

        #delete company details
        $detail->delete();
        return back()->with("status", "Company Deleted successfully!");
    }

    /**
     * updates company details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCompanyDetails(Request $request){
        # Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        #update company details
        Companies::whereId($request->get('id'))->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);
        return back()->with("status", "Details changed successfully!");
    }

    /**
     * updates user's details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUserDetails(Request $request){
        # Validation
        $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'old_password'  => 'required',
            'new_password'  => 'required|confirmed',
        ]);

        #check if entered password matches password stored in the DB
        if(!Hash::check($request->get('old_password'), Auth::user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }

        #update user details
        User::whereId(auth()->user()->id)->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'password'    => Hash::make($request->new_password),
        ]);
        return back()->with("status", "Details changed successfully!");
    }

    /**
     * Show users view.
     * @return array
     */
    public function users():array{

        if(checkPermission(['admin','superadmin'])):
            $users =  User::select(
                "users.id",
                "users.first_name",
                "users.last_name",
                "users.email"
                )
                ->join("company_employees", "company_employees.user_id", "=", "users.id")
                ->where('users.is_permission', '!=' , 'admin')
                ->get()
                ->toArray();
            return view('users')->with('users', $users);;
        else:
            return redirect('home');
        endif;
    }

    /**
     * Show create users view.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createUser(){
        $companies = Companies::all();
        return view('create-user')->with('companies', $companies);;
    }

    /**
     * store user's details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUserDetails(Request $request){

        # Validation
        $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8'],
            'user'          => ['required', 'integer', 'max:3', 'min:1'],
        ]);

        $user = new User();
        $user->first_name     = $request->input('first_name');
        $user->last_name      = $request->input('last_name');
        $user->email          = $request->input('email');
        $user->password       = Hash::make($request->input('password'));
        $user->is_permission  = 'user';
        $user->save();

        $c_employees = new companyEmployees();
        $c_employees->user_id = $user->id;
        $c_employees->company_id = $request->input('user');
        $c_employees->save();

        return back()->with("status", "User Saved successfully!");
    }

    /**
     * updates user's details
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUser($id){
        $user = User::select(
            "users.id",
            "users.first_name",
            "users.last_name",
            "users.email",
            "companies.name",
            "company_employees.company_id"
        )
            ->join("company_employees", "company_employees.user_id", "=", "users.id")
            ->join("companies", "companies.id", "=", "company_employees.id")
            ->where('users.is_permission', '!=' , 'admin')
            ->where('company_employees.user_id', '=' , $id)
            ->get()
            ->toArray();

        $user['companies'] = Companies::all();

        return view('edit-user')->with('user', $user);
    }

    /**
     * update user details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDetails(Request $request){
        # Validation
        $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'user'          => ['integer', 'max:3', 'min:0'],
            'email'         => ['required', 'string', 'email', 'max:255'],

        ]);

        #update user details
        User::whereId($request->id)->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
        ]);

        #update user company details
        if($request->user !=0):
            companyEmployees::where('user_id', '=' , $request->id)->update([
                'company_id'  => $request->user,
            ]);
        else:
            companyEmployees::where('user_id', '=' , $request->id)->update([
                'company_id'  => 0,
            ]);
        endif;

        return back()->with("status", "Details changed successfully!");
    }

    /**
     * delete user details
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(int $id){
        $detail = User::find($id);

        #delete user details
        $detail->delete();
        return back()->with("status", "User Deleted successfully!");
    }
}
