<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\OmnisportController;
use App\Http\Controllers\Admin\WagsController;
use App\Http\Controllers\Admin\CelebriteController;
use App\Http\Controllers\AllarticleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CollaborateurController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UsersController;


Route::get('/login', [LoginController::class, 'loginShow'])->name('login.show');
Route::post('/authentification', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [UsersController::class, 'index'])->name('home');

//mercatoshowdetailafrique

Route::get('users/mercato', [ArticleController::class, 'showmercato'])->name('show.mercato');
Route::get('users/mercato-afrique', [ArticleController::class, 'showmercatoafrique'])->name('show.mercatoafrique');
Route::get('/add_mercato', [ArticleController::class, 'addMercato'])->name('add.mercato');
Route::post('/add/mercato', [ArticleController::class, 'store'])->name('store.mercato');
Route::put('/mercato/{id}/update', [ArticleController::class, 'update'])->name('mercato.update');
Route::delete('/mercato/{id}/delete', [ArticleController::class, 'destroy'])->name('mercato.destroy');
Route::get('/article/{slug}', [ArticleController::class, 'showdetail'])->name('articles.show');

//actualites sportives

Route::post('/store/actusport', [ArticleController::class, 'storeactus'])->name('store.actusport');
Route::get('/add/actusport', [ArticleController::class, 'AddActus'])->name('add.actus');
Route::get('/actusport/afrique', [ArticleController::class, 'ShowActusAfrique'])->name('show.actuafrique');
Route::get('/actusport/europe', [ArticleController::class, 'ShowActusEurope'])->name('show.actueurope');
Route::put('/actus/{id}/update', [ArticleController::class, 'updateactu'])->name('actus.update');
Route::delete('/actus/{id}/delete', [ArticleController::class, 'destroyactu'])->name('actus.destroy');
// Route::get('/article/{id}', [ArticleController::class, 'showdetail'])->name('articles.show');
Route::get('/actuarticleafrique-europe/{slug}', [ArticleController::class, 'showdetailafrique'])->name('actuafrique.detail');

//omnisport

Route::get('/omnisports', [OmnisportController::class, 'showOmnisport'])->name('show.omnisport');
Route::get('/omnisport-details/article/{slug}', [OmnisportController::class, 'showdetail'])->name('articles.show.omnisport');
Route::get('/create/omnisport', [OmnisportController::class, 'createOmnisport'])->name('create.omnisport');
Route::post('/store/omnisport', [OmnisportController::class, 'storeOmnisport'])->name('store.omnisport');
Route::put('/omnisport/{id}/update', [OmnisportController::class, 'update'])->name('omnisport.update');
Route::delete('/omnisport/{id}/delete', [OmnisportController::class, 'destroy'])->name('omnisport.destroy');

//Wags

Route::get('/wags', [WagsController::class, 'showWags'])->name('show.wags');
Route::get('/wags-details/article/{slug}', [WagsController::class, 'showdetailWags'])->name('articles.show.wags');
Route::get('/create/wags', [WagsController::class, 'createWag'])->name('create.wag');
Route::post('/store/wags', [WagsController::class, 'storeWag'])->name('store.wag');
Route::put('/wags/{id}/update', [WagsController::class, 'update'])->name('wag.update');
Route::delete('/wags/{id}/delete', [WagsController::class, 'destroy'])->name('wag.destroy');

//celebrite

Route::get('/celebrites', [CelebriteController::class, 'showCelebrites'])->name('show.celebrites');
Route::get('/celebrite-sportives-details/article/{slug}', [CelebriteController::class, 'showdetailCelebrite'])->name('articles.show.celebrite');
Route::get('/create/celebrite', [CelebriteController::class, 'createCelebrite'])->name('create.celebrite');
Route::post('/store/celebrite', [CelebriteController::class, 'storeCelebrite'])->name('store.celebrite');
Route::put('/celebrite/{id}/update', [CelebriteController::class, 'update'])->name('celebrite.update');
Route::delete('/celebrite/{id}/delete', [CelebriteController::class, 'destroy'])->name('celebrite.destroy');


//Contact
Route::get('/contact', [ContactController::class, 'show'])->name('show.contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

//Newsletter Subscription
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

//All Articles
Route::get('/all-articles', [AllarticleController::class, 'allArticles'])->name('articles.all');


//subscribe
Route::get('/subscribes', [NewsletterController::class, 'showSubscribe'])->name('show.subscribe');


Route::get('mercato/search', [ArticleController::class, 'searchmercato'])->name('mercato.search');

//Route collaborateur & Admin
Route::middleware(['checkauth'])->group(function () {
    Route::get('/mercato', [ArticleController::class, 'mercato'])->name('mercato');
    Route::get('/admin/actualites', [ArticleController::class, 'showActu'])->name('show.actu');
    Route::get('/admin/users', [CollaborateurController::class, 'index'])->name('admin.users.index');


    Route::get('/omnisport', [OmnisportController::class, 'omnisports'])->name('omnisports');
    Route::get('/dashboard', [DashbordController::class, 'dashboard'])->name('dashboard');
    Route::get('/wag', [WagsController::class, 'wags'])->name('wags');
    Route::get('/celebrite', [CelebriteController::class, 'celebrites'])->name('celebrites');


    Route::get('/profile', [ProfilController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [ProfilController::class, 'update'])->name('profile.update');
    //nice done
    Route::get('/articles/mois/{month}', [ArticleController::class, 'showByMonth'])->name('articles.byMonth');

    Route::post('/admin/users', [CollaborateurController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [CollaborateurController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [CollaborateurController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/users/{user}/suspend', [CollaborateurController::class, 'suspend'])->name('admin.users.suspend');
    Route::post('/admin/users/{user}/activate', [CollaborateurController::class, 'activate'])->name('admin.users.activate');
});

Route::get('/articles/tag/{tag}', [ArticleController::class, 'articlesByTag'])->name('articles.byTag');


Route::post('/comments', [CommentaireController::class, 'store'])->name('comments.store');

Route::get('/medias', [ArticleController::class, 'getMedias'])->name('medias.list');


// routes/web.php
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search.ajax'); // AJAX
Route::get('/search/results', [App\Http\Controllers\SearchController::class, 'results'])->name('search.results'); // Page résultats


// routes/web.php
Route::get('/tags/suggestions', [TagController::class, 'suggestions'])->name('tags.suggestions');

Route::get('/articles/auteur/{type}/{id}', [App\Http\Controllers\ArticleController::class, 'byAuthor'])
    ->name('articles.byAuthor');
