<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Registration;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Application;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index(){
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $registrations = Registration::latest()->get();
        return view('admin.registration.registration' , compact('registrations')); 
    }

    public function show(Registration $id){
        if (request()->ajax()) {
            return response()->json(['result' =>  $id]);
        }
    }

    public function store(Request $request, Registration $id){
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'email' => ['required', 'string' , 'unique:users'],
            'password' => ['required'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        $emailNotif = [
            'notif_message'     => 'The account you requested has been approved.',
            'note'              => 'Use this as your login information.',
            'email'             => $request->input('email'),
            'password'          => $request->input('password'),
        ];
        Mail::to($id->email)
                ->send(new EmailNotification($emailNotif));

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        
        Application::create([
            'user_id' => $user->id,
            'name' => $id->name,
            'school' =>  $id->school,
        ]);
        RoleUser::insert([
            'user_id' => $user->id,
            'role_id' => 2,
        ]);

        $id->update([
            'status'   => 'APPROVED'
        ]);
        return response()->json(['success' => 'Successfully approved.']);
    }
}
