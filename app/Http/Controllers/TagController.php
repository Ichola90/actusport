<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{public function suggestions(Request $request)
{
    $q = $request->get('q');
    if (!$q) return response()->json([]);

    $tables = ['mercatos', 'omnisports', 'wags', 'actusports', 'celebrites'];
    $all = collect();

    foreach ($tables as $table) {
        $rows = DB::table($table)
                  ->whereNotNull('tags')
                  ->where('tags', 'like', "%{$q}%")
                  ->pluck('tags');

        foreach ($rows as $str) {
            $parts = array_filter(array_map('trim', explode(',', $str)));
            $all = $all->merge($parts);
        }
    }

    $out = $all->unique()
               ->filter(fn($t) => stripos($t, $q) !== false)
               ->values()
               ->take(30); // limite
    return response()->json($out);
}

}
