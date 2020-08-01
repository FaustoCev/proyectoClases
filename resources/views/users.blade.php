@extends('layouts.admin')

@section('content')
<div class="modal fade" id="userModal" tabindex="-1" user="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label for="roles">Asignar roles</label>
                        <select class="form-control" name="roles[]" id="roles" multiple>
                            <option>Seleccione el valor</option>
                        </select>
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
                <div class="card-header">Listado de Usuarios</div>

                <div class="card-body">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal">
                                    Agregar un usuario
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-4">
                                <table id="userTable" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
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

        $(document).ready(function(){

            let url = '{{ route('roles.index') }}'

            $.ajax({
                type : "get",
                url : url,
                dataType: 'JSON',
                success: function(response){
                    let roles = response.data
                    $("#roles").empty();
                    roles.forEach(function(role){
                        $("#roles").append(" <option value='"+role.id+"'> "+role.description+" </option> ");
                    })
                },
                error: function(data){
                    let error = $.parseJSON(data.responseText);
                    showErrors(error.errors);
                }
            })

        })

        $('#userTable').DataTable({
            "ajax": '{{ route('users.index') }}',
            columns: [
                {"data": "id" },
                {"data": "name"},
                {"data": "email"},
                {"data": "phone"},
                {
                    "mData": "id",
                    "mRender": function(data,type,row){
                        return "<button class='edit-user' data-user='"+ JSON.stringify(row) +"'>editar</button>" +
                            "<button class='delete-user' data-id='"+ row.id +"' >eliminar</button>"
                    }
                }
            ]
        })

        $('#userForm').submit(function(e){
            e.preventDefault();

            let form = $(this).serializeArray()

            let url = "{{ url('api/v1/users')  }}"

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

        $(document).on('click','button.delete-user',function(){

            if (confirm('¿Desea realmente eliminar el registro?')) {
                let id =  $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ url('api/v1/users')  }}"+"/"+id,
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
        $(document).on('click','button.edit-user',function(){
            fillForm($(this).data('user'));
            openModal();
        });

        //se ejecuta cuando se da click en el botón eliminar
        $(document).on('click','button#closeForm',function(){
            clearForm();
            closeModal();
        });

        //función que recarga los datos del datatable
        function reloadData(){
            $("#userTable").DataTable().ajax.reload();
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
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('phone').value = data.phone;

            let roles = data.roles.map(function(role){
                return role.id
            });

            $('#roles').val(roles);
        }

        function clearForm(){
            document.getElementById('id').value = '';
            $('#userForm')[0].reset();
            $('#errors').html('');
        }

        //funciones de ayuda para el formulario modal
        function closeModal(){ $("#userModal").modal('hide'); }

        function openModal(){ $("#userModal").modal('show'); }

        $(function(){
            $('#userModal').on('hide.bs.modal', function (event) {
                clearForm();
            })
        });
    </script>
@endsection
