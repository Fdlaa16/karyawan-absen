<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <img src="data:image/png;base64,{{ base64_encode(QrCode::size(100)->generate($employeeId)) }}" alt="QR Code" style="width: 100%">
</body>
</html>
