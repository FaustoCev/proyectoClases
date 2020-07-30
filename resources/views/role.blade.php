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
                    <button id="closeForm" type="button" class="btn btn-secondary">Cancelar</button>
                    <div id="errors" class="alert-danger mt-2"></div>
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

            let url = "{{ url('api/v1/roles')  }}"

            //adecuación para editar
            let id = document.getElementById("id");

            if (id && id.value) {
                form.push({"name":"_method", "value":'PUT'});
                url = url+"/"+id.value
            }
            //fin adecuación para editar

            $.ajax({
                type : "post",
                url : url,
                data: form,
                success: function(data){
                    alert(data.status);
                    clearForm();
                    closeModal();
                    reloadData()
                },
                error: function(data){
                    let error = $.parseJSON(data.responseText);
                    showErrors(error.errors);
                }
            })


        })

        $(document).on('click','button.delete-role',function(){

            if (confirm('¿Desea realmente eliminar el registro?')) {
                let id =  $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ url('api/v1/roles')  }}"+"/"+id,
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data)
                    {
                        alert(data.status);
                        reloadData();
                    },
                    error: function(error){
                        alert('ha ocurrido un error')
                    }
                });
            }


        })

        //se ejecuta cuando se da click en el botón editar
        $(document).on('click','button.edit-role',function(){
            fillForm($(this).data('role'));
            openModal();
        });

        //se ejecuta cuando se da click en el botón eliminar
        $(document).on('click','button#closeForm',function(){
            clearForm();
            closeModal();
        });

        //función que recarga los datos del datatable
        function reloadData(){
            $("#roleTable").DataTable().ajax.reload();
        }

        //funcion que permite visualizar errores
        function showErrors(errors){
            let message = '<span class="p-2">';
            $.each(errors, function (key,value) { message += value + "\n"; });
            message += '</span>';
            $('#errors').html(message);
        }

        function fillForm(data){
            document.getElementById('id').value = data.id;
            document.getElementById('description').value = data.description;
        }

        function clearForm(){
            document.getElementById('id').value = '';
            $('#roleForm')[0].reset();
            $('#errors').html('');
        }

        //funciones de ayuda para el formulario modal
        function closeModal(){ $("#roleModal").modal('hide'); }

        function openModal(){ $("#roleModal").modal('show'); }

        $(function(){
            $('#roleModal').on('hide.bs.modal', function (event) {
                clearForm();
            })
        });
    </script>
@endsection
