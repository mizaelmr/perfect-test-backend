@extends('layout')
@section('content')
<meta name="_token" content="{{ csrf_token() }}">
<h1>Adicionar / Editar Produto</h1>
<div class='card'>
    <div class='card-body'>
        <form id="form" action="{{route('products.store')}}" method="POST">
            <div class="form-group">
                <label for="name">Nome do produto</label>
                <input type="text" class="form-control " name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea type="text" rows='5' class="form-control" name="description" id="description"
                    required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="100,00 ou maior" required>
            </div>
            <button type="submit" id="btnSubmit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('js/mask.js')}}"></script>
<script>
    //mask
    $('#price').mask('000.000.000.000.000,00', {reverse: true});

    //alert
    function alert(title, message, icon){
        Swal.fire({
            title: title,
            icon: icon,
            text: message,
            showCloseButton: true,
        }).then((result) => {
            $("#form")[0].reset();
        });
    }

    //submit
    $('#form').on('submit', function(e){
        e.preventDefault();
        $('#btnSubmit').attr('disabled', true);

        var form = $('#form').serializeArray();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'post',
            url: "{{route('products.store')}}",
            data: form,
            success: function(e){
                console.log(e);
                $('#btnSubmit').attr('disabled', false);
                alert('Sucesso!', 'Produto cadastrado com sucesso!', 'success');
            },
            error: function(e){
                alert('Erro!', 'Produto não cadastrado' + e.message, 'error');
                $('#btnSubmit').attr('disabled', false);
            }
        });

    });
</script>
@endsection
