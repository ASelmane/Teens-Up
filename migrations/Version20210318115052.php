<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318115052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversations (id INT AUTO_INCREMENT NOT NULL, last_message DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversations_users (conversations_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_A46AA05DFE142757 (conversations_id), INDEX IDX_A46AA05D67B3B43D (users_id), PRIMARY KEY(conversations_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversations_users ADD CONSTRAINT FK_A46AA05DFE142757 FOREIGN KEY (conversations_id) REFERENCES conversations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversations_users ADD CONSTRAINT FK_A46AA05D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversations_users DROP FOREIGN KEY FK_A46AA05DFE142757');
        $this->addSql('DROP TABLE conversations');
        $this->addSql('DROP TABLE conversations_users');
    }
}
