   public function ajaxSearch(Request $request)
   {
   $q = $request->input('q');

   $mercatos = Mercato::where('title', 'like', "%{$q}%")
   ->orWhere('content', 'like', "%{$q}%")
   ->get();

   $actus = Actusports::where('title', 'like', "%{$q}%")
   ->orWhere('content', 'like', "%{$q}%")
   ->get();

   $wags = Wag::where('title', 'like', "%{$q}%")
   ->orWhere('content', 'like', "%{$q}%")
   ->get();

   $omnisports = Omnisport::where('title', 'like', "%{$q}%")
   ->orWhere('content', 'like', "%{$q}%")
   ->get();

   $celebrites = Celebrite::where('title', 'like', "%{$q}%")
   ->orWhere('content', 'like', "%{$q}%")
   ->get();

   $all = $mercatos->merge($actus)->merge($wags)->merge($omnisports)->merge($celebrites);

   $results = $all->map(function ($article) {
   // Génère l'URL correcte selon le type
   switch ($article->type) {
   case 'mercato':
   $url = route('articles.show', $article->slug);
   break;
   case 'actusport':
   $url = route('actuafrique.detail', $article->slug);
   break;
   case 'wags':
   $url = route('articles.show.wags', $article->slug);
   break;
   case 'omnisport':
   $url = route('articles.show.omnisport', $article->slug);
   break;
   case 'celebrite':
   $url = route('articles.show.celebrite', $article->slug);
   break;
   default:
   $url = '#';
   }

   return [
   'title' => $article->title,
   'type' => $article->type,
   'url' => $url,
   ];

   });

   return response()->json($results);
   }