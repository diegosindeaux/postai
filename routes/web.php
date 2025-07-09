<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar as rotas web para sua aplicação. Essas rotas são carregadas
| pelo RouteServiceProvider dentro do grupo "web" middleware. Agora crie algo incrível!
|
*/

// Rotas públicas (não requerem autenticação)
Route::get('/login/{erro?}', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@autenticar')->name('login');

Route::get('/', 'PrincipalController@principal')->name('site.index');
Route::get('/sobre', 'SobreController@sobre')->name('site.sobre');
Route::get('/contato', 'ContatoController@contato')->name('site.contato');
Route::post('/contato', 'ContatoController@salvar')->name('site.contato');

// Rotas do Chatbot (apenas autenticado)
Route::middleware(['auth'])->group(function () {
    Route::get('/chatbot', 'ChatbotController@index')->name('site.chatbot');
    Route::post('/chatbot/send-message', 'ChatbotController@sendMessage')->name('chatbot.sendMessage');
    Route::get('/chatbot/status', 'ChatbotController@checkStatus')->name('chatbot.status');
});

// Rotas de reset de senha
Route::get('/password/reset', 'PasswordResetController@showResetForm')->name('password.reset');
Route::post('/password/send', 'PasswordResetController@sendResetLink')->name('password.send');
Route::get('/password/reset/{token}', 'PasswordResetController@showResetPasswordForm')->name('password.reset.token');
Route::post('/password/update', 'PasswordResetController@resetPassword')->name('password.update');

// Rotas protegidas (requerem autenticação)
Route::prefix('app')->group(function () {
    Route::get('/home', 'HomeController@index')->name('app.home');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/fornecedor', 'FornecedorController@index')->name('app.fornecedor');
    Route::post('/fornecedor/listar', 'FornecedorController@listar')->name('app.fornecedor.listar');
    Route::get('/fornecedor/listar', 'FornecedorController@listar')->name('app.fornecedor.listar');
    Route::get('/fornecedor/adicionar', 'FornecedorController@adicionar')->name('app.fornecedor.adicionar');
    Route::post('/fornecedor/adicionar', 'FornecedorController@adicionar')->name('app.fornecedor.adicionar');
    Route::get('/fornecedor/editar/{id}/{msg?}', 'FornecedorController@editar')->name('app.fornecedor.editar');
    Route::get('/fornecedor/excluir/{id}', 'FornecedorController@excluir')->name('app.fornecedor.excluir');

    Route::resource('produto', 'ProdutoController');
    Route::resource('produto-detalhe', 'ProdutoDetalheController');
    Route::resource('cliente', 'ClienteController');
    Route::resource('pedido', 'PedidoController');

    // Rotas personalizadas para pedido-produto
    Route::get('pedido-produto/create/{pedido}', 'PedidoProdutoController@create')->name('pedido-produto.create');
    Route::post('pedido-produto/store/{pedido}', 'PedidoProdutoController@store')->name('pedido-produto.store');
    Route::delete('pedido-produto.destroy/{pedidoProduto}/{pedido_id}', 'PedidoProdutoController@destroy')->name('pedido-produto.destroy');
});

Route::resource('usuario', 'UsuarioController');

// Rotas para email de verificação
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/complete', 'Auth\VerificationController@complete')->name('verification.complete');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify')->middleware('signed');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend')->middleware(['throttle:6,1', 'auth']);

// Rota para páginas de erro 404
Route::fallback(function () {
    return 'Rota inexistente. <a href="'.route('site.index').'">Clique aqui</a> para voltar à página inicial.';
});
