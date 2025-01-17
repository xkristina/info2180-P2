</head>
<link rel="stylesheet" href="new_contact.css">

<body>
    <?php

    session_start();
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dolphin_crm';

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    $assigned_to_query = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM users");
    $assigned_to_options = $assigned_to_query->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $telephone = $_POST['telephone'];
        $type = $_POST['type'];
        $email = $_POST['email'];
        $company = $_POST['company'];
        $assigned_to = $_POST['assigned_to'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $created_by = $_SESSION['id'];

        $stmt = $conn->prepare("INSERT INTO Contacts 
        (title, firstname, lastname, telephone, type, email, company, assigned_to, created_at, updated_at, created_by) 
        VALUES (:title, :firstname, :lastname, :telephone, :type, :email, :company, :assigned_to, :created_at, :updated_at, :created_by)");

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':assigned_to', $assigned_to);
        $stmt->bindParam(':updated_at', $updated_at);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':created_by', $created_by);

        $stmt->execute();

        header("Location: dashboard.php");
        exit();
    }
    ?>

    <h2>New Contact</h2>
    <main class="content-container">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="contact-form">
            <div class="row">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <select class="title-select" name="title" id="title">
                        <option value="mr">Mr</option>
                        <option value="ms">Ms</option>
                        <option value="mrs">Mrs</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Jamari" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" placeholder="McFarlane" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="jamarimcfarlane12@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone:</label>
                    <input type="text" id="telephone" name="telephone" placeholder="876-678-4356">
                </div>


            </div>

            <div class="row">
                <div class="form-group">
                    <label for="company">Company:</label>
                    <input type="text" id="company" name="company" placeholder="UWI">
                </div>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select name="type" id="type">
                        <option value="SalesLead">Sales Lead</option>
                        <option value="Support">Support</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="assigned_to">Assigned To:</label>
                    <select name="assigned_to" id="assigned_to">
                        <?php foreach ($assigned_to_options as $option): ?>
                            <option value="<?php echo $option['id']; ?>">
                                <?php echo $option['fullname']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>


            <div class="btn-container">
                <input class="save-btn" type="submit" value="Save">

            </div>

        </form>
    </main>

</body>

</html>