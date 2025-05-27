<?php
require_once 'db.php';

session_start();
if(!empty($_REQUEST['action'])
    && ('logout' == $_REQUEST['action'])) {
    $_SESSION['id'] = null;
    $_SESSION['email'] = null;
}
$auth = !empty($_SESSION['id']);
$usr = null;
if ($auth) {
    $cu = $_SESSION['email']; // $_SESSION est stocké coté serveur, pas client
    $usr = $sql->query("select * from `users` where `email`='$cu'")->fetch(PDO::FETCH_ASSOC);
} else {
    if (!empty($_REQUEST['subscribe'])) {
        $email = $_REQUEST['email'];
        $pwd = $_REQUEST['pwd'];
        $birthdate = $_REQUEST['birthdate'];
        $sql->query("insert into `users` (`email`, `pwd`, `birthdate`) values('$email', '$pwd', '$birthdate')");
    } elseif (!empty($_REQUEST['login'])) {
        $email = $_REQUEST['email'];
        $pwd = $_REQUEST['pwd'];
        $r = $sql->query("select * from `users` where email='$email' and pwd='$pwd'");
        if ($l = $r->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['id'] = $l['id'];
            $_SESSION['email'] = $l['email'];
            $auth = true;
            $usr = $l;
        }
    }
}

if (!empty($_REQUEST['del'])) {
    $sql->query("delete from addresses where id=" . $_REQUEST['del']);
}

$w = '';
$addresses = [];
if ($auth) {
    if(!empty($_REQUEST['add'])) {
        $sql->prepare('insert into addresses (user, content) values(:u, :c)')->execute([
            'u' => $_SESSION['id'],
            'c' => $_REQUEST['content'],
        ]);
    }

    $q = "select * from `addresses` where user=" . $_SESSION['id'];
    if (!empty($_REQUEST['where'])) {
        $w = $_REQUEST['where'];
        $q .= " and content like '%$w'";
    }
    $l = $sql->query($q);
    $addresses = $l->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (!$auth) { ?><fieldset>
            <legend>Connexion</legend>
            <form method="post" action="index.php">
                <p>
                    <label>
                        Email
                        <input type="email"
                            required="required"
                            name="email" />
                    </label>
                </p>
                <p>
                    <label>
                        Password
                        <input type="password"
                            required="required"
                            name="pwd" />
                    </label>
                </p>
                <p>
                    <input type="submit"
                        name="login"
                        value="Se connecter" />
                </p>
            </form>
        </fieldset>
        <fieldset>
            <legend>Inscription</legend>
            <form method="post" action="index.php">
                <p>
                    <label>
                        Email
                        <input type="email"
                            required="required"
                            name="email" />
                    </label>
                </p>
                <p>
                    <label>
                        Password
                        <input type="password"
                            required="required"
                            name="pwd" />
                    </label>
                </p>
                <p>
                    <label>
                        Birth date
                        <input type="date"
                            required="required"
                            name="birthdate" />
                    </label>
                </p>
                <p>
                    <input type="submit"
                        name="subscribe"
                        value="Valider l'inscription" />
                </p>
            </form>
        </fieldset>
    <?php } else { ?>
        <p>
            Connecté en tant que
            <?php echo $usr['email']; ?>
            -
            <a href="index.php?action=logout">Déconnexion</a>
        </p>
        <fieldset>
            <legend>Nouvelle adresse</legend>
            <form method="post" action="index.php">
                <p>
                    <textarea name="content"></textarea>
                    <input type="submit" name="add" value="Ajouter cette adresse" />
                </p>
            </form>
        </fieldset>
        <fieldset>
            <legend>Adresses existantes</legend>
            <form method="post" action="index.php">
                <p>
                    <input type="search"
                        name="where"
                        value="<?php echo $w; ?>"
                        placeholder="Recherche" />
                    <input type="submit" value="Rechercher" />
                </p>
            </form>
            <?php foreach ($addresses as $addr) { ?>
                <p>
                    <?php echo $addr['content']; ?>
                    <a href="index.php?del=<?php echo $addr['id']; ?>">
                        Supprimer
                    </a>
                </p>
            <?php } ?>
        </fieldset>
    <?php } ?>
</body>

</html>
