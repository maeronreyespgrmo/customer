<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <table id="tbl-users" class="table table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>
                    <center>Action</center>
                </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tbl-users').dataTable({
                paging: true,
                lengthChange: true,
                processing: true,
                searching: true,
                serverSide: true,
                autoWidth: true,
                searchDelay: 100,
                pageLength: 10,
                order: [],
                ajax: {
                    url: '/tb',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'first_name'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'password'
                    },
                    {
                        render: function(data, type, row, meta) {

                            return '<C><a href="/accounts/' + row.id +
                                '/edit" class="btn btn-warning btn-xs mb-1"><i class="fa fa-pencil-alt"></i> Edit</a> ' +
                                '<a href="/accounts/' + row.id +
                                '/delete" class="btn btn-danger btn-xs mb-1"><i class="fa fa-pencil-alt"></i> Delete</a> </C>';
                        }
                    }
                ],
                language: {
                    emptyTable: '<center>NO RECORDS FOUND</center>',
                    zeroRecords: '<center>NO MATCHING RECORDS FOUND</center>',
                    processing: 'PROCESSING...',
                },
                scrollX: true,
            });

        });
    </script>
</body>

</html>
