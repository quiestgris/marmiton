<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250628221947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_IDENTIFIER_EMAIL ON `admin`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `admin` ADD name VARCHAR(50) NOT NULL, ADD pseudonyme VARCHAR(50) DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', DROP password, CHANGE email email VARCHAR(50) NOT NULL, CHANGE roles roles VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD roles VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `admin` ADD password VARCHAR(255) NOT NULL, DROP name, DROP pseudonyme, DROP created_at, CHANGE roles roles JSON NOT NULL, CHANGE email email VARCHAR(180) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON `admin` (email)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP roles
        SQL);
    }
}
