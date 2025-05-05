<?php
include 'db.php';

if (isset($_POST['add'])) {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $enroll_date = $_POST['enrollment_date'];
    $conn->query("INSERT INTO students (full_name, email, enrollment_date) VALUES ('$name', '$email', '$enroll_date')");
    header("Location: students.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    header("Location: students.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $enroll_date = $_POST['enrollment_date'];
    $conn->query("UPDATE students SET full_name='$name', email='$email', enrollment_date='$enroll_date' WHERE id=$id");
    header("Location: students.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f6ff;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        h2 {
            color: #5e35b1;
        }

        form {
            background: #fff;
            padding: 20px;
            border: 2px solid #d1c4e9;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            margin-bottom: 40px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            padding: 12px;
            width: calc(45% - 10px);
            margin: 10px 5px;
            border: 1px solid #b39ddb;
            border-radius: 6px;
        }

        button {
            padding: 10px 20px;
            background: #7e57c2;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #5e35b1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #7e57c2;
            color: white;
        }

        tr:hover {
            background: #f3e5f5;
        }

        a {
            color: #5e35b1;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            margin: 40px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Student</h2>
    <form method="POST">
        <input name="full_name" type="text" placeholder="Full Name" required>
        <input name="email" type="email" placeholder="Email Address" required><br>
        <input name="enrollment_date" type="date" required>
        <button type="submit" name="add">Add Student</button>
    </form>

    <h2>Student List</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Enrollment Date</th><th>Actions</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM students");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['full_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['enrollment_date'] ?></td>
            <td>
                <a href="students.php?edit=<?= $row['id'] ?>">Edit</a>
                <a href="students.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])):
        $id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM students WHERE id=$id");
        $data = $result->fetch_assoc();
    ?>
    <hr>
    <h2>Update Student</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <input name="full_name" value="<?= $data['full_name'] ?>" required>
        <input name="email" value="<?= $data['email'] ?>" required><br>
        <input name="enrollment_date" type="date" value="<?= $data['enrollment_date'] ?>" required>
        <button type="submit" name="update">Update Student</button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
