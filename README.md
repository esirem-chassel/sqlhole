# sqlhole

## Installation sur un Kali Linux

S'assurer que nginx est installé, puis installer php-fpm.

> [!Caution]
> Si vous avez une erreur sur Kali Linux de signature GPG à l'installation, vous devez [effectuer une opération de validation supplémentaire avant de relancer l'installation](https://www.kali.org/blog/new-kali-archive-signing-key/).

Une fois php-fpm installé, modifiez la configuration de nginx pour activer PHP (lignes à décommenter sur la partie PHP) et modifiez la version de php-fpm en utilisant la version installée.

Activez ensuite php-fpm (service php<version>-fpm start), nginx (service nginx restart) et mysql (service mysql start).

## Téléchargement et installation de l'applicatif

> [!Info]
> L'installation fonctionne sans différences sur Windows (WAMP/XAMPP) et Linux/Unix (nginx).

Sur votre système, effectuez un git clone de l'application dans le répertoire web.
Créez, dans votre MySQL, une base nommée `uas`. Vérifiez les droits et modifiez `db.php` au besoin.

Lancez, en ligne de commande, le init.php : `php init.php`.

Accédez ensuite à votre dossier depuis votre web local.
