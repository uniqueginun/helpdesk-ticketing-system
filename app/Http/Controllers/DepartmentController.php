<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{
    private const COMPONENT_PREFIX = 'Departments';

    public function __construct()
    {
        $this->middleware(['checkRole:admin|moderator']);
    }

    public function index(): Response
    {
        return Inertia::render(self::COMPONENT_PREFIX . '/Index', [
            'departments' => Department::all(['id', 'name'])
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'id' => 'nullable|sometimes',
            'name' => 'required|string|max:255'
        ]);

        Department::updateOrCreate(['id' => $validated['id']], ['name' => $validated['name']]);

        return redirect()->back()->with('success', "تم الحفظ بنجاح");
    }
}
