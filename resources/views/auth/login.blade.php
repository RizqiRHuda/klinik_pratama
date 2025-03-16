<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Login Page" />
    <meta name="author" content="Admin" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0077b6, #00b4d8, #90e0ef, #ffffff);
            height: 100vh;
        }
        .login-container {
            max-width: 850px;
            width: 100%;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .login-info {
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 2rem;
            text-align: center;
        }
        .login-info h3 {
            font-weight: bold;
        }
        .form-control {
            border-radius: 25px;
            padding-left: 45px;
        }
        .input-group-text {
            border-radius: 25px 0 0 25px;
            background: white;
            border-right: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0077b6;
        }
        .btn-primary {
            background: #0077b6;
            border: none;
            border-radius: 25px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #005f8a;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="login-container row">
        <div class="col-md-6 p-4">
            <h3 class="text-center font-weight-light mb-4">Login</h3>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input class="form-control @error('login') is-invalid @enderror" 
                        id="inputLogin" 
                        type="text" 
                        name="login" 
                        placeholder="Username" 
                        value="{{ old('login') }}" 
                        required autofocus />
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input class="form-control @error('password') is-invalid @enderror" 
                        id="inputPassword" 
                        type="password" 
                        name="password" 
                        placeholder="Password" 
                        required />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
        <div class="col-md-6 login-info">
            <h3>Selamat Datang!</h3>
            <p>Masukkan username dan password Anda untuk mengakses sistem.</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
