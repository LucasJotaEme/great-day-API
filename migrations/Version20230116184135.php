<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116184135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499381A8D8');
        $this->addSql('DROP INDEX UNIQ_8D93D6499381A8D8 ON user');
        $this->addSql('ALTER TABLE user DROP worker_user_id');
        $this->addSql('ALTER TABLE worker_user ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE worker_user ADD CONSTRAINT FK_46566018A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_46566018A76ED395 ON worker_user (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD worker_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499381A8D8 FOREIGN KEY (worker_user_id) REFERENCES worker_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499381A8D8 ON user (worker_user_id)');
        $this->addSql('ALTER TABLE worker_user DROP FOREIGN KEY FK_46566018A76ED395');
        $this->addSql('DROP INDEX UNIQ_46566018A76ED395 ON worker_user');
        $this->addSql('ALTER TABLE worker_user DROP user_id');
    }
}
