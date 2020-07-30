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
                    <form action="{{ route('company.update')  }}" method="post" autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $company->name }}" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $company->phone }}" aria-describedby="emailHelp">
                            @error('phone')
                                <span class="text-danger"> {{ $message  }} </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $company->email }}" aria-describedby="emailHelp">
                            @error('email')
                                <span class="text-danger"> {{ $message  }} </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $company->address }}" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        @if(\Session::has('status'))
                            <span class="text-success"> Registro actualizado </span>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
