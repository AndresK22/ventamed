@extends('layout.indexDash')
@section('title','Medicamentos')

@section('content')

@if (session('status'))
< class="row">
    <div class="col s12">
        <div class="card light-green darken-1">
        <div class="card-content white-text">
            <p>{{ session('status') }}</p>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col s12 center-align">
        <h3>Entradas</h3>
    </div>
</div>

@section('js_user_page')
<script type="text/javascript">
</script>
@endsection

@endsection