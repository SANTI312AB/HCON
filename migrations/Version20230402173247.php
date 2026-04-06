<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402173247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ant_heredofamiliares ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_heredofamiliares ADD updatedate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_laborales ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_laborales ADD updatedate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_no_patologicos ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_no_patologicos ADD updatedate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_patologicos ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_patologicos ADD updatedate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_quirugicos ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_quirugicos ADD updatedate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_reproductivos ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE ant_reproductivos ADD updatedate DATETIME2(6)');
        $this->addSql('ALTER TABLE otros_antecedentes ADD creatdate DATETIME2(6)');
        $this->addSql('ALTER TABLE otros_antecedentes ADD updatedate DATETIME2(6)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('ALTER TABLE ant_heredofamiliares DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE ant_heredofamiliares DROP COLUMN updatedate');
        $this->addSql('ALTER TABLE ant_laborales DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE ant_laborales DROP COLUMN updatedate');
        $this->addSql('ALTER TABLE ant_no_patologicos DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE ant_no_patologicos DROP COLUMN updatedate');
        $this->addSql('ALTER TABLE ant_patologicos DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE ant_patologicos DROP COLUMN updatedate');
        $this->addSql('ALTER TABLE ant_quirugicos DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE ant_quirugicos DROP COLUMN updatedate');
        $this->addSql('ALTER TABLE ant_reproductivos DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE ant_reproductivos DROP COLUMN updatedate');
        $this->addSql('ALTER TABLE otros_antecedentes DROP COLUMN creatdate');
        $this->addSql('ALTER TABLE otros_antecedentes DROP COLUMN updatedate');
    }
}
