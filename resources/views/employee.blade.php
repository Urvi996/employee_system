<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>

<form id="employeeForm" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="employee_code">Employee Code:</label>
        <input type="text" id="employee_code" name="employee_code" readonly>
    </div>
    <div>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
    </div>
    <div>
        <label for="joining_date">Joining Date:</label>
        <input type="text" id="joining_date" name="joining_date" class="datepicker">
    </div>
    <div>
        <label for="profile_image">Profile Image (max 2MB):</label>
        <input type="file" id="profile_image" name="profile_image" accept="image/*">
    </div>
    <button type="submit">Submit</button>
</form>

<script>
    $(document).ready(function() {
        // Auto-generate Employee Code
        //let employeeCode = 'EMP-' + ('000' + Math.floor(Math.random() * 9999 + 1)).slice(-4);
        //$('#employee_code').val(employeeCode);

        // Datepicker
        $('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd'  // Set the format to YYYY-MM-DD
});

        // Form submission using Ajax
        $('#employeeForm').on('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '/submit-employee',  // Update with your Laravel route
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Employee added successfully!');
                    $('#employeeForm')[0].reset();  // Reset form fields
                    // $('#employee_code').val('EMP-' + ('000' + Math.floor(Math.random() * 9999 + 1)).slice(-4));  // Generate new code
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
