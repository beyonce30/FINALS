<?php
session_start();

// Team members array
$members = [
    [
        "name" => "Richmond Yabut",
        "role" => "Group Leader",
        "age" => 25,
        "birthplace" => "Muntinlupa",
        "student_status" => "A 3rd year BSIT Student",
        "employment" => "Working Student",
        "img" => "richmond.jpg",
        "link" => "https://www.instagram.com/zenkii.y/?igsh=MTE4c2Z5bmxvdWZh"  
    ],
    [
        "name" => "Rongavilla Almar",
        "role" => "Member",
        "age" => 20,
        "birthplace" => "Muntinlupa",
        "student_status" => "A 3rd year BSIT Student",
        "employment" => "Working Student",
        "img" => "Almar.jpg",
        "link"=> "https://www.facebook.com/25rongavilla?mibextid=ZbWKwL"  
    ],
    [
        "name" => "Angelo Coronejo",
        "role" => "Member",
        "age" => 20,
        "birthplace" => "Pasig City",
        "student_status" => "A 3rd year BSIT Student",
        "employment" => "Working Student",
        "img" => "Angelo.jpg",
        "link" => "https://www.instagram.com/guevarra__angelo?igsh=c2VwcW52bnA3cjJ1"
    ],
    [
        "name" => "Beyonce Ciprez",
        "role" => "Member",
        "age" => 20,
        "birthplace" => "Muntinlupa",
        "student_status" => "A 3rd year BSIT Student",
        "employment" => "Fulltime Student",
        "img" => "Beyonce.jpg",
        "link" => "https://www.instagram.com/yceecey?igsh=MXV6NnRjb3NtOG12Yw%3D%3D&utm_source=qr"
    ],
    [
        "name" => "Jan Lea Capones",
        "role" => "Member",
        "age" => 20,
        "birthplace" => "Muntinlupa",
        "student_status" => "A 3rd year BSIT Student",
        "employment" => "Working Student",
        "img" => "Lea.jpg",
        "link" => "https://www.instagram.com/perty_lea?igsh=MWd6NnZxNGxpeWtnaA=="
    ]
];

// Handle form submission for new team member
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_member'])) {
    // (your existing logic for adding a new member)
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Hardcoded credentials for testing (replace with database check in production)
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    if ($username === 'admin' && $password === 'password') { // Change these values for security
        $_SESSION['loggedin'] = true; // Set a session variable to indicate the user is logged in
    } else {
        $login_error = "Invalid username or password.";
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Meet Group 2</h1>
        </div>
    </header>
    
    <div class="container">
        <!-- Display Login Form if not logged in -->
        <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
            <h2>Login</h2>
            <?php if (isset($login_error)): ?>
                <p style='color:red;'><?php echo $login_error; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit" name="login">Login</button>
            </form>
        <?php else: ?>
            <!-- Display Last Visited Link from Cookie -->
            <?php
            if (isset($_COOKIE['last_visited_link'])) {
                echo "<p>Last visited profile: <a href='{$_COOKIE['last_visited_link']}' target='_blank'>{$_COOKIE['last_visited_link']}</a></p>";
            }
            ?>

            <div class="team">
                <?php
                foreach ($members as $member) {
                    $link = isset($member['link']) ? $member['link'] : "#";  // Default link if not provided

                    echo "
                    <a href='{$link}' class='team-member' target='_blank' onclick='confirmLink(event)'>
                        <img src='{$member['img']}' alt='Member'>
                        <h2>{$member['name']}</h2>
                        <p>{$member['role']}</p>
                        <p>AGE: {$member['age']}</p>
                        <p>Birthplace: {$member['birthplace']}</p>
                        <p>{$member['student_status']}</p>
                        <p>{$member['employment']}</p>
                    </a>";
                }
                ?>

                <!-- Form to Add New Team Member -->
                <h2>Add a new team member</h2>
                <form id="VALIDATION" action="" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>
                    <label for="role">Role:</label>
                    <input type="text" id="role" name="role" required><br>
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required><br>
                    <label for="birthplace">Birthplace:</label>
                    <input type="text" id="birthplace" name="birthplace" required><br>
                    <label for="student_status">Student Status:</label>
                    <input type="text" id="student_status" name="student_status" required><br>
                    <label for="employment">Employment:</label>
                    <select id="employment" name="employment" required>
                        <option value="Working Student">Working Student</option>
                        <option value="Fulltime Student">Fulltime Student</option>
                    </select><br>
                    <label for="img">Image:</label>
                    <input type="text" id="img" name="img" required><br>
                    <label for="link">Profile Link:</label>
                    <input type="text" id="link" name="link" required><br>
                    <button type="submit" name="add_member">Submit</button>
                </form>

                <!-- Display Newly Added Member Using Session -->
                <?php
                if (isset($_SESSION['new_member'])) {
                    $member = $_SESSION['new_member'];
                    echo "
                    <div class='new-member-output'>
                        <h3>New member added:</h3>
                        <p><strong>Name:</strong> {$member['name']}</p>
                        <p><strong>Role:</strong> {$member['role']}</p>
                        <p><strong>Age:</strong> {$member['age']}</p>
                        <p><strong>Birthplace:</strong> {$member['birthplace']}</p>
                        <p><strong>Student Status:</strong> {$member['student_status']}</p>
                        <p><strong>Employment:</strong> {$member['employment']}</p>
                        <p><strong>Profile Link:</strong> <a href='{$member['link']}' target='_blank'>{$member['link']}</a></p>
                    </div>";
                }
                ?>

                <!-- Logout Button -->
                <form action="" method="POST">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
