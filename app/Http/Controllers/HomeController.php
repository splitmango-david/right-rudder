<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'exams' => Exam::published()->withCount('questions')->orderBy('title')->get(),
            'guides' => config('guides'),
        ]);
    }
}
