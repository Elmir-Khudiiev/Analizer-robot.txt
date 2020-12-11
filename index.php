<!doctype html>
<html lang="en">

    <head>
        <title>Analyzer "Robots.txt"</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="assets/img/analyzer_favicon.png" type="image/x-icon">

        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <section class="top-section">
            <div class="container">
                <div class="header">
                    <div class="logo">
                        <a href="/"><img src="assets/img/analyzer_logo.png" alt="logo"></a>
                    </div>
                    <div class="robot">
                        <form action="router.php" method="post">
                            <label>
                                <input class="area" required placeholder="Insert your link" type="text" name="url">
                            </label>
                            <button type="submit" class="btn btn-primary">Start check</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div id="result"></div>
                <div class="description">
                    <hr class="line">
                    <h1>Robots.txt file analysis service</h1>
                    <h4>Checklist:</h4>
                    <ol>
                        <li>Checking for a <b>robots.txt</b> file</li>
                        <li>Checking the Host Directive Specification</li>
                        <li>Checking the number of Host directives written in the file</li>
                        <li>Checking <b>robots.txt</b> file size</li>
                        <li>Checking the Sitemap directive</li>
                        <li>Checking the server response code for a <b>robots.txt</b> file</li>
                    </ol>
                    <h4>After checking the file, the status and recommendations are displayed.</h4>
                </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="assets/js/script.js"></script>

    </body>

</html>