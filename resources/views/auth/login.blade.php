<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e8e9ff 0%, #f0f1ff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(28, 34, 96, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(28, 34, 96, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(28, 34, 96, 0.15);
            padding: 60px;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .login-title {
            font-size: 28px;
            font-weight: 300;
            color: #333;
            margin-bottom: 40px;
            text-align: left;
            position: relative;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 40px;
            height: 2px;
            background: #1c2260;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-input {
            width: 100%;
            padding: 15px 0 15px 45px;
            border: none;
            border-bottom: 2px solid #e0e0e0;
            background: transparent;
            font-size: 16px;
            color: #333;
            outline: none;
        }

        .form-input:focus {
            border-bottom-color: #1c2260;
        }

        .form-input::placeholder {
            color: #999;
            font-weight: 300;
        }

        .input-icon {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #1c2260;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .login-btn {
            width: 100%;
            background: #1c2260;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
        }

        .login-btn:hover {
            background: #151b4d;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #666;
        }

        .checkbox-wrapper {
            position: relative;
            margin-right: 10px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            opacity: 0;
            position: absolute;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            border: 2px solid #ddd;
            border-radius: 3px;
            background: white;
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"]:checked + .checkbox-custom {
            background: #1c2260;
            border-color: #1c2260;
        }

        .checkbox-wrapper input[type="checkbox"]:checked + .checkbox-custom::after {
            content: '✓';
            position: absolute;
            top: -2px;
            left: 2px;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .forgot-password {
            text-align: center;
            margin-top: 25px;
        }

        .forgot-password a {
            color: #1c2260;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            color: #151b4d;
            text-decoration: underline;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .form-input.is-invalid {
            border-bottom-color: #e74c3c;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 30px;
                margin: 20px;
            }

            .login-title {
                font-size: 24px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Login</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email"
                           class="form-input @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter your email"
                           required
                           autocomplete="email"
                           autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password"
                           class="form-input @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Enter your password"
                           required
                           autocomplete="current-password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-me">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkbox-custom"></span>
                    </div>
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit" class="login-btn">
                    Login
                </button>

                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
