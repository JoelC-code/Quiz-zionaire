<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Quizzionaire | Register</title>

    <?php
    include "../DB/connect.php";
    ?>
</head>

<body>
    <header class="p-5 bg-blue-700 rounded-b-xl">
        <p class="text-2xl font-semibold text-white">Quizzionaire</p>
    </header>
    <main class="p-15">
        <form method="post" action="../DB/register.php">
            <div class="flex flex-col justify-center  bg-white p-12 rounded-lg shadow-2xl">
                <p class="font-semibold text-3xl text-center">Hello There!</p>
                <p class="text-center mb-5">Let's know each other better by making your account!</p>
                <label class="mb-2">Username:</label>
                <input type="text" name="userAccount" placeholder="Enter your username" class="border-1 rounded-lg border-gray-400 p-2 mb-4" required>
                <label class="mb-2">Password:</label>
                <input type="password" name="pwdAccount" placeholder="Enter your password" maxlength="100" minlength="8" autocomplete="new-password" class="border-1 rounded-lg border-gray-400 p-2 mb-5" required>
                <div class="mb-5">
                    <p>Registered as</p>
                    <div class="flex flex-row md:flex-col justify-between p-2">
                        <div>
                            <input type="radio" name="statusAccount" value="Users" required>
                            <label>Student</label>
                        </div>
                        <div>
                            <input type="radio" name="statusAccount" value="Teacher" required>
                            <label>Teacher</label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 flex-col md:flex-row">
                    <button type="submit" name="register_submit" class="p-2 bg-blue-700 w-full md:w-[48%] text-white font-bold rounded-lg justify-center">Register Now</button>
                    <button type="reset" class="p-2 bg-red-700 w-full md:w-[48%] text-white font-bold rounded-lg justify-center">Clear</button>
                </div>
                <p class="text-sm text-center pt-3">Have an account already? <a href="Login.php" class="text-blue-700 underline">login here</a></p>
            </div>
        </form>
    </main>
</body>

</html>