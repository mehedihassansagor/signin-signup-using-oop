<?php
class User {
    private $connection;

    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }

    // Sign Up Method
    public function signUp($name, $email, $password) {
        if (!empty($name) && !empty($email) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO student (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            
            if (mysqli_query($this->connection, $sql)) {
                return true;
            } else {
                return "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        } else {
            return "Please fill in all fields.";
        }
    }

    // Sign In Method
    public function signIn($email, $password) {
        if (!empty($email) && !empty($password)) {
            $sql = "SELECT * FROM student WHERE email='$email'";
            $result = mysqli_query($this->connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $user['name'];
                    $_SESSION['message'] = "Your sign in is complete!";
                    return true;
                } else {
                    return "Invalid password!";
                }
            } else {
                return "No user found with this email!";
            }
        } else {
            return "Please enter email and password.";
        }
    }
}
?>
