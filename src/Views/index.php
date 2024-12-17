<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <form method="GET" class="mt-4">
        <div class="row">
            <div class="col-md-3">
                <label for="employee_name" class="form-label">Employee Name</label>
                <input type="text" id="employee_name" name="employee_name" placeholder="Employee Name"
                       class="form-control" value="<?= htmlspecialchars($_GET['employee_name'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" id="event_name" name="event_name" placeholder="Event Name" class="form-control"
                       value="<?= htmlspecialchars($_GET['event_name'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" name="date" class="form-control"
                       value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    <div class="mt-4  table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Employee Name</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['employee_name']) ?></td>
                    <td><?= htmlspecialchars($row['event_name']) ?></td>
                    <td><?= htmlspecialchars($row['event_date']) ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?= htmlspecialchars($totalPrice) ?></strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
