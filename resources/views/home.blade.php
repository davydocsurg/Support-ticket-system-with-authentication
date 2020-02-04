@extends('layouts.app')
<style>
    .lnk {
        color : blue;
        font-size: 15px;
        font-family: arial;
        font-weight: 100;
    }

    .lnk:hover{
        color: red;
        font-family: cursive;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                  
                    <div>
                    
                        Welcome to Davy's ticket system, you can create a new ticket by 
                        clicking on <a href="/new_ticket" class='lnk'>this link</a>
                    
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
