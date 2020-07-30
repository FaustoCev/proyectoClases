@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-4">
                <div class="card-title">
                    Datos de la empresa
                </div>
                <div class="card-body">
                    <form action="{{ route('company.update', $company->id)  }}" method="post" autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $company->name }}" aria-describedby="nameHelp">
                            @error('name')
                                <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $company->phone }}" aria-describedby="emailHelp">
                            @error('phone')
                                <small id="phoneHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $company->email }}" aria-describedby="emailHelp">
                            @error('email')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $company->address }}" aria-describedby="emailHelp">
                            @error('address')
                                <small id="addressHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        @if(\Session::has('status'))
                            <div class="alert alert-success fade show mt-2" role="alert">
                                Registro editado exitosamente.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
