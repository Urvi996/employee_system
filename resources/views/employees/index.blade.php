<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .btn-primary {
            margin-bottom: 20px;
        }
        .alert {
            margin-bottom: 20px;
        }
        table img {
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Employees List</h1>
        
        <div>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Create Employee</a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="form-row mb-3">
            <div class="form-group col-md-5">
                <label for="minDate">Start Date:</label>
                <input type="text" id="minDate" name="minDate" class="form-control">
            </div>
            <div class="form-group col-md-5">
                <label for="maxDate">End Date:</label>
                <input type="text" id="maxDate" name="maxDate" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>
                <button id="filter" class="btn btn-info btn-block">Filter</button>
            </div>
        </div>

        <table id="employeeTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Employee Code</th>
                    <th>Profile Image</th>
                    <th>Full Name</th>
                    <th>Joining Date</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        $("#minDate, #maxDate").datepicker({
            dateFormat: "yy-mm-dd"
        });

        var table = $('#employeeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("employees.ajax") }}', 
                type: 'GET', 
                data: function(d) {
                    d.minDate = $('#minDate').val(); 
                    d.maxDate = $('#maxDate').val(); 
                }
            },
            columns: [
                { data: 'employee_code' },
                { 
                    data: 'profile_image', 
                render: function(data, type, row) {
                    const imagePath = data ? `/storage/${data}` : '/path/to/default/image.png';
                    return `<img src="${imagePath}" alt="Profile Image" width="50" height="50">`;
                }                },
                { data: 'full_name' },
                { data: 'joining_date' }
            ]
        });

        $('#filter').click(function() {
            table.ajax.reload(); 
        });
    });
    </script>

</body>
</html>
