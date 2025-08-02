<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Company</title>
</head>
<body>
    <h1>Welcome, {{ $name }}!</h1>
    
    <p>{{ $welcome_message }}</p>
    
    @if($employee)
        <h3>Your Details:</h3>
        <ul>
            <li><strong>Employee ID:</strong> {{ $employee->employee_id }}</li>
            <li><strong>Position:</strong> {{ $employee->position }}</li>
            <li><strong>Department:</strong> {{ $employee->department }}</li>
            <li><strong>Start Date:</strong> {{ $start_date ? \Carbon\Carbon::parse($start_date)->format('F j, Y') : 'TBD' }}</li>
        </ul>
    @endif
    
    <p>We look forward to working with you!</p>
    
    <p>Best regards,<br>
    HR Team</p>
</body>
</html>