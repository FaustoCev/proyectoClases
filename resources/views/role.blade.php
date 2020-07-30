@extends('layouts.admin')

@section('content')
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" aria-describedby="descriptionHelp">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary">Cancelar</button>
                    @if(\Session::has('status'))
                        <span class="text-success"> Registro actualizado </span>
                    @endif
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Listado de Roles</div>

                <div class="card-body">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#roleModal">
                                    Agregar un rol
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-4">
                                <table id="roleTable" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#roleTable').DataTable({
            "ajax": '{{ route('roles.index') }}',
            columns: [
                {"data": "id" },
                {"data": "description"},
                {
                    "mData": "id",
                    "mRender": function(data,type,row){
                        return "<button class='edit-role' data-role='"+ JSON.stringify(row) +"'>editar</button>" +
                            "<button class='delete-role' data-id='"+ row.id +"' >eliminar</button>"
                    }
                }
            ]
        })

        $('#roleForm').submit(function(e){
            e.preventDefault();

            let form = $(this).serializeArray()

            let url = '{{ route('roles.store') }}'

            $.ajax({
                type : "post",
                url : url,
                data: form,
                success: function(data){
                    console.log(data)
                },
                error: function(error){
                    console.log(error)
                }
            })


        })

        $(document).on('click','button.delete-role',function(){
            let id = $(this).data('id');
            let url = '{{ url('api/v1/roles')  }}'+'/'+id;

            $.ajax({
                type : "post",
                url : url,
                dataType: 'JSON',
                data: {
                    'id': id,
                    '_method': 'DELETE',
                    '_token': '{{ csrf_token()  }}'
                },
                success: function(data){
                    console.log(data)
                },
                error: function(error){
                    console.log(error)
                }
            })
        })
    </script>
@endsection
