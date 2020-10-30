@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search User</div>
                <form method="POST" id="frmSearchUser">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="txtsearch" class="col-md-4 col-form-label text-md-right">{{ __('Keyword') }}</label>
                            <div class="col-md-6">
                                <input id="txtsearch" type="text" class="form-control @error('txtsearch') is-invalid @enderror" name="password" required autocomplete="new-txtsearch">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary global_search">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>

                        <table id='empTable' width='100%' border="1" style='border-collapse: collapse;'>
                            <thead>
                                <tr>
                                    <td>S.no</td>
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Email</td>
                                    <td>Phone</td>
                                    <td>Technologies</td>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $.noConflict();
        // DataTable
        $('#empTable').DataTable({
            processing: true,
            serverSide: true,
            "deferLoading": 0,
            searching: false,
            ajax: {
                "url": "{{route('search_users')}}",
                "type": "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "data":{
                    txtSearch:$("#txtSearch").val()
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'first_name'
                },
                {
                    data: 'last_name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phone_number'
                },
                {
                    data: 'technologies'
                }
            ]
        });

    });
    $(document).on("click", '.global_search', function() {
        $("#empTable").DataTable().draw();
    });
</script>
@endsection