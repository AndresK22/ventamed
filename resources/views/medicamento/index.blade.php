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
        <h3>Medicamentos</h3>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <table class="striped highlight responsive-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Item Name</th>
                    <th>Item Price</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Alvin</td>
                    <td>Eclair</td>
                    <td>$0.87</td>
                </tr>
                <tr>
                    <td>Alan</td>
                    <td>Jellybean</td>
                    <td>$3.76</td>
                </tr>
                <tr>
                    <td>Jonathan</td>
                    <td>Lollipop</td>
                    <td>$7.00</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@section('js_user_page')
<script type="text/javascript">
</script>
@endsection

@endsection