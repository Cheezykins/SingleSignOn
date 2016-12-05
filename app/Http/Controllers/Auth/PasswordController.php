<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;

class PasswordController extends Controller
{
    public function changePass()
    {
        return view('auth.changepass');
    }

    public function postChangePass(Request $request)
    {
        $this->validate($request, [
            'currentpass' => 'required',
            'newpass' => 'required|min:10',
            'confirmpass' => 'required'
        ]);

        if (!Hash::check($request->input('currentpass'), Auth::user()->password)) {
            return redirect()->back()->withErrors([
                'currentpass' => "Current password is not recognised"
            ]);
        }

        if ($request->input('newpass') !== $request->input('confirmpass')) {
            return redirect()->back()->withErrors([
                'confirmpass' => 'The passwords do not match'
            ]);
        }

        Auth::user()->password = Hash::make($request->input('newpass'), ['rounds' => 12]);
        Auth::user()->must_change_pass = false;
        Auth::user()->save();
        $request->session()->flash('message', 'Password changed successfully!');
        return redirect()->to('/');
    }
}