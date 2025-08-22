<!-- forget-password.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forget Password</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #000;
        }

        section {
            position: absolute;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2px;
            flex-wrap: wrap;
            overflow: hidden;
        }

        section span {
            position: relative;
            display: block;
            width: calc(6.25vw - 2px);
            height: calc(6.25vw - 2px);
            background: #181818;
            z-index: 2;
            transition: 1.5s;
        }

        section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(#000, #0f0, #000);
            animation: animate 5s linear infinite;
        }

        @keyframes animate {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100%);
            }
        }

        section span:hover {
            background: #0f0;
            transition: 0s;
        }

        .signin {
            position: absolute;
            width: 400px;
            background: #222;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .content {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .content h2 {
            color: #0f0;
            font-size: 2em;
            text-transform: uppercase;
        }

        .form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .inputBx {
            position: relative;
            width: 100%;
        }

        .inputBx input {
            width: 100%;
            background: #333;
            border: none;
            outline: none;
            padding: 15px;
            border-radius: 4px;
            color: #fff;
            font-size: 1em;
        }

        .form .links {
            display: flex;
            justify-content: space-between;
        }

        .form .links a {
            color: #fff;
            text-decoration: none;
        }

        .form input[type="submit"] {
            background: #0f0;
            color: #000;
            font-weight: bold;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .back-link {
            color: #0f0;
            margin-top: 10px;
            text-align: center;
            display: block;
        }

        .text-danger {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <section>
        @for ($i = 0; $i < 200; $i++)
            <span></span>
        @endfor

        <div class="signin">
            <div class="content">
                <h2>Forget Password</h2>
                <div class="form">
                    {{-- Message Alerts --}}
                    @if ($message = Session::get('opt_modal'))
                        <div class="text-success">{{ $message }}</div>
                    @endif
                    @if ($message = Session::get('error_otp_check'))
                        <div class="text-danger">{{ $message }}</div>
                    @endif

                    {{-- Change Password --}}
                    @if (session()->has('forget_otp'))
                        <form action="{{ route('ADMIN.New.pass') }}" method="POST">
                            @csrf
                            <div class="inputBx">
                                <input type="password" name="password" placeholder="New Password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <br>
                            <div class="inputBx">
                                <input type="password" name="" placeholder="Confirm Password">
                            </div>
                            <br>
                            <input type="submit" value="Update Password">
                        </form>

                        {{-- Verify OTP --}}
                    @elseif (session()->has('verify_email'))
                        <form action="{{ route('ADMIN.Check.otp') }}" method="POST">
                            @csrf
                            <div class="inputBx">
                                <input type="number" name="otp" placeholder="Enter OTP">

                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>
                            <input type="submit" value="Check OTP">
                        </form>

                        {{-- Email Input --}}
                    @else
                        <form action="{{ route('ADMIN.Check.Verify') }}" method="POST">
                            @csrf
                            <div class="inputBx">
                                <input type="email" name="email" placeholder="Enter your Email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>
                            <input type="submit" value="Send OTP">
                        </form>
                    @endif

                    <a href="{{ route('login.add') }}" class="back-link">Back to Sign In?</a>
                </div>
            </div>
        </div>
    </section>

    @include('tostar_msg.tostar')

</body>

</html>
