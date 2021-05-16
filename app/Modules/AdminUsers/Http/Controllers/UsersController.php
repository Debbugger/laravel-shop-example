<?php

namespace App\Modules\AdminUsers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\SaveTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    use SaveTrait;
    private $type = 'none';
    private $form = [
        'password' => ['required'],
    ];

    public function index()
    {
        return view('adminUsers::index');
    }

    public function userTable()
    {
        return DataTables::eloquent(User::query())->only(['id', 'name', 'email', 'edit', 'created_at'])->editColumn('edit', function (User $item) {
            return '<a href="' . route('adminUsersEdit', $item->id) . '" class="fa fa-pencil-square-o mr-2 edit-modal get-modal get-modal-edit" style="fonts-size: 20px"></a>';
        })->editColumn('created_at', function (User $item) {
            return $item->created_at->format('d.m.y H:i');
        })->editColumn('email', function (User $item) {
            return $item->email ? $item->email: 'Не указано';;
        })->rawColumns(['edit','email'])->toJson();
    }

    public function updateResponse($instance, $callbackResult)
    {
        if ($this->type == 'edit') {
            if ($instance->id != Auth::user()->id) {
                $instance->syncRoles([request()->input('role')]);
            }

            return response(['status' => 1, 'message' => 'Сохранено']);
        }

        return response(['status' => 1, 'message' => 'Пароль изменен']);
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->ajax()) {
            $this->messages['unique'] = 'Данный email уже зарегистрирован';
            $this->form = [
                'email'      => ['nullable', 'email', 'unique' => Rule::unique('users', 'email')->ignore($user->id), 'max' => '255'],
                'name'       => ['required', 'min:3'],
                'phone'      => ['required', 'phone' => 'phone:AUTO,UA','unique' => Rule::unique('users', 'phone')->ignore($user->id)],
                'date'=>['required','date'],

            ];
            if (($request->input('role')!='admin')&&(Auth::user()->id==$id))
                return response(['status'=>0,'message'=>'Нельзя убрать админку из своего аккаунта']);
            $user->assignRole($request->input('role'));
            $this->type = 'edit';

            return $this->save($user);
        }

        return view('adminUsers::edit')->with(['id' => $id, 'user' => $user, 'roles' => Role::all()]);

    }

    public function editPass(Request $request, $id)
    {
        if ($request->ajax()) {

            return $this->save(User::findOrFail($id));
        }

    }


}
