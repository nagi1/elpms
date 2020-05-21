<?php

namespace App\Http\Controllers\Categories;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Project\AddCategoriesToProjectAction;
use App\Actions\Category\DeleteCategoryAction;
use App\Actions\Account\AddCategoriesToAccountAction;

class CategoriesController extends Controller
{
    public function update(Category $category, Request $request)
    {
        $category->update([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        return redirect()->back();
    }

    public function destroy(Category $category, DeleteCategoryAction $deleteCategoryAction)
    {
        $deleteCategoryAction->execute($category);
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $category =  $request->validate([
            'name' => ['required'],
            'icon' => ['required'],
            'modelType' => ['required', 'in:project,account'],
            'modelId' => ['required']
        ]);

        if ($request->modelType == "project") {
            app(AddCategoriesToProjectAction::class)->execute(Project::findOrFail($request->modelId), $category);
        } else if ($request->modelType == "account") {
            app(AddCategoriesToAccountAction::class)->execute(Account::findOrFail($request->modelId), $category);
        }

        return redirect()->back();
    }
}
