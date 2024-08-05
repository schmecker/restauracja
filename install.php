<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Instalator</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $config_file = 'config/config.php';

        function url_origin($s, $use_forwarded_host = false) {
            $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
            $sp = strtolower($s['SERVER_PROTOCOL']);
            $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
            $port = $s['SERVER_PORT'];
            $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
            $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
            $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
            return $protocol . '://' . $host;
        }

        function full_url($s, $use_forwarded_host = false) {
            return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
        }

        $url = pathinfo(full_url($_SERVER));
        $base_url = $url['dirname'] . "/";

        function form_install_1() {
            global $base_url;
            echo '<div class="card form-container">
                    <div class="card-body">
                        <h2>Instalator :: krok: 1</h2>
                        <h3>Instalacja serwisu</h3>
                        <form method="post" action="install.php?step=2">
                                                    <span>Te informacje musisz uzyskac od administratora serwera.</span>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="db_host" name="db_host" placeholder="Nazwa lub adres serwera" required>
                                <label for="db_host">Nazwa lub adres serwera:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="db_name" name="db_name" placeholder="Nazwa bazy danych" required>
                                <label for="db_name">Nazwa bazy danych:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="db_user" name="db_user" placeholder="Nazwa uzytkownika" required>
                                <label for="db_user">Nazwa uzytkownika:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="db_pass" name="db_pass" placeholder="Haslo">
                                <label for="db_pass">Haslo:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="table_prefix" name="table_prefix" placeholder="Prefix tabeli">
                                <label for="table_prefix">Prefix tabeli:</label>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Krok 2">
                        </form>
                    </div>
                </div>';
        }

        function step2() {
            global $config_file;
            $db_host = $_POST['db_host'];
            $db_name = $_POST['db_name'];
            $db_user = $_POST['db_user'];
            $db_pass = $_POST['db_pass'];
            $table_prefix = $_POST['table_prefix'];

            $config = "<?php\n";
            $config .= "\$host=\"$db_host\";\n";
            $config .= "\$user=\"$db_user\";\n";
            $config .= "\$password=\"$db_pass\";\n";
            $config .= "\$dbname=\"$db_name\";\n";
            $config .= "\$prefix=\"$table_prefix\";\n";
            $config .= "\$link = mysqli_connect(\$host, \$user, \$password, \$dbname);\n";

            $file = fopen($config_file, "w");
            if (!$file) {
                die("Nie moge otworzyc pliku ($config_file)");
            }
            if (!fwrite($file, $config)) {
                die("Nie moge zapisac do pliku ($config_file)");
            }
            fclose($file);

            echo '<div class="alert alert-success mt-3" role="alert">Krok 2 zakonczony: Plik konfiguracyjny utworzony</div>';
            echo '<a href="install.php?step=3" class="btn btn-primary mt-3">Krok 3</a>';
        }

        function step3() {
            global $config_file;
            include($config_file);

            if (file_exists("sql/create.sql")) {
                echo '<div class="alert alert-info mt-3" role="alert">Tworze tabele bazy: ' . $dbname . '.</div>';
                $link = mysqli_connect($host, $user, $password, $dbname);
                if (!$link) {
                    echo '<div class="alert alert-danger" role="alert">Nie mozna polaczyc sie z baza danych: ' . mysqli_connect_error() . '</div>';
                    return;
                }
                mysqli_select_db($link, $dbname) or die(mysqli_error($link));

                $sql = file_get_contents("sql/create.sql");
                $commands = explode(';', $sql);

                foreach ($commands as $command) {
                    if (trim($command)) {
                        if (!mysqli_query($link, $command)) {
                            echo '<div class="alert alert-danger" role="alert">Blad wykonania polecenia: ' . mysqli_error($link) . '</div>';
                        }
                    }
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Brak pliku sql/create.sql.</div>';
            }
            echo '<a href="install.php?step=4" class="btn btn-primary mt-3">Krok 4</a>';
        }

        function step4() {
            global $config_file;
            include($config_file);

            if (file_exists("sql/insert.sql")) {
                echo '<div class="alert alert-info mt-3" role="alert">Wstawiam dane do tabel bazy: ' . $dbname . '.</div>';
                $link = mysqli_connect($host, $user, $password, $dbname);
                if (!$link) {
                    echo '<div class="alert alert-danger" role="alert">Nie mozna polaczyc sie z baza danych: ' . mysqli_connect_error() . '</div>';
                    return;
                }
                mysqli_select_db($link, $dbname) or die(mysqli_error($link));

                $sql = file_get_contents("sql/insert.sql");
                $commands = explode(';', $sql);

                foreach ($commands as $command) {
                    if (trim($command)) {
                        if (!mysqli_query($link, $command)) {
                            echo '<div class="alert alert-danger" role="alert">Blad wykonania polecenia: ' . mysqli_error($link) . '</div>';
                        }
                    }
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Brak pliku sql/insert.sql.</div>';
            }
            echo '<a href="install.php?step=5" class="btn btn-primary mt-3">Krok 5</a>';
        }

        function step5() {
            global $base_url;
            echo '<div class="card form-container">
                    <div class="card-body">
                        <h2>Instalator :: krok: 5</h2>
                        <form method="post" action="install.php?step=6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Nazwa serwisu" required>
                                <label for="service_name">Nazwa serwisu:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="app_name" name="app_name" placeholder="Nazwa aplikacji" required>
                                <label for="app_name">Nazwa aplikacji:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="base_url" name="base_url" placeholder="Adres serwisu" required value="' . $base_url . '">
                                <label for="base_url">Adres serwisu:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="creation_date" name="creation_date" required value="' . date('Y-m-d') . '">
                                <label for="creation_date">Data powstania:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="version" name="version" placeholder="Wersja" required>
                                <label for="version">Wersja:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Nazwa firmy" required>
                                <label for="company_name">Nazwa firmy:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="street" name="street" placeholder="Ulica" required>
                                <label for="street">Ulica:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Miasto, kod" required>
                                <label for="city">Miasto, kod:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefon" required>
                                <label for="phone">Telefon:</label>
                            </div>
                            <h3>Konto administratora</h3>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="admin_login" name="admin_login" placeholder="Login Administratora" required>
                                <label for="admin_login">Login Administratora:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Haslo Administratora" required>
                                <label for="admin_password">Haslo Administratora:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="admin_password_confirm" name="admin_password_confirm" placeholder="Potwierdzenie hasla Administratora" required>
                                <label for="admin_password_confirm">Potwierdzenie hasla Administratora:</label>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Krok 6">
                        </form>
                    </div>
                </div>';
        }

        function step6() {
            global $config_file;
            include($config_file);
        
            if ($_POST['admin_password'] !== $_POST['admin_password_confirm']) {
                die('<div class="alert alert-danger mt-3" role="alert">Hasla nie pasuja do siebie.</div>');
            }
        
            $config = "\n# konfiguracja aplikacji\n";
            $config .= "\$service_name=\"" . $_POST['service_name'] . "\";\n";
            $config .= "\$app_name=\"" . $_POST['app_name'] . "\";\n";
            $config .= "\$base_url=\"" . $_POST['base_url'] . "\";\n";
            $config .= "\$creation_date=\"" . $_POST['creation_date'] . "\";\n";
            $config .= "\$version=\"" . $_POST['version'] . "\";\n";
            $config .= "\$company_name=\"" . $_POST['company_name'] . "\";\n";
            $config .= "\$street=\"" . $_POST['street'] . "\";\n";
            $config .= "\$city=\"" . $_POST['city'] . "\";\n";
            $config .= "\$phone=\"" . $_POST['phone'] . "\";\n";
        
            if (is_writable($config_file)) {
                if (!$file = fopen($config_file, 'a')) {
                    die('<div class="alert alert-danger mt-3" role="alert">Nie moge otworzyc pliku (' . $config_file . ')</div>');
                }
                if (fwrite($file, $config) === FALSE) {
                    die('<div class="alert alert-danger mt-3" role="alert">Nie moge zapisac do pliku (' . $config_file . ')</div>');
                }
                fclose($file);
                echo '<div class="alert alert-success mt-3" role="alert">Sukces, zapisano konfiguracje do pliku (' . $config_file . ')</div>';
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">Plik ' . $config_file . ' nie jest zapisywalny</div>';
            }
        
            $admin_login = $_POST['admin_login'];
            $admin_password = $_POST['admin_password'];  // Bez hashowania
            $admin_email = 'admin@example.com';
        
            $insert = [];
            $insert[] = "INSERT INTO `" . $prefix . "registration` (`id`, `userid`, `password`, `email`) VALUES (1, '$admin_login', '$admin_password', '$admin_email') ON DUPLICATE KEY UPDATE `userid`='$admin_login', `password`='$admin_password', `email`='$admin_email';";
        
            $link = mysqli_connect($host, $user, $password, $dbname);
            if (!$link) {
                echo '<div class="alert alert-danger" role="alert">Nie mozna polaczyc sie z baza danych: ' . mysqli_connect_error() . '</div>';
                return;
            }
            mysqli_select_db($link, $dbname) or die(mysqli_error($link));
            foreach ($insert as $query) {
                if (!mysqli_query($link, $query)) {
                    echo '<div class="alert alert-danger" role="alert">Blad wykonania polecenia: ' . mysqli_error($link) . '</div>';
                }
            }
        
            echo '<div class="alert alert-success mt-3" role="alert">Instalacja zakonczona. Prosze usunac plik <code>install.php</code> i zmienic uprawnienia do pliku <code>config/config.php</code> na tylko do odczytu.</div>';
            echo '<a href="index.php" class="btn btn-primary mt-3">Przejdz do strony glownej</a>';
        }
        
        

        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

        switch ($step) {
            case 2:
                step2();
                break;
            case 3:
                step3();
                break;
            case 4:
                step4();
                break;
            case 5:
                step5();
                break;
            case 6:
                step6();
                break;
            default:
                if (file_exists($config_file)) {
                    if (is_writable($config_file)) {
                        form_install_1();
                    } else {
                        echo '<div class="alert alert-warning mt-3" role="alert">Zmien uprawnienia do pliku <code>' . $config_file . '</code><br>np. <code>chmod o+w ' . $config_file . '</code></div>';
                        echo '<p><button class="btn btn-info" onClick="window.location.href=window.location.href">Odswiez strone</button></p>';
                    }
                } else {
                    echo '<div class="alert alert-warning mt-3" role="alert">Stworz plik <code>' . $config_file . '</code><br>np. <code>touch ' . $config_file . '</code></div>';
                    echo '<p><button class="btn btn-info" onClick="window.location.href=window.location.href">Odswiez strone</button></p>';
                }
                break;
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
