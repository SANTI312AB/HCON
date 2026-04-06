# HCON **1.3**



## Getting started

To make it easy for you to get started with GitLab, here's a list of recommended next steps.

Already a pro? Just edit this README.md and make it your own. Want to make it easy? [Use the template at the bottom](#editing-this-readme)!

## Add your files

* [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
* [Add files using the command line](https://docs.gitlab.com/topics/git/add_files/#add-files-to-a-git-repository) or push an existing Git repository with the following command:

```
cd existing_repo
git remote add origin https://gitlab.com/hcon1/hcon.git
git branch -M main
git push -uf origin main
```

<p align="center">
  <img src="https://symfony.com/logos/symfony_black_03.png" alt="Symfony" width="200"/>
</p>

# Proyecto Symfony

Este proyecto utiliza el framework **Symfony 5.4**, un framework PHP moderno y robusto para el desarrollo de aplicaciones web.

## Requisitos

- PHP >= 8.2
- Composer
- Extensiones PHP recomendadas: `php_sqlsrv`, `openssl`, `sodium`, `mbstring`, `xml`
- Base de datos SQL Lite o SQL Server (2019,2022)
- Assets Jquery y Bostrap

## Instalación

1. Clona el repositorio:
   ```bash
   git clone <URL-del-repositorio>
   cd seven
   ```

2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Copia el archivo de entorno y configura tus variables:
   ```bash
   cp .env .env.local
   # Edita .env.local con tus credenciales de base de datos.
   ```

4. (Opcional) Instala dependencias de frontend:
   ```bash
   yarn install
   # o
   npm install
   ```


## Comandos útiles para la base de datos

### Crear la base de datos

```bash
php bin/console doctrine:database:create
```

### Crear las tablas (migraciones)

```bash
php bin/console doctrine:migrations:migrate
```

### Generar una nueva migración

```bash
php bin/console make:migration
```

### Actualizar el esquema de la base de datos

```bash
php bin/console doctrine:schema:update --force
```

---
### Instrucciones para SQL Server

La base de datos debe importarse desde el archivo `.bak` ubicado en `/var/opt/mssql/import` usando SQL Server Management Studio. Nota: la base de datos no se crea automáticamente en el contenedor Docker.



