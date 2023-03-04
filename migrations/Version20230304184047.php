<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304184047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_cooking_time (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cooking_time_id INT NOT NULL, INDEX IDX_6C6C8A66A76ED395 (user_id), INDEX IDX_6C6C8A66BDAF43F3 (cooking_time_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_cooking_time ADD CONSTRAINT FK_6C6C8A66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_cooking_time ADD CONSTRAINT FK_6C6C8A66BDAF43F3 FOREIGN KEY (cooking_time_id) REFERENCES cooking_time (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_cooking_time DROP FOREIGN KEY FK_6C6C8A66A76ED395');
        $this->addSql('ALTER TABLE user_cooking_time DROP FOREIGN KEY FK_6C6C8A66BDAF43F3');
        $this->addSql('DROP TABLE user_cooking_time');
    }
}
