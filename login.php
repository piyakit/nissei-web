<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 20px;
            background: #eee;
        }

        .container {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
        }

        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }



        .card-columns .card {
            margin-bottom: 1.25rem;
        }

        @media (min-width: 576px) {
            .card-columns {
                column-count: 3;
                column-gap: 1.25rem;
            }

            .card-columns .card {
                display: inline-block;
                width: 100%;
            }
        }

        .text-muted {
            color: #9faecb !important;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .input-group {
            position: relative;
            display: flex;
            width: 100%;
        }
    </style>
</head>


<body style="background-color:#4473c4;">
        <form action="login_process.php" method="post">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group mb-0">
                        <div class="card p-4">
                            <div class="card-body">
                                <h1>Login</h1>
                                <p class="text-muted">กรุณาลงชื่อเข้าสู่ระบบ</p>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                                </div>
                                <div class="input-group mb-4">
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4">เข้าสู่ระบบ</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-link px-0">ลืมรหัสผ่าน</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-white py-5 d-md-down-none" style="width: 44%;">
                            <div class="card-body text-center">
                            <img src="./image/Logo7777.png" alt="Image" class="img-fluid" style="height: 100%; width: 100%; object-fit: contain">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
</body>

</html>