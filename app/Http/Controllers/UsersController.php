<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Response as InertiaResponse;
use Inertia\Inertia;

class UsersController extends Controller
{
    private const COMPONENT_PREFIX = 'Admin/Users';

    /**
     * Display a listing of the resource.
     */
    public function index(): InertiaResponse
    {
        return Inertia::render(self::COMPONENT_PREFIX . '/Index', [
            'users' => User::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return InertiaResponse
     */
    public function create(): InertiaResponse
    {
        return Inertia::render(self::COMPONENT_PREFIX . '/Create', [
            'types' => User::$userTypes
        ]);
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        event(new Registered(User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role
        ])));

        return redirect()->back()->with('success', "تم إنشاء المستخدم {$request->name} بنجاح");
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
     * @param  User  $user
     * @return InertiaResponse
     */
    public function edit(User $user): InertiaResponse
    {
        return Inertia::render(self::COMPONENT_PREFIX . '/Edit', [
            'types' => User::$userTypes,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $updatedData = array_merge([
            'name' => $request->name,
            'email' => $request->email,
            'user_role' => $request->user_role
        ], $request->update_password ? ['password' => Hash::make($request->password)] : []);

        $user->update($updatedData);

        return redirect()->back()->with('success', "تم تحديث بيانات المستخدم بنجاح");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        abort_if(Auth::id() === $user->id, Response::HTTP_UNAUTHORIZED, 'لا يمكن ان تحذف نفسك');

        if ($user->tickets()->count()) {
            return redirect()->back()->with('error', "المستخدم مسجلة عليه طلبات لايمكن حذفه");
        }

        $user->delete();

        return redirect()->back()->with('success', "تمت إحالة بيانات المستخدم الى سلة المهملات");
    }
}
