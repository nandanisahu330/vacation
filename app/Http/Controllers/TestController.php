<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use App\Models\User;
use App\Models\Category;

class TestController extends Controller
{
    public function index()
    {
        // $user = User::with('contact')->first();

        // return $user->contact;

        // $user = User::with(['contact','profiles'])->find(1);
        // return $user -> toArray();

        // $profiles = Profile::with('user')->first();
        // return $profiles-> toArray();

        $categories = Category::all();
        $profiles = Profile::with('categories')->first();
        // $profiles->categories()->attach($categories);
        // $profiles->categories()->sync([1,2]);
        // $profiles->categories()->detach([1,2]);
                $profiles->categories()->attach([1,2]);


         $profiles = Profile::with('categories')->first();
        return $profiles->toArray();

    }
}
