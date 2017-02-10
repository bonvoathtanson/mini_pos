<?php

namespace App\Http\Controllers;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users'=>$users]);
    }

    public function search()
    {
        $users = User::all();
        $this->SetData($users);
        return response()->json($this->Results);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::rules());
        if ($validator->fails())
        {
            $this->Fail();
            $this->SetMessage($validator->messages()->first());
        }else{
            $user = new User();
            $user->Name = $request->Name;
            $user->Email = $request->Email;
            $user->Password = bcrypt($request->Password);
            $user->DateCreated = date('Y-m-d H:i:s');
            $user->save();
        }

        return response()->json($this->Results);
    }

    public function destroy($id)
    {
        $rowaffect = User::find($id)->delete();
        if($rowaffect == 0){
            $this->SetError(true);
            $this->Results['Message'] = 'ការលុប​ទិន្នន័យមានបញ្ហាសូមព្យា​យាម​ម្តងទៀត';
        }
        return response()->json($this->Results);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function dologin(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['Name' => $data['name'], 'password' => $data['password']])) {
            return Redirect::intended('/');
        } else {
            return Redirect::back()->withErrors('That username/password combo does not exist.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::intended('/login');
    }
}
