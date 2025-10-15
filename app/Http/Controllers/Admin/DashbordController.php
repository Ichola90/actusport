<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actusports;
use App\Models\Celebrite;
use App\Models\Mercato;
use App\Models\Omnisport;
use App\Models\Subscriber;
use App\Models\Wag;
use Illuminate\Http\Request;

class DashbordController extends Controller
{
   public function dashboard()
{
    // Total des articles
    $totalArticles = Mercato::count()
        + Omnisport::count()
        + Wag::count()
        + Celebrite::count()
        + Actusports::count();

    // Total des vues
    $totalViews = Mercato::sum('views')
        + Omnisport::sum('views')
        + Wag::sum('views')
        + Celebrite::sum('views')
        + Actusports::sum('views');

    // Total des abonnés
    $totalSubscribers = Subscriber::count();

    $categories = [
        'Mercato' => Mercato::count(),
        'Omnisport' => Omnisport::count(),
        'Wags' => Wag::count(),
        'Celebrites' => Celebrite::count(),
        'Actusports' => Actusports::count()
    ];

    // Derniers articles
    $articles = collect()
        ->merge(Mercato::latest()->take(5)->get()->each->setAttribute('type', 'mercato'))
        ->merge(Omnisport::latest()->take(5)->get()->each->setAttribute('type', 'omnisport'))
        ->merge(Wag::latest()->take(5)->get()->each->setAttribute('type', 'wags'))
        ->merge(Celebrite::latest()->take(5)->get()->each->setAttribute('type', 'celebrite'))
        ->merge(Actusports::latest()->take(5)->get()->each->setAttribute('type', 'actusport'))
        ->sortByDesc('created_at')
        ->take(10);

    // Articles publiés par mois
    $months = range(1, 12);
    $monthlyArticles = [];
    foreach ($months as $month) {
        $monthlyArticles[$month] =
            Mercato::whereYear('created_at', now()->year)->whereMonth('created_at', $month)->count()
            + Omnisport::whereYear('created_at', now()->year)->whereMonth('created_at', $month)->count()
            + Wag::whereYear('created_at', now()->year)->whereMonth('created_at', $month)->count()
            + Celebrite::whereYear('created_at', now()->year)->whereMonth('created_at', $month)->count()
            + Actusports::whereYear('created_at', now()->year)->whereMonth('created_at', $month)->count();
    }

    // Articles publiés par jour de la semaine
    $weekSales = [];
    $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    foreach ($days as $i => $day) {
        $date = now()->startOfWeek()->addDays($i);
        $weekSales[$day] = Mercato::whereDate('created_at', $date)->count()
            + Omnisport::whereDate('created_at', $date)->count()
            + Wag::whereDate('created_at', $date)->count()
            + Celebrite::whereDate('created_at', $date)->count()
            + Actusports::whereDate('created_at', $date)->count();
    }

    //  Vues par article (toutes catégories confondues)
    $viewsByArticles = collect()
        ->merge(Mercato::select('title','views')->get()->each->setAttribute('type','mercato'))
        ->merge(Omnisport::select('title','views')->get()->each->setAttribute('type','omnisport'))
        ->merge(Wag::select('title','views')->get()->each->setAttribute('type','wag'))
        ->merge(Celebrite::select('title','views')->get()->each->setAttribute('type','celebrite'))
        ->merge(Actusports::select('title','views')->get()->each->setAttribute('type','actusport'))
        ->sortByDesc('views');

    return view('Admin.Dashboard.dashboard', compact(
        'totalArticles',
        'totalViews',
        'totalSubscribers',
        'categories',
        'articles',
        'monthlyArticles',
        'weekSales',
        'viewsByArticles' 
    ));
}

}
