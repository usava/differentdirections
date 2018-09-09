<?php require_once __DIR__ . '/vendor/autoload.php'; ?>
<html>
<head>
    <title>All different directions</title>
</head>
<body>
    <form method="post" id="form">
        <label for="input">Input</label>
        <br>
        <textarea name="input" id="input" cols="100" rows="10"><?php echo $_POST['input'] ?? ''; ?></textarea>
        <br>
        <button id="submit" type="submit">Submit</button>
        <button id="clear" type="button">Clear</button>
    </form>
    <div id="result">
    <?php if (isset($_POST['input']) && $_POST['input']): ?>
        <h2>Result:</h2>
        <p><?php echo App\Nav::make($_POST['input'])->calc(); ?></p>
    <?php endif; ?>
    </div>
    <script>
        let clear = () => {
            document.getElementById('input').value = '';
            document.getElementById('result').style.display = 'none';
        };
        document.getElementById('clear').onclick = clear;
        window.onkeydown = (event) => {
            if (event.key === "Enter") {
                if (event.ctrlKey || event.metaKey) {
                    document.getElementById('submit').click();
                }
            } else if (event.key == "Escape") {
                clear();
            }
        }
    </script>
</body>
</html>