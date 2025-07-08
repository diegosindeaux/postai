<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'descricao', 'peso'];

    public function produtoDetalhe()
    {
        return $this->hasOne('App\ProdutoDetalhe');
    }

    public function pedidosProdutos()
    {
        return $this->hasMany(PedidoProduto::class, 'produto_id');
    }
}
