@extends('layout')

@section('content')
<meta name="_token" content="{{ csrf_token() }}">
<h1>Dashboard de vendas</h1>
<div class='card mt-3'>
    <div class='card-body'>
        <h5 class="card-title mb-5">Tabela de vendas
            <button class='btn btn-secondary float-right btn-sm rounded-pill' id="btnNewSale">
                <i class='fa fa-plus'></i> Nova venda
            </button>
        </h5>
        <form id="filtroVendas">
            <div class="form-row align-items-center">
                <div class="col-sm-5 my-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Clientes</div>
                        </div>
                        <select class="form-control" name="cliente" id="inlineFormInputName">
                            <option>Clientes</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 my-1">
                    <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Período</div>
                        </div>
                        <input type="text" class="form-control date_range" name="dateFilter"
                            id="inlineFormInputGroupUsername" placeholder="Username">
                    </div>
                </div>
                <div class="col-sm-1 my-1">
                    <button type="submit" class="btn btn-primary" id="btnFiltro" style='padding: 14.5px 16px;'>
                        <i class='fa fa-search'></i></button>
                </div>
            </div>
        </form>
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">
                        Produto
                    </th>
                    <th scope="col">
                        Data
                    </th>
                    <th scope="col">
                        Valor
                    </th>
                    <th scope="col">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody id="listVendas">
                {{-- list sales --}}
            </tbody>

        </table>
    </div>
</div>
<div class='card mt-3'>
    <div class='card-body'>
        <h5 class="card-title mb-5">Resultado de vendas</h5>
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">
                        Status
                    </th>
                    <th scope="col">
                        Quantidade
                    </th>
                    <th scope="col">
                        Valor Total
                    </th>
                </tr>
            </thead>
            <tbody id="listStatus">
                {{-- list --}}
            </tbody>

        </table>
    </div>
</div>

<div class='card mt-3'>
    <div class='card-body'>
        <h5 class="card-title mb-5">Produtos
            <button class='btn btn-secondary float-right btn-sm rounded-pill' id="btnNewProduct">
                <i class='fa fa-plus'></i> Novo produto
            </button>
        </h5>
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">
                        Nome
                    </th>
                    <th scope="col">
                        Valor
                    </th>
                    <th scope="col" style="width: 30%">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody id="listBodyProd">
                {{-- listagem --}}
            </tbody>
        </table>
    </div>
</div>

{{-- modais --}}

<div class="modal" id="modalProduto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">cadastro de produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nome do produto</label>
                        <input type="text" class="form-control " name="name" id="name" required>
                        <input type="hidden" name="id" id="idProduct">
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea type="text" rows='5' class="form-control" name="description" id="description"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Preço</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="100,00 ou maior"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSubmitProduct" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" id="modalSale" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSale">
                <div class="modal-body">
                    <h5>Informações do cliente</h5>
                    <div class="form-group">
                        <label for="name">Nome do cliente</label>
                        <input type="text" class="form-control " name="name" id="name" required>
                        <input type="hidden" name="id" id="idsale">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" name="cpf" id="cpf" required placeholder="99999999999">
                    </div>
                    <h5 class='mt-5'>Informações da venda</h5>
                    <div class="form-group">
                        <label for="product">Produto</label>
                        <select name="product" class="form-control" id="selectForm" required>
                            <option value="">Escolha...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Data</label>
                        <input type="date" class="form-control" name="date" required id="date">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantidade</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" required
                            placeholder="1 a 10">
                    </div>
                    <div class="form-group">
                        <label for="discount">Desconto</label>
                        <input type="text" class="form-control" id="discount" name="discount" required
                            placeholder="100,00 ou menor">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">Escolha...</option>
                            <option value="Aprovado">Aprovado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Devolvido">Devolvido</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSubmitSale" class="btn btn-primary">Salve</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('js/mask.js')}}"></script>
<script>
    //mask
    $('#price').mask('0000000,00', {reverse: true});
    $('#discount').mask('000,00', {reverse: true});
    $('#cpf').mask('000.000.000-00', {reverse: true});
    

    //botao abre modal de cadastro de produto
    $('#btnNewProduct').on('click', function(){
        $("#form")[0].reset();
        $('#modalProduto').modal();
    });
    //botao abre modal de cadastro de vendas
    $('#btnNewSale').on('click', function(){
        $('#modalSale').modal();
    });

    //alert
    function alert(title, message, icon){
        Swal.fire({
            title: title,
            icon: icon,
            text: message,
            showCloseButton: true,
        }).then((result) => {
            $("#form")[0].reset();
            $('#modalProduto').modal('hide');
            setTimeout(()=>{
                window.location.reload();
            },1000)
        });
    }

    //request
    function requestAjax(url, type, data){
       return $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: type,
            url: url,
            data: data ?? null,
            success: function(e){
                $('#btnSubmitProduct').attr('disabled', false);
                if(type !== 'get'){
                    alert('Sucesso!', 'Requisição realizada com sucesso!', 'success');
                }
            },
            error: function(e){
                alert('Erro!', 'Não foi possivel realizar a requisição.'+ e.message, 'error');
                $('#btnSubmitProduct').attr('disabled', false);
            }
        }).then( e => {
            return e;
        });
    }
    
    //listagem de view
    $(document).ready(async function(){
      //listagem de vendas 
        const sale = await new Promise(resolve => {
            const result = requestAjax("{{route('sale.index')}}", 'get', null);
            resolve(result);
        });

        sale.data.map(function(e) {
            let moeda = e.total.toLocaleString('pt-br',{style: 'currency'});
            
            $('#listVendas').append(
                '<tr>'+
                    '<td>'+e.product_id+'</td>'+
                    '<td>'+e.dateSale+'</td>'+
                    '<td>R$ '+moeda+'</td>'+
                    '<td>'+
                       ' <a class="btn btn-primary" id="editSale" data-id="'+e.id+'">Editar</a>'+
                    '</td>'+
                '</tr>'
            );
        });


        const status = await new Promise(resolve => {
            const result = requestAjax("/sale/resume", 'get', null);
            resolve(result);
        });

        status.map(function(e){
            let moeda = e.sum.toLocaleString('pt-br',{style: 'currency'});
            $('#listStatus').append(
                '<tr>'+
                    '<td>'+e.status+'</td>'+
                    '<td>'+e.count+'</td>'+
                    '<td> R$'+moeda+'</td>'+
                '</tr>'
            );
        });


       //listagem de produtos
        const products = await new Promise(resolve => {
            const result = requestAjax("{{route('products.index')}}", 'get', null);
            resolve(result);
        });    
        
        //list the table products
        products.data.map(function(e){
            let moeda = e.price.toLocaleString('pt-br',{style: 'currency'});
            $('#listBodyProd').append(
                '<tr>'+
                    '<td>'+e.name+'</td>'+
                    '<td> R$'+moeda+'</td>'+
                    '<td>'+
                        '<a class="btn btn-primary" id="btnEdit" data-id="'+e.id+'">Editar</a>'+
                        '<a class="btn btn-danger" id="btnDellP" data-id="'+e.id+'">Excluir</a>'+
                    '</td>'+
                '</tr>'
            );
        });
        
        //list dropDown
        products.data.map(function(e){
            $('#selectForm').append('<option value="'+e.id+'">'+e.name+'</option>');
        });


        //clients
        const Clients = await new Promise(resolve => {
            const result = requestAjax("{{route('client.index')}}", 'get', null);
            resolve(result);
        });

        //list dropDown
        Clients.data.map(function(e){
            $('#inlineFormInputName').append('<option value="'+e.id+'">'+e.name+'</option>');
        });

    
        $(document).on('click', '#btnDellP', function(e){
            var btn = $(this).attr('data-id');
            //request delete
            requestAjax('/products/destroy/'+ btn, 'delete', null);
        });


        //edit produtos
        $(document).on('click', '#btnEdit', async function(e) {
            var btn = $(this).attr('data-id');
            //request delete
            const result = await new Promise(resolve => {
                const e = requestAjax('/products/edit/'+ btn, 'get', null)
                resolve(e);
            });
            $('#modalProduto #name').val(result.data.name);
            $('#modalProduto #description').val(result.data.description);
            $('#modalProduto #price').val(result.data.price);
            $('#modalProduto #idProduct').val(btn);
            $('#modalProduto').modal();
            
        });

        //edit sale
        $(document).on('click', '#editSale', async function(e) {
            var btn = $(this).attr('data-id');
            const result = await new Promise(resolve => {
                const e = requestAjax('/sale/edit/'+ btn, 'get', null)
                resolve(e);
            });
            
            $('#modalSale #name').val(result.data.client_id).attr('readonly', true);
            $('#modalSale #idSale').val(btn);
            $('#modalSale #cpf').val(result.data.client.cpf).attr('readonly', true);
            $('#modalSale #email').val(result.data.client.email).attr('readonly', true);
            $('#modalSale #discount').val(result.data.discount).attr('readonly', true);
            $('#modalSale #quantity').val(result.data.amount).attr('readonly', true);
            $('#modalSale #date').val(result.data.dateSale).attr('readonly', true);
            $('#modalSale #selectForm').append('<option selected value="'+result.data.product.id+'">'+result.data.product_id+'</option>').attr('readonly', true);

            $('#modalSale').modal();



        });

    });      



    //add new product
    $('#form').on('submit', function(e){
        e.preventDefault();
        $('#btnSubmitProduct').attr('disabled', true);
        var form = $('#form').serializeArray();
        if(form[1].value == ""){
           var route = "{{route('products.store')}}";
           var method = "post";
        }else{
            var route = "{{ url('/products/update/' )}}" +'/'+ form[1].value;
           var method = "put";
        }       
        //submit
       requestAjax(route, method, form);        
    });

    $('#formSale').on('submit', function(e){
        e.preventDefault();
        
        $('#btnSubmitSale').attr('disabled', true);
        var form = $('#formSale').serializeArray();
        if(form[1].value == ""){
           var route = "{{route('sale.store')}}";
           var method = "post";
        }else{
            var route = "{{ url('/sale/update/' )}}" +'/'+ form[1].value;
           var method = "put";
        }       
        //submit
       requestAjax(route, method, form);
    });

    $('#filtroVendas').on('submit', function(e){
        e.preventDefault();
        $('#btnFiltro').attr('disabled', true);
        var form = $('#filtroVendas').serializeArray();
        $('#listVendas').empty();
        console.log(form);        
    });

  
</script>

@endsection