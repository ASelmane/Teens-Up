<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315175046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_sports (users_id INT NOT NULL, sports_id INT NOT NULL, INDEX IDX_7C2E778C67B3B43D (users_id), INDEX IDX_7C2E778C54BBBFB7 (sports_id), PRIMARY KEY(users_id, sports_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_sports ADD CONSTRAINT FK_7C2E778C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_sports ADD CONSTRAINT FK_7C2E778C54BBBFB7 FOREIGN KEY (sports_id) REFERENCES sports (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_sports');
    }
}
