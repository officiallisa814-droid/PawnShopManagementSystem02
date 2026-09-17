<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Pawn Shop System</title>
   
</head>
<style>
       body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ebf3f7; /* ពណ៌ផ្ទៃខាងក្រោយខៀវស្រាលដូចក្នុងរូបភាព */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-card-signup {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); /* ស្រមោលទន់ៗដូចក្នុងរូបភាព */
            width: 100%;
            max-width: 380px; /* ទំហំប្រអប់ស្តង់ដារកណ្តាលអេក្រង់ */
            text-align: center;
        }

        h2 {
            color: #000000; /* អក្សរខ្មៅដិតច្បាស់លាស់ */
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
            border: 1px solid #e2e8f0; /* បន្ទាត់ប្រអប់ស្តើងស្រាលដូចក្នុងរូបភាព */
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            color: #334155;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        /* ពេលឃ្លីកលើប្រអប់បញ្ចូលទិន្នន័យ */
        .input-field input:focus {
            outline: none;
            border-color: #029676; /* ពណ៌បៃតងពេល Focus */
            box-shadow: 0 0 0 3px rgba(2, 150, 118, 0.1);
        }

        /* ប៊ូតុងចុចលោតពណ៌បៃតងដូចក្នុងរូបភាព */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #029676; /* ពណ៌បៃតងដូចក្នុងរូបភាពបេះបិទ */
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            margin-top: 10px;
            transition: background-color 0.2s ease;
        }

        .submit-btn:hover {
            background-color: #027a5e; /* ពណ៌បៃតងចាស់ជាងមុនបន្តិចពេលដាក់ Mouse លើ */
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
            font-size: 12px;
            display: block;
            text-align: left;
            margin-top: 4px;
        }
    </style>

<body>

    <!-- SIGNUP FORM CARD CONTAINER -->
    <div class="form-card-signup">
        <h2>Signup</h2>

        <!-- 1. Form posts input values straight to signup handler route -->
        <form action="{{ route('signup') }}" method="POST">
            <!-- 2. Security token tag required by Laravel to prevent hackers -->
            @csrf

            <!-- 3. New Input Field: Added user full name parameter -->
            <div class="input-field">
                <input type="text" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                @error('name') <span style="color: #ef4444; font-size: 12px; display: block; text-align: left;">{{ $message }}</span> @enderror
            </div>

            <div class="input-field">
                <!-- Added name="email" attribute to connect with database -->
                <input type="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                @error('email') <span style="color: #ef4444; font-size: 12px; display: block; text-align: left;">{{ $message }}</span> @enderror
            </div>

            <div class="input-field">
                <!-- Added name="password" attribute to track secret characters -->
                <input type="password" name="password" placeholder="Create a password (min 6 chars)" required>
                @error('password') <span style="color: #ef4444; font-size: 12px; display: block; text-align: left;">{{ $message }}</span> @enderror
            </div>

            <div class="input-field">
                <!-- Added name="password_confirmation" attribute for verification matching -->
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="submit-btn">Signup</button>

            <div class="switch-text">
                <!-- Link route sends users directly back to sign in layouts window -->
                Already have an account? <a href="{{ route('login') }}" class="login">Login</a>
            </div>
        </form>
    </div>

</body>

</html>
