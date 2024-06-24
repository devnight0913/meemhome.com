<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Show the list of all users.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('user_manager_access');
        $sorts = ['asc', 'desc'];
        $sort = $request->get('order', 'desc');
        $size = $request->get('size', 20);

        if (!in_array($sort, $sorts)) {
            $sort = 'desc';
        }

        $search_query = $request->get("search_query");

        $users = User::search($search_query)->orderBy('created_at', $sort)->paginate($size);
        $this->deleteAllNotifications();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }
    private function deleteAllNotifications()
    {
        DB::table('notifications')->delete();
    }

    /**
     * Show the user.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, User $user): View|RedirectResponse
    {
        $this->checkPermission('user_show');
        if (!$request->user()->is_super_admin) {
            if ($user->is_super_admin) {
                return Redirect::back()->with('error', 'Super Admin cannot be viewed!');
            }
        }
        $totalOrders = $user->orders()->count();
        return view('admin.users.show', [
            'user' => $user->load('area'),
            'totalOrders' => $totalOrders,
        ]);
    }

    /**
     * Show the user edit form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, User $user): View|RedirectResponse
    {
        $this->checkPermission('user_edit');
        if (!$request->user()->is_super_admin) {
            if ($user->is_super_admin) {
                return Redirect::back()->with('error', 'Super Admin cannot be edited!');
            }
        }
        $roles = Role::getRoles();
        $areas = Area::active()->orderBy('name', 'ASC')->get();
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'areas' => $areas,
            'permissions' => $permissions,

        ]);
    }

    /**
     * Show the user create form.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $this->checkPermission('user_create');
        $roles = Role::getRoles();
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $areas = Area::active()->orderBy('name', 'ASC')->get();

        return view('admin.users.create', [
            'roles' => $roles,
            'areas' => $areas,
            'permissions' => $permissions,
        ]);
    }


    /**
     * Show the user create form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function depositEdit(Request $request, User $user): View|RedirectResponse
    {
        $this->checkPermission('user_edit');
        if (!$request->user()->is_super_admin) {
            if ($user->is_super_admin) {
                return Redirect::back()->with('error', 'Super Admin cannot be edited!');
            }
        }
        $roles = Role::getRoles();
        return view('admin.users.deposit-edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update  user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function depositUpdate(Request $request, User $user): RedirectResponse
    {
        $this->checkPermission('user_edit');
        if (!$request->user()->is_super_admin) {
            if ($user->is_super_admin) {
                return Redirect::back()->with('error', 'Super Admin cannot be edited!');
            }
        }

        $request->validate([
            'deposit' => ['required', 'numeric'],
        ]);

        $user->update([
            'deposit' => $request->deposit,
        ]);

        return Redirect::back()->with('success', 'Deposit has been updated!');
    }


    /**
     * Store new user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkPermission('user_create');
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users')],

            'phone' => ['nullable',  'max:25', Rule::unique('users')],

            'password' => ['required', 'confirmed', 'string', 'max:30', 'min:8'],


            'birthday' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:150'],


            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_phone' => ['nullable',  'max:25'],

            'area' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:190'],

            'notes' => ['nullable', 'string', 'max:3000'],

            'role' => ['required', 'integer'],

            'photo' => ['nullable', 'image', 'max:1024'],

        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        if (!is_null($request->phone)) {
            $user->phone = $request->phone;
            $user->phone_iso2 = $request->phone_iso2;
            $user->phone_dial_code = $request->phone_dial_code;
        }

        $user->password = Hash::make($request->password);
        $user->area_id = $request->area;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->contact_email = $request->contact_email;

        if (!is_null($request->contact_phone)) {
            $user->contact_phone = $request->contact_phone;
            $user->contact_phone_iso2 = $request->contact_phone_iso2;
            $user->contact_phone_dial_code = $request->contact_phone_dial_code;
        }
        $user->address = $request->address;
        $user->notes = $request->notes;
        $user->role_id = $request->role;
        $user->save();

        if (isset($request->photo)) {
            $user->updateProfilePhoto($request->photo);
        }
        $user->permissions()->sync($request->get('permissions', []));

        return Redirect::route('admin.users.index')->with('success', 'New user has been created!');
    }



    /**
     * Update  user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->checkPermission('user_edit');
        if (!$request->user()->is_super_admin) {
            if ($user->is_super_admin) {
                return Redirect::back()->with('error', 'Super Admin cannot be edited!');
            }
        }


        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable',  'max:25', Rule::unique('users')->ignore($user->id)],


            'birthday' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:150'],

            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_phone' => ['nullable',  'max:25'],

            'area' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:190'],

            'notes' => ['nullable', 'string', 'max:3000'],

            'role' => ['required', 'integer'],

            'photo' => ['nullable', 'image', 'max:1024'],

        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if (!is_null($request->phone)) {
            $user->phone = $request->phone;
            $user->phone_iso2 = $request->phone_iso2;
            $user->phone_dial_code = $request->phone_dial_code;
        }

        $user->area_id = $request->area;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->contact_email = $request->contact_email;

        if (!is_null($request->contact_phone)) {
            $user->contact_phone = $request->contact_phone;
            $user->contact_phone_iso2 = $request->contact_phone_iso2;
            $user->contact_phone_dial_code = $request->contact_phone_dial_code;
        }
        $user->address = $request->address;
        $user->notes = $request->notes;
        if (!$user->is_super_admin) {
            $user->role_id = $request->role;
        }
        $user->save();
        if (isset($request->photo)) {
            $user->updateProfilePhoto($request->photo);
        }
        if (!$user->is_super_admin) {
            $user->permissions()->sync($request->get('permissions', []));
        }


        return Redirect::route('admin.users.index')->with('success', 'User has been updated!');
    }


    /**
     * Delete user.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->checkPermission('user_delete');
        if ($user->is_super_admin) {
            return Redirect::back()->with('error', 'Super Admin cannot be deleted!');
        }

        $user->delete();
        return Redirect::back()->with('success', 'The user has been deleted!');
    }


    /**
     * Delete user's profile photo.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyProfilePhoto(User $user): RedirectResponse
    {
        $this->checkPermission('user_edit');
        $user->deleteProfilePhoto();
        return Redirect::back()->with('success', 'Profile Photo Removed.');
    }
}
