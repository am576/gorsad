<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service;
use App\ServiceOrder;
use App\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $queries = UserQuery::orderBy('updated_at', 'DESC')
            ->take(3)
            ->get();
        $services = ServiceOrder::orderBy('updated_at', 'DESC')
            ->take(3)
            ->get();
        return view('admin.dashboard', compact('queries','services'));
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/admin');
    }
}
