<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cadet;
use App\Models\Deployment;
use Illuminate\Support\Facades\Auth;

class DeploymentController extends Controller
{
    // =========================
    // SHOW DEPLOYMENT PAGE
    // =========================
public function index()
{
    $cadet = Cadet::where('user_id', Auth::user()->id)->firstOrFail();

    $deployment = Deployment::where('cadet_id', $cadet->id)
        ->latest()
        ->first();

    return view('cadet.deployment', compact('cadet', 'deployment'));
}
}