<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index_summary(Request $request) {
        $search = $request->search;

        $registrations = Pendaftaran::select(DB::raw('DATE(created_at) as date'), 
                        DB::raw('COUNT(*) as total_registrations'))
                        ->groupBy(DB::raw('DATE(created_at)'))
                        ->orderBy(DB::raw('DATE(created_at)'), 'desc')
                        ->havingRaw('DATE(created_at)::text LIKE ? OR COUNT(*)::text LIKE ?', ['%' . $search . '%', '%' . $search . '%'])
                        ->paginate(20);

        return View('report.user-summary', compact('registrations'));
    }

    public function index_login(Request $request) {
        $search = $request->search;

        $registrations = DB::table('login_logs')
                        ->select('users.full_name as user_name', 'login_logs.user_id', DB::raw('COUNT(*) as login_attempts'))
                        ->join('users', 'users.id', '=', 'login_logs.user_id')
                        ->Where('users.full_name', 'LIKE', '%' . $search . '%')
                        ->groupBy('login_logs.user_id', 'users.full_name')                        
                        ->orderBy(DB::raw('COUNT(*)'), 'desc')
                        ->take(30) // Limit the total number of users queried
                        ->paginate(10);


        return View('report.login-summary', compact('registrations'));
    }
}
