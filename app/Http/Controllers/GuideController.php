<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GuideController extends Controller
{
    public function show(string $slug): View
    {
        $guide = config("guides.{$slug}");

        abort_if($guide === null, 404);

        return view("guides.{$slug}", ['guide' => $guide]);
    }
}
