<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Quizzionaire | Login</title>

    <?php
    include "../DB/connect.php";
    ?>
</head>

<body>
    <header class="p-5 bg-blue-700 rounded-b-xl">
        <p class="text-2xl font-semibold text-white">Quizzionaire</p>
    </header>
    <main class="p-15">
        <form  method="post" action="connect.php">
        <div class="flex flex-col justify-center  bg-white p-12 rounded-lg shadow-2xl">
            <p class="font-semibold text-3xl text-center">Welcome Back!</p>
            <p class="text-center mb-5">Ready for some exicting quizzez?</p>
            <label class="mb-2">Username:</label>
            <input type="text" placeholder="Enter your username" class="border-1 rounded-lg border-gray-400 p-2 mb-4">
            <label class="mb-2">Password:</label>
            <input type="password" placeholder="Enter your password" class="border-1 rounded-lg border-gray-400 p-2 mb-5">
            <div class="flex gap-2 flex-col md:flex-row">
                <button type="submit" class="p-2 bg-blue-700 w-full md:w-[48%] text-white font-bold rounded-lg justify-center">Login Now</button>
                <button type="reset" class="p-2 bg-red-700 w-full md:w-[48%] text-white font-bold rounded-lg justify-center">Clear</button>
            </div>
            <p class="text-sm text-center pt-3">Don't have an account yet? <a href="index.php" class="text-blue-700 underline">Register here</a></p>
        </div>
        </form>
    </main>
</body>

</html>