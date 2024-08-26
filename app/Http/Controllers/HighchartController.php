<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class HighchartController extends Controller
{
    public function index()
    {
    
        $usersData = DB::table('master.master_user')
            ->selectRaw('COUNT(*) as count, EXTRACT(MONTH FROM updated_at) as month')
            ->whereRaw('EXTRACT(YEAR FROM updated_at) = ?', [2023])
            ->groupByRaw('EXTRACT(MONTH FROM updated_at)')
            ->pluck('count', 'month');

        // Inisialisasi array dengan 12 elemen (untuk setiap bulan)
        $users = array_fill(1, 12, 0);

   
        foreach ($usersData as $month => $count) {
            $users[$month] = $count;
        }

            
        return view('chart', compact('users'));
    }
}
