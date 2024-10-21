<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Custom responsive CSS */
        body {
            background-color: #ededed;
            font-family: "Hind", sans-serif;
        }
        .signup-container {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 6px 6px 10px rgba(0, 0, 0, 0.3);
            margin: auto;
        }
        h1, p {
            color: #0B60B0;
            text-align: center;
        }
        .signup-lables {
            font-size: 20px;
            color: #0B60B0;
        }
        .signup-input {
            width: 100%;
            height: 40px;
            margin-bottom: 15px;
            font-size: 18px;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding-left: 10px;
        }
        .signup-btn {
            width: 100%;
            background-color: #0B60B0;
            color: white;
            font-size: 18px;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .signup-btn:hover {
            background-color: #084e8f;
        }
        /* Responsive Design */
        @media (max-width: 576px) {
            .signup-container {
                padding: 20px;
            }
            h1 {
                font-size: 28px;
            }
            .signup-lables {
                font-size: 18px;
            }
            .signup-input {
                font-size: 16px;
                height: 35px;
            }
            .signup-btn {
                font-size: 16px;
                padding: 8px;
            }
        }

        @media (max-width: 768px) {
            .signup-container {
                padding: 25px;
            }
            h1 {
                font-size: 30px;
            }
            .signup-lables {
                font-size: 19px;
            }
            .signup-input {
                font-size: 17px;
                height: 38px;
            }
            .signup-btn {
                font-size: 17px;
                padding: 9px;
            }
        }
    </style>
    <title>Signup - Threadly</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="signup-container">
            <form action="_handlelogin.php" class="signup-form" method="post" enctype="multipart/form-data">
                <h1>Login</h1>
                <p>Login to your account</p>
                <div class="mb-3">
                    <label for="login-username" class="signup-lables">Username:</label>
                    <input type="text" name="login-username" id="login-username" class="signup-input form-control" required>
                </div>
                <div class="mb-3">
                    <label for="login-password" class="signup-lables">Password:</label>
                    <input type="password" name="login-password" id="login-password" class="signup-input form-control" required>
                </div>
                <input type="submit" name="submit" value="Login" class="signup-btn">
                
                <!-- Create new account link -->
                <p class="mt-3 text-center">
                    Don’t have an account? 
                    <a href="/partials/_signup.php" class="text-primary">Create a new account</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
