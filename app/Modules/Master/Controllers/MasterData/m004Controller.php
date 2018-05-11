<?php
namespace App\Modules\Master\Controllers\MasterData;

use App\Http\Controllers\Controller;
use DAO;
use Illuminate\Http\Request;
use Validator;

class m004Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('Master::masterdata.m004');
    }

    public function execute(Request $request)
    {
        if ($this->m004_validate($request)) {
            $data = Dao::call_stored_procedure('test');
            return response()->json
                (['data'     => $data,
                'status'     => 200,
                'statusText' => 'execute success']);
        } else {
            return response()->json
                (['error'    => $this->validator->errors()->all(),
                'status'     => 201,
                'statusText' => 'validate failed']);
        }
    }

    public function m004_validate(Request $request)
    {
        // var_dump($request->all());die;
        $this->validator = Validator::make($request->all(), [
            'family_nm'        => 'max:50',
            'first_name'       => 'max:20',
            'email'            => 'max:50',
            'cellphone'        => 'nullable|numeric|max:15',
            'birth_date'       => 'nullable|date',
            'employee_div'     => 'required',
            'account_nm'       => 'required|max:30',
            'password'         => 'required|max:100|min:8',
            'password_confirm' => 'required|same:password|min:8|max:100',
        ]);
        if (!$this->validator->passes()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
