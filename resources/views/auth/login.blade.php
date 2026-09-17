<!-- LOGIN FORM -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pawn Shop System</title>
    
    <!-- 🌟 កូដស្ទីលរចនាពណ៌បៃតងដូចរូបភាពរបស់លោកអ្នកបេះបិទ ១០០% និងការពារកំហុសគាំង Form Submit -->
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ebf3f7; /* ពណ៌ផ្ទៃខាងក្រោយខៀវស្រាល */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-card {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); /* ស្រមោលទន់ៗ */
            width: 100%;
            max-width: 380px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        h2 {
            color: #000000; /* อក្សរខ្មៅដិតច្បាស់ */
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .input-field {
            margin-bottom: 18px;
            text-align: left;
        }

        .input-field input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e2e8f0; /* បន្ទាត់ប្រអប់ស្តើងស្រាល */
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            color: #334155;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .input-field input:focus {
            outline: none;
            border-color: #029676; /* ពណ៌បៃតងពេល Focus */
            box-shadow: 0 0 0 3px rgba(2, 150, 118, 0.1);
        }

        .forgot-link {
            text-align: left;
            margin-bottom: 25px;
            margin-top: 5px;
        }

        .forgot-link a {
            color: #029676;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link a:hover {
            text-decoration: underline;
        }

        /* ប៊ូតុងចុចលោតពណ៌បៃតង */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #029676; /* ពណ៌បៃតងដូចរូបថតរបស់អ្នក */
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            transition: background-color 0.2s ease;
        }

        .submit-btn:hover {
            background-color: #027a5e;
        }

        .switch-text {
            margin-top: 25px;
            font-size: 14px;
            color: #334155;
        }

        .switch-text a {
            color: #029676; /* ពណ៌លីងបៃតងប្តូរទំព័រ */
            text-decoration: none;
            font-weight: 600;
            margin-left: 3px;
        }

        .switch-text a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            display: block;
            text-align: left;
            margin-top: 5px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    
    <div class="form-card">
        <h2>Login</h2>
        
        <!-- 1. Form action posts user credentials to the login route -->
        <form action="{{ route('login') }}" method="POST">
            <!-- 2. Security token tag required by Laravel to stop layout attacks -->
            @csrf
    
            <!-- 3. Show a quick success alert alert message if user just signed up -->
            @if(session('success'))
                <div style="color: #16a34a; font-size: 13px; margin-bottom: 15px; font-weight: 600; text-align: left;">
                    {{ session('success') }}
                </div>
            @endif
    
            <div class="input-field">
                <!-- Added name="email" to match the LoginController variable fields -->
                <input type="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>
    
            <div class="input-field">
                <!-- Added name="password" to capture credentials input values safely -->
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
    
            <div class="forgot-link">
                <a href="#">Forgot password?</a>
            </div>
    
            <button type="submit" class="submit-btn">Login</button>
            
            <div class="switch-text">
                <!-- Link sends user straight to signup registration page window -->
                Don't have an account? <a href="{{ route('signup') }}" class="signup">Signup</a>
            </div>
        </form>
    </div>
</body>
</html>
