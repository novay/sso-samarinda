<?php

namespace Novay\SSO\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Novay\SSO\Services\Broker;

class ImportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function import($type)
    {
        $broker = new Broker();
        $response = $broker->getUserList($type);

        foreach($response['data'] as $temp):
            config('sso.model')::updateOrCreate([
                'id'  => $temp['id'], 
            ], [
                'name' => $temp['name'],
                'email' => $temp['email'], 
                'password' => 'secret'
            ]);
        endforeach;

        return response()->json([
            'status' => 'success', 
            'message' => 'Daftar pengguna ('.$type.') berhasil diperbarui.', 
            'previous_url' => url()->previous()
        ]);
    }
}